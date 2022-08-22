<?php

namespace App\Http\Controllers;

use App\Endereco;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $enderecos = Endereco::where('ativo', '=', 1)->get();
            $users = User::where('ativo', '=', 1)->get();

            return view('endereco.index', compact('enderecos', 'users'));
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            return redirect()->back()->with('erro', 'Entre em contato com administrador do sistema.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if($request->cep == null || $request->endereco == null || $request->numero == null){
                return redirect()->back()->with('erro', 'Campos CEP, endereço e número, são obrigatórios.');
            }

            //verifica se já existe email cadastrado
            $verifica_email = Endereco::where('email', '=', $request->email)
                ->select('id', 'nome', 'email')
                ->first();

            if($verifica_email){
                return redirect()->back()->with('erro', 'Já existe um email cadastrado.');
            }

            $endereco = new Endereco();
            //dados da pessoa
            $endereco->nome = $request->nome;
            $endereco->cpf = preg_replace('/[^0-9]/', '', $request->cpf);
            $endereco->email = $request->email;
            $endereco->telefone = preg_replace('/[^0-9]/', '', $request->telefone_contato1);
            //dados de endereço
            $endereco->cep = preg_replace('/[^0-9]/', '', $request->cep);
            $endereco->cidade = $request->cidade;
            $endereco->endereco = $request->endereco;
            $endereco->uf = $request->uf;
            $endereco->numero = $request->numero;
            $endereco->bairro = $request->bairro;
            $endereco->complemento = $request->complemento;
            $endereco->ponto_referencia = $request->ponto_referencia;
            $endereco->lat = $request->lat;
            $endereco->long = $request->long;
            // $endereco->id_user = auth()->user()->id;
            $endereco->cadastradoPorUsuario = auth()->user()->id;
            $endereco->ativo = 1;

            // dd($endereco);

            $endereco->save();

            return redirect()->back()->with('success', 'Dados de endereço salvo com sucesso');
        } catch (\Exception $ex) {
            return redirect()->back()->with('erro', 'Entre em contato com administrador do sistema.');
            // return $ex->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function show(Endereco $endereco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            $end = Endereco::find($id);
            $users = User::where('ativo', '=', 1)->get();

            return view('endereco.edit', compact('end', 'users'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
            // return redirect()->back()->with('erro', 'Entre em contato com administrador do sistema.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endereco $endereco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $end = Endereco::find($request->id);
            $end->ativo = 0;
            $end->dataInativado = Carbon::now();
            $end->motivoInativado = $request->motivo;
            $end->inativadoPorUsuario = auth()->user()->id;
            $end->save();

            // dd($end);

            return redirect()->route('endereco.index')->with('success', 'Cadastro excluído com sucesso.');
        } catch (\Exception $ex) {
            return redirect()->back()->with('erro', 'Entre em contato com administrador do sistema.');
            // return $ex->getMessage();
        }
    }
}
