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
        $invoices_unPaid_total = Invoices::where('Value_Status', 2)->get()->sum('Total');

        $invoices_unPaid_count = Invoices::where('Value_Status', 2)->get()->count();

        // paid
        $invoices_Paid_total = Invoices::where('Value_Status', 1)->get()->sum('Total');

        $invoices_Paid_count = Invoices::where('Value_Status', 1)->get()->count();

        // partial
        $invoices_partial_total = Invoices::where('Value_Status', 3)->get()->sum('Total');

        $invoices_partial_count = Invoices::where('Value_Status', 3)->get()->count();



        if ($invoices_unPaid_count == 0) {
            $nspainvoices2 = 0;
        } else {
            $nspainvoices2 = $invoices_unPaid_count / $invoices_count * 100;
        }

        if ($invoices_Paid_count == 0) {
            $nspainvoices1 = 0;
        } else {
            $nspainvoices1 = $invoices_Paid_count / $invoices_count * 100;
        }

        if ($invoices_partial_count == 0) {
            $nspainvoices3 = 0;
        } else {
            $nspainvoices3 = $invoices_partial_count / $invoices_count * 100;
        }



        // Chart Invoices
        $count_all = invoices::count();
        $count_invoices1 = invoices::where('Value_Status', 1)->count();
        $count_invoices2 = invoices::where('Value_Status', 2)->count();
        $count_invoices3 = invoices::where('Value_Status', 3)->count();

        if ($count_invoices2 == 0) {
            $nspainvoices2 = 0;
        } else {
            $nspainvoices2 = $count_invoices2 / $count_all * 100;
        }

        if ($count_invoices1 == 0) {
            $nspainvoices1 = 0;
        } else {
            $nspainvoices1 = $count_invoices1 / $count_all * 100;
        }

        if ($count_invoices3 == 0) {
            $nspainvoices3 = 0;
        } else {
            $nspainvoices3 = $count_invoices3 / $count_all * 100;
        }


        $chartjs_1 = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices3]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1, $nspainvoices3]
                ]
            ])
            ->options([]);


        return view('dashboard', compact(
            'invoices_total',
            'invoices_count',
            'invoices_unPaid_total',
            'invoices_unPaid_count',
            'invoices_Paid_total',
            'invoices_Paid_count',
            'invoices_partial_total',
            'invoices_partial_count',
            'chartjs_1',
            'chartjs_2',
        ));
    }
}
