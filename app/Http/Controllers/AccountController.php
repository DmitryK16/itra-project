<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    public function profile()
    {
        return view('account.profile')
            ->with('user', Auth::user());
    }
}
