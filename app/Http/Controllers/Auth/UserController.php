<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }
    public function auth(Request $request)
    {
        // Implement your authentication logic here
        // For example, validate the credentials and log in the user
        // Redirect to the dashboard or show an error message
        return redirect()->route('dashboard');
    }
    //
}
