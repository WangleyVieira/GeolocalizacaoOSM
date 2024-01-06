<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            return view('usuario.registrar');

        }
        catch (\Exception $ex) {
            // return $ex->getMessage();
            return redirect()->back()->with('erro', 'Erro, contacte o administrador do sistema.');
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {

            if($request->password != null){
                // as senhas estão ok?
                if($request->password != $request->confirmacao){
                    return redirect()->back()->with('erro', 'Senhas não conferem.');
                }
            }

            User::create($request->validated());

            return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso.');

        } catch (\Exception $ex) {
            return $ex->getMessage();
            // return redirect()->back()->with('erro', 'Erro ao realizar o cadastro.');
        }
    }
}
