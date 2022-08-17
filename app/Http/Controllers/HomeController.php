<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {

            $user = User::where('id', '=', auth()->user()->id)
                ->select('id', 'name', 'email')
                ->first();

                // dd($user);

            return view('home.home', compact('user'));

        } catch (\Exception $ex) {
            return $ex->getMessage();
            // return redirect()->back()->withErrors('Erro!!! Contate o administrador do sistema.');
        }
    }
}
