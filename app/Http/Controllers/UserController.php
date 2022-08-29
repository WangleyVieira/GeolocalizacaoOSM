<?php

namespace App\Http\Controllers;

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

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            //validação dos campos
            $input = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];

            //regras
            $regras = [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'password' => 'required|min:6',
            ];

            //mensagens de erro
            $mensagens = [
                'name.required' => 'O nome é obrigatório.',
                'name.max' => 'Máximo de 255 caracteres.',

                'email.required' => 'O email é obrigatório.',
                'email.max' => 'Máximo de 255 caracteres',

                'password.required' => 'A senha é obrigatório.',
                'password.min' => 'A senha é no minímo 6 caracteres.',
            ];

            $validacao = Validator::make($input, $regras, $mensagens);
            $validacao->validate();

            //verifica se existe um email cadastrado
            $user = User::where('email', '=', $request->email)
                    ->select('id', 'email')
                    ->first();
            if($user){
                return redirect()->back()->with('erro', 'Existe um e-mail cadastrado ao informado.');
            }

            if($request->password != null){
                // as senhas estão ok?
                if($request->password != $request->confirmacao){
                    return redirect()->back()->with('erro', 'Senha não conferem.');
                }

                $tamanho_senha = strlen($request->password);
                if($tamanho_senha < 6){
                    return redirect()->back()->with('erro', 'Necessário senha de no minímo 6 caracteres.');
                }

            }

            $novoUsuario = new User();
            $novoUsuario->name = $request->name;
            $novoUsuario->email = $request->email;
            $novoUsuario->password = Hash::make($request->password);
            $novoUsuario->ativo = 1;
            $novoUsuario->save();

            return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso.');

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
