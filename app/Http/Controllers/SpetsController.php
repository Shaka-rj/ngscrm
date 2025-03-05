<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Spets;


class SpetsController extends Controller
{
    /**
     * Yaratilgan rasm
     */
    protected $image;

    /**
     * Rasm o'lchamlari
     */
    protected $width;
    protected $height;

    /**
     * Font kattaligi
     */
    protected $fontSize;

    /**
     * Rasm uchun ranglar
     */
    protected $black;
    protected $violet;

    /**
     * Font fayl yo'li
     */
    protected $font;
    protected $fontb;

    protected function generateimage(){
        $this->width    = 1754;
        $this->height   = 1240;
        $this->fontSize = 20;
        $this->font     = public_path('fonts/ARIAL.TTF');
        $this->fontb     = public_path('fonts/ARIALBD.TTF');

        $this->image = imagecreatetruecolor($this->width, $this->height);
        imagefill($this->image, 0, 0, imagecolorallocate($this->image, 255, 255, 255));

        $this->black = imagecolorallocate($this->image, 0, 0, 0);
        $this->violet = imagecolorallocate($this->image, 18, 81, 98);
    }

    protected function text($text, $x, $y, $fontSize = null, $font = null){
        $fontSize = $fontSize ?? $this->fontSize;
        $color = $this->black;
        if ($font == 1){
            $font = $this->fontb;
        } else {
            $font = $this->font;
        }

        imagettftext($this->image, $fontSize, 0, $x, $y, $color, $font, $text);
    }

    protected function centertext($text, $y,  $fontSize = null){
        $fontSize = $fontSize ?? $this->fontSize;
        
        $bbox = imagettfbbox($fontSize, 0, $this->font, $text);
        $textWidth = $bbox[2] - $bbox[0];

        $x = ($this->width - $textWidth) / 2;

        $this->text($text, $x, $y, $fontSize);
    }

    protected function ceilcentertext($text, $x, $lenght, $y, $font = null){
        $bbox = imagettfbbox($this->fontSize, 0, $this->font, $text);
        $textWidth = $bbox[2] - $bbox[0];

        
        $xc = ($lenght - $textWidth) / 2;
        $this->text($text, $x+$xc, $y, null, $font);
    }

    protected function ceilrighttext($text, $x, $lenght, $y, $font = null){
        $bbox = imagettfbbox($this->fontSize, 0, $this->font, $text);
        $textWidth = $bbox[2] - $bbox[0];

        $xc = $lenght - $textWidth - 6;
        $this->text($text, $x+$xc, $y, null, $font);
    }

    public function index(){
       return 'ok';
    }

    public function show($id) {
        $spets = Spets::findOrFail($id);

        $date = date("d.m.Y H:i", strtotime($spets['created_at'])).". $spets[custom_id]-sonli";

        $this->generateimage();

        $this->centertext($date, 130, 24);
        $this->centertext("Spetsfikatsiya", 80, 24);
        
        $this->text("Sotuvchi: ".$spets['company'], 80, 240);
        $this->text("Xaridor: ".$spets['customer'], 900, 240);

        $texts = [
            ["N", "Nomi", "Bazaviy narx", "Ustama", "Narx", "QQS", "QQS bilan\n  narxi", "Soni", "Jami narxi", "Yaroqlilik\n muddati"]
        ];

        $i = 0;
        foreach ($spets['details'] as $v){
            $i++;

            if ($v['type_price'] == 0)
                $texts[] = [
                    $i,
                    $v['product']['name'],
                    number_format($v['product']['main_price'], 2, '.', ' '),
                    $v['product']['main_percent'].'%',
                    number_format($v['product']['price'], 2, '.', ' '),
                    $v['product']['vat_percent'].'%',
                    number_format($v['product']['price_after_vat'], 2, '.', ' '),
                    $v['count'],
                    number_format($v['summ'], 2, '.', ' '),
                    $v['product']['expired_data']
                ];
            else
            $texts[] = [
                $i,
                $v['product']['name'],
                number_format($v['product']['main_price2'], 2, '.', ' '),
                $v['product']['main_percent2'].'%',
                number_format($v['product']['price2'], 2, '.', ' '),
                $v['product']['vat_percent2'].'%',
                number_format($v['product']['price_after_vat2'], 2, '.', ' '),
                $v['count'],
                number_format($v['summ'], 2, '.', ' '),
                $v['product']['expired_data']
            ];
        }

        $texts[] = ['', "Jami:", '', '', '', '', '', '', number_format($spets['summ'], 2, '.', ' '), ''];

        $ceilxs = [50, 320, 200, 110, 200, 100, 200, 100, 220, 140];

        $lasty = 300;
        $text_count = count($texts) - 1;
        foreach($texts as $k => $v){
            $lastx = 60;
            if ($k == 0){
                $ceil_height = 80;
                $font = 1;
            } else {
                $ceil_height = 56;
                $font = null;
                if ($text_count == $k) $font = 1;
            }
        

            foreach($v as $k2 => $v2){
                imagerectangle($this->image, $lastx, $lasty, $lastx+$ceilxs[$k2], $lasty+$ceil_height, $this->black);
                
                if ($k == 0 or $k2 == 3 or $k2 == 5 or $k2 == 7)
                    $this->ceilcentertext($v2, $lastx, $ceilxs[$k2], $lasty+36, $font);
                elseif ($k2 > 1)
                    $this->ceilrighttext($v2, $lastx, $ceilxs[$k2], $lasty+36, $font);
                else
                    $this->text($v2, $lastx+6, $lasty+36, null, $font);
                $lastx += $ceilxs[$k2];
            }
            $lasty += $ceil_height;
            
        }
        
        $image = $this->image;

        $folder = 'public/spets'; 
        $filename = 'spets_'. $id . '_' . time() . '.png';
        $path = storage_path("app/$folder/$filename");
        imagepng($image, $path);
        imagedestroy($image);

    
        $url = Storage::url("$folder/$filename");

        $domain = config('app.url');
        

        Telegram::sendPhoto([
            'chat_id' => 320021926,
            'photo' =>  InputFile::create(storage_path("app/$folder/$filename")),
        ]);

        return $domain.' - '.$url;

        // return response()->stream(function () use ($image) {
        //     imagepng($image);
        //     imagedestroy($image);
        // }, 200, [
        //     'Content-Type' => 'image/png',
        //     'Cache-Control' => 'no-cache, no-store, must-revalidate',
        //     'Pragma' => 'no-cache',
        //     'Expires' => '0',
        // ]);
    }

    public function create(){
        $products = Product::all();
        
        return view('user.spets_form', compact('products'));
    }

    public function create2(){
        $products = Product::all();
        
        return view('user.spets_form2', compact('products'));
    }

    public function store(Request $request)
    {
        $products = Product::all()
            ->mapWithKeys(fn($item) => [$item->id => $item->toArray()]);

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

        $details2 = [];
        $allsumm = 0;

        if ($req['type_price'] == 0){
            foreach ($details as $v){
                if (!is_null($v['count'])){
                    $summ = $v['count'] * $products[$v['id']]['price_after_vat'];
                    $details2[] = [
                        'id'      => $v['id'],
                        'product' => $products[$v['id']],
                        'count'   => $v['count'],
                        'summ'    => $summ,
                        'type_price' => 0
                    ];
                    $allsumm += $summ;
                }
            }
        } else {
            foreach ($details as $v){
                if (!is_null($v['count'])){
                    $summ = $v['count'] * $products[$v['id']]['price_after_vat2'];
                    $details2[] = [
                        'id'      => $v['id'],
                        'product' => $products[$v['id']],
                        'count'   => $v['count'],
                        'summ'    => $summ,
                        'type_price' => 1
                    ];
                    $allsumm += $summ;
                }
            }
        }

        $user_id = session('user_id');

        $spets = Spets::create([
            'company'  => $req['company'],
            'customer' => $req['customer'],
            'summ'     => $allsumm,
            'details'  => $details2,
            'user_id'  => $user_id
        ]);

        return redirect()->route('user.spets.show', $spets->id)->with('success', 'Spets muvaffaqiyatli yaratildi!');
    }
}
