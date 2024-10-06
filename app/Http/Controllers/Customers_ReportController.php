<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;

class Customers_ReportController extends Controller
{
    public function customers_report()
    {
        $sections = Sections::all();
        return view('Dashboard.reportes.customers_report', compact('sections'));
    }
    public function search_customers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {

            $invoices = Invoices::select('*')->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();

            return view('Dashboard.reportes.customers_report')->withDetails($invoices);
        } else {

            $start_at = date($request->start_at);

            $end_at = date($request->end_at);

            $invoices = Invoices::select('*')->whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();

            return view('Dashboard.reportes.customers_report')->withDetails($invoices);
        }
    }
}
