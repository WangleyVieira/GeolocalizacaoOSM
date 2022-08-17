<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function autenticacao(Request $request){

        if(!Auth::attempt($request->only(['email', 'password']))){
            return redirect()->back()->with('erro', 'Email de usuário ou senha com dados incorretos');
        }

        return redirect('/home');
    }

}
