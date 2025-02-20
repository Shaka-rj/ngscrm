<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add_product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name'             => 'required|string|max:255',
        //     'main_price'       => 'required|numeric|min:0',
        //     'main_percent'     => 'required|numeric|min:0',
        //     'price'            => 'required|numeric|min:0',
        //     'vat_percent'      => 'required|numeric|min:0',
        //     'price_after_vat'  => 'required|numeric|min:0',
        //     'main_price2'      => 'required|numeric|min:0',
        //     'main_percent2'    => 'required|numeric|min:0',
        //     'price2'           => 'required|numeric|min:0',
        //     'vat_percent2'     => 'required|numeric|min:0',
        //     'price_after_vat2' => 'required|numeric|min:0',
        // ]);

        Product::create($request->all());
    
        return redirect()->route('admin.products.index')->with('success', 'Mahsulot qo‘shildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.edit_products', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Mahsulot muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Mahsulot topilmadi!');
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Mahsulot o‘chirildi!');
    }
}
