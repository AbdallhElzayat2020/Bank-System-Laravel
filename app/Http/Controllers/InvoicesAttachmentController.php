<?php

namespace App\Http\Controllers;

use App\Models\Invoices_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file_name' => ['mimes:pdf,jpeg,png,jpg', 'max:10000'],
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون pdf, jpeg, png, jpg',
            'file_name.max' => 'يجب ان لا يزيد حجم المرفق عن 10MB',
        ]);

        $image = $request->file('file_name');

        $file_name = $image->getClientOriginalName();

        $user = Auth::user()->name;



        $attachments = new Invoices_attachment();

        $attachments->file_name = $file_name;

        $attachments->invoice_number = $request->invoice_number;

        $attachments->invoice_id = $request->invoice_id;

        $attachments->Created_by = $user;

        $attachments->save();


        // move img attchment into Attachments folder
        $imageName = $request->file('file_name')->getClientOriginalName();

        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

        session()->flash('success', 'تم اضافة المرفق بنجاح');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices_attachment $invoices_attachment)
    {
        //
    }
}
