<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachment;
use App\Models\Invoices_details;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $details = invoices_Details::where('id_Invoice', $id)->get();
        $attachments = Invoices_attachment::where('invoice_id', $id)->get();

        // dd($invoices_details);
        return view('Dashboard.Invoices.invoices_details', compact('invoices', 'attachments', 'details'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices_details $invoices_details)
    {
        //
    }
}
