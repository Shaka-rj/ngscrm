<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Spets;
use Barryvdh\DomPDF\Facade\PDF;
use Intervention\Image\Laravel\Facades\Image;

class SpetsController extends Controller
{
    public function index()
    {
        // 1. Rasmga matn qo‘shish
        $imagePath = public_path('generated/text_image.jpg');
        $img = Image::make(public_path('images/example.jpg'));

        $img->text('PDF Matni!', 150, 150, function($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(40);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        $img->save($imagePath);

        // 2. PDF yaratish
        $imageData = base64_encode(file_get_contents($imagePath));
        $html = '<h1>PDF ichida matnli rasm</h1>
                <img src="data:image/jpeg;base64,'.$imageData.'" width="500">';

        $pdf = Pdf::loadHTML($html);
        return $pdf->download('text_image.pdf');
    }

    public function show($id) {
        $spets = Spets::findOrFail($id);
    
        dd($spets);
    }

    public function create(){
        $products = Product::all();
        
        return view('user.spets_form', compact('products'));
    }

    public function store(Request $request)
    {
        $details = [];
        $req = $request->all();

        foreach ($req as $k => $v){
            if (substr($k, 0, 1) == 's'){
                $details[substr($k, 1)]['count'] = $v;
            } elseif (substr($k, 0, 2) == 'id'){
                $details[substr($k, 2)]['id'] = $v;
            }
        }

        if (is_null($req['customer'])){
            $req['customer'] = '';
        }
        $spets = Spets::create([
            'company' => $req['company'],
            'customer' => $req['customer'],
            'summ' => 11111,
            'details' => $details
        ]);

        return redirect()->route('user.spets.show', $spets->id)->with('success', 'Spets muvaffaqiyatli yaratildi!');
    }
}
