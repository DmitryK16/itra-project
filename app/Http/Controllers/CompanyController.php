<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    public function list()
    {
        /** @var User $user */
        $user = Auth::user();
        $companies = $user->companies;

        return view('company.list')
            ->with('companies', $companies);
    }
}
