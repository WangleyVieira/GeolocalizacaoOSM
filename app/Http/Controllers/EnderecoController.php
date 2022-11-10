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

            return view('endereco.edit', compact('end'));
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
    public function update(Request $request, $id)
    {
        try {
            if($request->cep == null || $request->endereco == null || $request->numero == null){
                return redirect()->back()->with('erro', 'Campos CEP, endereço e número, são obrigatórios.');
            }

             //varifica se já existe um email ativo cadaastrado no BD
             $verifica_user = Endereco::where('email', '=', $request->email)
             ->orWhere('cpf', '=', preg_replace('/[^0-9]/', '', $request->cpf))
             ->select('id', 'email', 'cpf')
             ->first();

         //existe um email cadastrado?
         if($verifica_user){
             if ($verifica_user->id != $id) {
                 return redirect()->back()->with('erro', 'Já existe um usuário cadastrado com esse email e/ou CPF.');
             }
         }

            $endereco =  Endereco::find($id);
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
            $endereco->alteradoPorUsuario = auth()->user()->id;
            $endereco->ativo = 1;

            $endereco->save();

            return redirect()->route('endereco.index')->with('success', 'Dados de endereço alterado com sucesso');

        } catch (\Exception $ex) {
            return redirect()->back()->with('erro', 'Entre em contato com administrador do sistema.');
            // return $ex->getMessage();
        }
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

    public function formUpload()
    {
        try {
           return view('upload');

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function upload(Request $request)
    {
        try {
            //array
            $documento = $request->file('documento');
            // $documento = $request->documento;
            $data = file_get_contents($documento);
            // $xmls = simplexml_load_string($data);
            // $json = json_encode($xmls);
            $array = json_decode($data,TRUE);
            // $array = $array['database']['table'];

            // dd($array);
            //array 2
            // $documento2 = $request->file('documento2');
            // $data2 = file_get_contents($documento2);
            // $xmls2 = simplexml_load_string($data2);
            // $json2 = json_encode($xmls2);
            // $array_ate_400 = json_decode($json2,TRUE);
            // $array_ate_400 = $array_ate_400['database']['table'];

            // $script = "INSERT INTO `composicao_familiars` (id_assinante, `id`, `nome`, `idade`, `deficiencia`, `id_parentesco`, `id_beneficiario`, `ativo`, `created_at`, `updated_at`) VALUES <br>";
            $script = "";


            for ($i=0; $i < Count($array); $i++) {
                $selected = $array[$i];
                // $id = $selected['id'];
                $descricao = $selected['nome'];
                // dd($nome);
                $insert = '["descricao" => "' . $descricao . '", "id_estado" => 16, "ativo" => 1], <br>';
                // dd($insert);

                // $insert = "(
                //     $selected[0], '$selected[1]', '$selected[2]', '$selected[3]', '$selected[4]', '$selected[5]', '$selected[6]', '$selected[7]', '$selected[8]',
                //     '$selected[9]', '$selected[10]', '$selected[11]', '$selected[12]', '$selected[13]', '$selected[14]', '$selected[15]', '$selected[16]',
                //     '$selected[17]', $selected[18], '$selected[19]', $selected[20], '$selected[21]', '$selected[22]', '$selected[23]', '$selected[24]',
                //     '$selected[25]', '$selected[26]', '$selected[27]', '$selected[28]', '$selected[29]', $selected[30], '$selected[31]', '$selected[32]',
                //     '$selected[33]', '$selected[34]', '$selected[35]', $selected[36], $selected[37], $selected[38], 5, $selected[39], $selected[40],
                //     $selected[41], $selected[42], $selected[43], $selected[44], $selected[45]
                // ), <br>";

                $script = $script . $insert;

            }
            echo "<h1>SCRIPT</h1>";
            echo $script;

            // for ($i=2; $i < Count($array_mais_500); $i++) {
            //     $selected = $array_mais_500[$i]['column'];

            //     $insert = "(
            //         $selected[0], '$selected[1]', '$selected[2]', '$selected[3]', '$selected[4]', '$selected[5]', '$selected[6]', '$selected[7]', '$selected[8]',
            //         '$selected[9]', '$selected[10]', '$selected[11]', '$selected[12]', '$selected[13]', '$selected[14]', '$selected[15]', '$selected[16]',
            //         '$selected[17]', $selected[18], '$selected[19]', $selected[20], '$selected[21]', '$selected[22]', '$selected[23]', '$selected[24]',
            //         '$selected[25]', '$selected[26]', '$selected[27]', '$selected[28]', '$selected[29]', $selected[30], '$selected[31]', '$selected[32]',
            //         '$selected[33]', '$selected[34]', '$selected[35]', $selected[36], $selected[37], $selected[38], 5, $selected[39], $selected[40],
            //         $selected[41], $selected[42], $selected[43], $selected[44], $selected[45]
            //     ), <br>";

            //     $script = $script . $insert;

            // }
            // dd([0]['column'][0]);
            // $array = $array['beneficiario'];

            // $total = Count($array);

            // //array 2
            // $documento2 = $request->file('documento2');
            // $data2 = file_get_contents($documento2);
            // $xmls2 = simplexml_load_string($data2);

            // $json2 = json_encode($xmls2);
            // $array2 = json_decode($json2,TRUE);
            // $array2 = $array2['beneficiario'];

            // $total2 = Count($array2);

            // $script_anexo = "SELECT * FROM users WHERE ";

            // for ($i=0; $i < $total; $i++) {
            //     $selected = $array[$i];

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
