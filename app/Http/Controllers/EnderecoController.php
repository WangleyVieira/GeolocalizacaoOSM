<?php

namespace App\Http\Controllers;

use App\Endereco;
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
            return view('endereco.index');
        } catch (\Exception $ex) {
            return $ex->getMessage();
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

            $endereco = new Endereco();
            $endereco->cep = preg_replace('/[^0-9]/', '', $request->cep);
            $endereco->cidade = $request->cidade;
            $endereco->uf = $request->uf;
            $endereco->numero = $request->numero;
            $endereco->bairro = $request->bairro;
            $endereco->complemento = $request->complemento;
            $endereco->ponto_referencia = $request->ponto_referencia;
            $endereco->id_user = auth()->user()->id;
            $endereco->cadastradoPorUsuario = auth()->user()->id;
            $endereco->ativo = 1;

            dd($endereco);

        } catch (\Exception $ex) {
            return $ex->getMessage();
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
    public function edit(Endereco $endereco)
    {
        //
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
    public function destroy(Endereco $endereco)
    {
        //
    }
}
