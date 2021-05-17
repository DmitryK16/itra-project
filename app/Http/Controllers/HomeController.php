<?php

namespace App\Http\Controllers;

use App\Models\Company;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $companies = Company::paginate(9);

        return view('welcome')->with('companies', $companies);
    }
}
