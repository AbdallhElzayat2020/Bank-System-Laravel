<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Sections::all();
        $products = Products::all();
        return view('Dashboard.products.products', compact('sections', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vlidation = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable'],
            'section_id' => ['required'],
        ], [
            'product_name.required' => 'لا يمكن ترك حقل اسم القسم فارغا يرجي ادخال الاسم ',
            'section_id.required' => 'لا يمكن انشاء منتج بدون اختيار قسم',
            // 'section_name.unique' => 'اسم القسم موجود  بالفعل لا يمكن تكرارة',
        ]);
        $products = Products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);

        return redirect()->route('products.index')->with('success', 'تم اضافة المنتج بنجاح');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // $product = Products::findOrFail($id);
        $id = Sections::where('section_name', $request->section_name)->first()->id;
        $products = Products::find($request->pro_id);


        $validation = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'product_name.required' => 'لا يمكن ترك حقل اسم المنتج فارغا، يرجى إدخال الاسم.',
            // 'section_id.required' => 'لا يمكن إنشاء منتج بدون اختيار قسم.',
            // 'section_id.exists' => 'القسم المختار غير موجود، يرجى اختيار قسم صحيح.'
        ]);

        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $products = Products::findOrFail($request->pro_id);
        $products->delete();
        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');

    }
}
