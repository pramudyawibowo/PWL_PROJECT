<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    public function index(){
        return view('Auth.login');
    }

    public function postlogin(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
