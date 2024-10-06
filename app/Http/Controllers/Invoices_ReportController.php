<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class Invoices_ReportController extends Controller
{
    public function invoices_report()
    {
        return view('Dashboard.reportes.invoices_report');
    }
    public function search_invoices(Request $request)
    {

        $rdio = $request->rdio;



        if ($rdio == 1) {


            if ($request->type && $request->start_at == '' && $request->end_at == '') {

                $invoices = Invoices::select('*')->where('Status', '=', $request->type)->get();
                $type = $request->type;
                return view('Dashboard.reportes.invoices_report', compact('type'))->withDetails($invoices);
            } else {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type)->get();
                return view('Dashboard.reportes.invoices_report', compact('type', 'start_at', 'end_at'))->withDetails($invoices);

            }
        } else {

            $invoices = Invoices::select('*')->where('invoice_number', '=', $request->invoice_number)->get();
            return view('Dashboard.reportes.invoices_report')->withDetails($invoices);
        }
    }

}
