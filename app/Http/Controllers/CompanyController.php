<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function view(Company $company)
    {
        return view('company.view')->with('company', $company);
    }
}
