<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachment;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        $details = Invoices_details::where('id_Invoice', $id)->get();
        $attachments = Invoices_attachment::where('invoice_id', $id)->get();

        // dd($invoices_details);
        return view('Dashboard.Invoices.invoices_details', compact('invoices', 'attachments', 'details'));
    }
    public function get_file($invoice_number, $file_name)
    {
        Storage::disk('public_uploads')->get($invoice_number . '/' . $file_name);
        if (Storage::disk('public_uploads')->exists($invoice_number . '/' . $file_name)) {
            return response()->download(Storage::disk('public_uploads')->path($invoice_number . '/' . $file_name));
        } else {
            abort(404);
        }
    }


    public function open_file($invoice_number, $file_name)
    {
        $files = Storage::disk('public_uploads')->path($invoice_number . '/' . $file_name);
        return response()->file($files);
    }

    public function destroy(Request $request)
    {
        $invoices = Invoices_attachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
    }
}
