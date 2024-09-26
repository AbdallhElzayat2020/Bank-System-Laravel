<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index($id)
    {
        if (view()->exists('Dashboard.'.$id)) {
            return view('Dashboard.'.$id);
        } else {
            return view('Dashboard.404');
        }
        // The commented-out line below is not needed
        // return view($id);
    }
}
