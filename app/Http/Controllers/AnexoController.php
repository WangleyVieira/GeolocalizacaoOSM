<?php

namespace App\Http\Controllers;

use App\Anexo;
use App\Services\EmissorCarimboService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;

class AnexoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
           if($request->hasFile('anexo') && $request->file('anexo')->isValid()){
                $nome_original = $request->anexo->getClientOriginalName();
                $extensao = $request->anexo->extension();
                $nome_hash = Carbon::now()->timestamp;
                $nome_hash = $nome_hash.'.'.$extensao;
                $upload = $request->anexo->storeAs('public/anexo/', $nome_hash);

                if(!$upload){
                    return redirect()->back()->with('erro', '1 - Ocorreu um erro ao salvar o anexo.');
                }
                else{
                    $anexo = new Anexo();
                    $anexo->nome_original = $nome_original;
                    $anexo->nome_hash = $nome_hash;
                    $anexo->descricao = $request->descricao;
                    $anexo->ativo = 1;
                    $anexo->cadastradoPorUsuario = auth()->user()->id;
                    $anexo->save();
                }
           }
           else{
                return back()->with('erro', '2 - Ocorreu um erro ao salvar o anexo.');
           }

           return back()->with('success', 'Cadastro realizado com sucesso!');

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function getFile($id)
    {
        try {
            $file = Anexo::find($id);
            if($file){
                $existe = Storage::disk('public')->exists('anexo/'.$file->nome_hash);
                if($existe && $file->ativo == 1){
                    $path = storage_path('app/public/anexo/'.$file->nome_hash);
                    $response = response()->download($path, $file->nome_original, [
                        'Content-Type' => mime_content_type($path),
                        'inline'
                    ]);
                    ob_end_clean();
                    return $response;
                }
            }
            else{
                return redirect()->back()->with('erro','Arquivo inexistente.');
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function show(Anexo $anexo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function edit(Anexo $anexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anexo $anexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Anexo  $anexo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anexo $anexo)
    {
        //
    }
}
