<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachment;
use App\Models\Invoices_details;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    // get products from Table Products
    public function getProduct($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck("product_name", "id");

        return json_decode($products);
    }
    public function index()
    {
        $invoices = Invoices::all();
        return view('Dashboard.Invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Sections::all();
        return view('Dashboard.Invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date|after_or_equal:invoice_Date',
            'product' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
            'note' => 'nullable',
        ], [
            'invoice_number.required' => 'رقم الفاتورة مطلوب',
            'invoice_Date.required' => 'تاريخ الفاتورة مطلوب',
            'Due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'Due_date.date' => 'تاريخ الاستحقاق يجب أن يكون تاريخًا',
            'Due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون في نفس اليوم أو بعد تاريخ الفاتورة.',

        ]);


        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $user = Auth::user()->name;
        $invoice_id = Invoices::latest()->first()->id;

        Invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'notes' => $request->notes,
            'user' => $user,
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::first();
        // Notification::send($user, new AddInvoice($invoice_id));

        // $user = User::get();
        // $invoices = invoices::latest()->first();
        return redirect()->route('invoices.index')->with('success', 'تم اضافة الفاتورة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Request $request)
    {
        $invoice = Invoices::where('id', $request->id)->first();
        $sections = Sections::all();
        return view('Dashboard.Invoices.edit_invoices', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoices)
    {
        $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date|after_or_equal:invoice_Date',
            'product' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
            'note' => 'nullable',
        ], [
            'invoice_number.required' => 'لا يمكن رتك رقم الفاتورة فارغا',
            'invoice_Date.required' => 'لا يمكن ترك تاريخ الفاتورة فارغا',
            'Due_date.required' => 'لا يمكن ترك تاريخ الاستحقاق فارغا',
            'Due_date.date' => 'تاريخ الاستحقاق يجب أن يكون تاريخًا',
            'Due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون في نفس اليوم أو بعد تاريخ الفاتورة.',
        ]);

        $invoices = Invoices::findOrFail($request->invoice_id);


        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'note' => $request->note,
            'Total' => $request->Total,
        ]);
        return redirect()->route('invoices.index')->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices $invoices)
    {
        //
    }
}
