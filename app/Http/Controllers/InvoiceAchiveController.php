<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoiceAchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('Dashboard.Invoices.archive_invoices', compact('invoices'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $invoices = Invoices::onlyTrashed()->findOrFail($id);
        $id = $request->invoice_id;

        $invoices = Invoices::withTrashed()->where('id', $id)->first();

        $invoices->restore();

        return redirect()->route('invoices.index')->with('success', 'تم استرجاع الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;

        $invoices = Invoices::withTrashed()->where('id', $id)->first();

        $invoices->forceDelete();

        return redirect()->route('archive_invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
