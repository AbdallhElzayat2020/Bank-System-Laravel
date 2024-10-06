<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $invoices_total = Invoices::sum('Total');
        $invoices_count = Invoices::count();

        // nupaid
        $invoices_unPaid_total = Invoices::where('Value_Status', '=', 2)->get()->sum('Total');

        $invoices_unPaid_count = Invoices::where('Value_Status', '=', 2)->get()->count();

        // paid
        $invoices_Paid_total = Invoices::where('Value_Status', '=', 1)->get()->sum('Total');

        $invoices_Paid_count = Invoices::where('Value_Status', '=', 1)->get()->count();

        // partial
        $invoices_partial_total = Invoices::where('Value_Status', '=', 3)->get()->sum('Total');

        $invoices_partial_count = Invoices::where('Value_Status', '=', 3)->get()->count();

        // $invoices_paid = Invoices::sum('');
        // dd($invoices_total);
        // $invoices_partial = Invoices::where('Status', '=', 3)->get();
        return view('dashboard', compact(
            'invoices_total',
            'invoices_count',
            'invoices_unPaid_total',
            'invoices_unPaid_count',
            'invoices_Paid_total',
            'invoices_Paid_count',
            'invoices_partial_total',
            'invoices_partial_count',
        ));
    }
}
