<?php

namespace App\Http\Controllers\Admin;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\User;
use App\Models\Location;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;



class UserController extends Controller
{
    // Hodimlar ruyxati
    public function index(){
        $users = User::whereIn('role', [2, 3])->with('region')->orderBy('name', 'asc')->get();

        $type = 1;
        return view('admin.user_list', compact('users', 'type'));
    }

    // Surov qoldirganlar ruyxati
    public function requests(){
        $users = User::where('role', 1)->with('region')->get();

        $type = 1;
        return view('admin.user_requests', compact('users', 'type'));
    }

    // Agent sifatida qabul qilish
    public function confirm_agent(string $id){
        $user = User::find($id);
        $user->update(['role' => User::ROLE_AGENT]);

        Telegram::sendMessage([
            'chat_id' => $user['chat_id'],
            'text' => "Tibbiy vakillikka qabul qilindingiz"
        ]);

        return redirect()->route('admin.user.requests');
    }

    // Menejer sifatida qabul qilishda hududlarni ko'rsatish (step-1)
    public function confirm_manager_regions(string $id){
        $user = User::find($id);
        $regions = Region::all();

        $type = 2;
        return view('admin.user_requests', compact('user', 'type', 'regions'));
    }

    // Menejer sifatida qabul qilish (step-2)
    public function confirm_manager(Request $request, string $id){
        $user = User::find($id);
        $selectedRegions = $request->input('regions', []);

        $user->update([
            'role' => User::ROLE_MANAGER,
            'additional' => json_encode($selectedRegions)
        ]);

        Telegram::sendMessage([
            'chat_id' => $user['chat_id'],
            'text' => "Menejerlikka qabul qilindingiz"
        ]);
    }
    
    // Userni bekor qilish
    public function cancel_user(string $id){
        $user = User::find($id);
    
        if ($user) {
            $user->forceDelete();
        }
        
        return redirect()->route('admin.user.requests');
    }

    // lokatsiyalar
    public function locations(Request $request){
        if (!isset($request->start_date) and !isset($request->end_date)){
            return view('admin.user_location');    
        } else {

            $locations = Location::whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ])->with([
                'district.region',
                'userobject.district.region',
                'doctor.userObject.district.region',
                'pharmacy.district.region',
                'user'
            ])
            ->orderByDesc('id')
            ->get();
              
            $locations_full = $locations->map(function ($location) {
                $district = null;
                $region = null;

                if ($location->type === 'district') {
                    $district = optional($location->district)->name;
                    $region = optional($location->district?->region)->name;
                } elseif ($location->type === 'doctor') {
                    $district = optional($location->doctor?->userObject?->district)->name;
                    $region = optional($location->doctor?->userObject?->district?->region)->name;
                } elseif ($location->type === 'object') {
                    $district = optional($location->userobject?->district)->name;
                    $region = optional($location->userobject?->district?->region)->name;
                } elseif ($location->type === 'pharmacy') {
                    $district = optional($location->pharmacy?->district)->name;
                    $region = optional($location->pharmacy?->district?->region)->name;
                }

                return [
                    'type' => $location->type,
                    'created_at' => $location->created_at->format('d.m.Y H:i'),
                    'district' => $district,
                    'region' => $region,
                    'object' => $location->type === 'doctor' ? optional($location->doctor?->userObject)->name : 
                               ($location->type === 'object' ? optional($location->userobject)->name : ''),
                    'doctor' => $location->type === 'doctor' ? optional($location->doctor)->firstname . ' ' . optional($location->doctor)->lastname : '',
                    'pharmacy' => $location->type === 'pharmacy' ? optional($location->pharmacy)->name : '',
                    'user_id' => $location->user_id,
                    'user_id' => optional($location->user)->id,
                    'user' => optional($location->user)->name.' '.optional($location->user)->lastname,
                ];
            });

            return $this->exportLocation($locations_full);
            dd($locations_full);
        }
        
    }

    public function exportLocation($locations)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Sarlavhalar
        $sheet->setCellValue('A1', 'Sana');
        $sheet->setCellValue('B1', 'type');
        $sheet->setCellValue('C1', 'user_id');
        $sheet->setCellValue('D1', 'Agent');
        $sheet->setCellValue('E1', 'Hudud');
        $sheet->setCellValue('F1', 'Tuman');
        $sheet->setCellValue('G1', 'Obyekt');
        $sheet->setCellValue('H1', 'Shifokor');
        $sheet->setCellValue('I1', 'Dorixona');

        $row = 2;

        foreach ($locations as $location) {
            $sheet->setCellValue('A' . $row, $location['created_at']);
            $sheet->setCellValue('B' . $row, $location['type']);
            $sheet->setCellValue('C' . $row, $location['user_id']);
            $sheet->setCellValue('D' . $row, $location['user']);
            $sheet->setCellValue('E' . $row, $location['region']);
            $sheet->setCellValue('F' . $row, $location['district']);
            $sheet->setCellValue('G' . $row, $location['object']);
            $sheet->setCellValue('H' . $row, $location['doctor']);
            $sheet->setCellValue('I' . $row, $location['pharmacy']);
            $row++;
        }

        // Faylni vaqtincha yaratamiz
        $writer = new Xlsx($spreadsheet);
        $filename = 'locations.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }

}
