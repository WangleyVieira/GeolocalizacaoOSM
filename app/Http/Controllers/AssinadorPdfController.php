<?php

namespace App\Http\Controllers;

use App\Anexo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssinadorPdfController extends Controller
{
    // Token de autenticação gerado no BRy Cloud
    const access_token = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJFTjI1UTRjTnZEYW1XSjFuUUVIdmhzN1k0VDZEZlhxQnNGZ0N0WVBHS2Y4In0.eyJleHAiOjE2NjIwNjIwMjIsImlhdCI6MTY2MjA2MDIyMiwianRpIjoiMWI1ZDQyYjktYjY2MC00ZDdjLThhMWEtZTkwYjhjMGE2MjFlIiwiaXNzIjoiaHR0cHM6Ly9jbG91ZC5icnkuY29tLmJyL2F1dGgvcmVhbG1zL2Nsb3VkIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6ImY6ZWExZDg2NGYtNzg3MS00M2Q2LWJjYmYtMTE4N2M3ZmI4MTg2OndhbmdsZXl2aWVpcmEiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJ0ZXJjZWlyb3MiLCJzZXNzaW9uX3N0YXRlIjoiOWU2Nzk2MWItMmExMy00ZjI4LWIxYzItYjkyNTFhMzdmYTM1IiwiYWNyIjoiMSIsInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJvZmZsaW5lX2FjY2VzcyIsInVzdWFyaW8iLCJ1bWFfYXV0aG9yaXphdGlvbiIsInVzZXIiXX0sInJlc291cmNlX2FjY2VzcyI6eyJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6InByb2ZpbGUgZW1haWwiLCJjb2RlIjoiMDU0MDY0NzcxMzciLCJjbG91ZF9hcHBfa2V5IjoiYXBwLndhbmdsZXl2aWVpcmEuMTY2MTc5NzUxNjg5MyIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IldhbmdsZXkgVmllaXJhIiwiY2xvdWRfdG9rZW4iOiJ5dEJvU3U1ZWJLVjQ2NjBCMGd2ZjNnT2FVQ2NKSFlHb2k3b2xwVkcwc3EzVGNBV1N2WHk3ekNodE9Tb2lURE5OIiwicHJlZmVycmVkX3VzZXJuYW1lIjoid2FuZ2xleXZpZWlyYSIsImdpdmVuX25hbWUiOiJXYW5nbGV5IiwiZmFtaWx5X25hbWUiOiJWaWVpcmEifQ.H_7XPBMM6mUPuTAkAUZfMQR4cMTSJhYnEkP8BhA60z5ZT2ZOrn5xTjC9aj67U2JLxhunSKlRKEoQC26TXpeevDD64sW3pEc2FTCqCTbqYqe9RlPiyzTSsf0kpnItKW0drChpPMBwliyfykfMt74F7MHcex10r-Zovo0FPOwJpmeMA5J5LkHsXuQybEJBORoj7gsgAZ5svd02CtvBXehChcHjYJKSnEfMUfThI52gcQfxIVFscGhFTu2rhPUqbLMJRZK1Qrk9mrlDQzyQ-AR1LsCsgNUGoQsFtj4fMX2fGO3Ul0kZJaqw2ZhUYnS0hkXEU0z3PxSQ5ELb7zsvtftbVA";
    // Chave de autorização (PIN) do usuário signatário, codificada em BASE64
    const kmsCredencial = 'YXBwLndhbmdsZXl2aWVpcmEuMTY2MTc5NzUxNjg5Mw==';
    // Tipo de credencial do KMS, "PIN" ou "TOKEN"
    const kmsCredencialTipo = 'TOKEN';


    public function assinarKMS(Request $request)
    {
        try {
            // Verifica se o documento enviado na requisição é válido.
            if ($request->hasFile('anexo') && $request->file('anexo')->isValid()) {

                $nome_original = $request->anexo->getClientOriginalName();
                $extensao = $request->anexo->extension();
                $nome_hash = Carbon::now()->timestamp;
                $nome_hash = $nome_hash.'.'.$extensao;

                $upload = $request->documento->storeAs('public/anexo/', $nome_hash);

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
            else {
                // return response()->json(['message' => 'Arquivo enviado inválido'], 400);
                return back()->with('erro', 'Ocorreu um erro ao assinar o documento.');
            }

            // Verifica se a imagem enviada na requsição é valida.
            // if ($request->incluirIMG === 'true') {
            //     if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            //         $upload = $request->imagem->storeAs('imagem', 'imagemAssinatura.png');
            //     } else {
            //         return response()->json(['message' => 'Imagem enviada inválida'], 400);
            //     }
            // }

            $data = array(
                    'dados_assinatura' =>
                    '{
                        "signatario": "' . $request->signatario . '",
                        "algoritmoHash" : "' . $request->algoritmoHash . '",
                        "perfil" : "' . $request->perfil . '"
                    }',
                    'documento' => new \CURLFILE(storage_path() . '/app/documentos/documentoParaAssinatura.pdf'),
            );

            // if($request->assinaturaVisivel === 'true') {
            //     $data['configuracao_imagem'] = '{
            //         "altura" : "' . $request->altura . '",
            //         "largura" : "' . $request->largura . '",
            //         "coordenadaX" : "' . $request->coordenadaX . '",
            //         "coordenadaY" : "' . $request->coordenadaY . '",
            //         "posicao" : "' . $request->posicao . '",
            //         "pagina" : "' . $request->pagina . '"
            //     }';

            //     $data['configuracao_texto'] = '{
            //         "texto" : "' . $request->texto . '",
            //         "incluirCN" : "' . $request->incluirCN . '",
            //         "incluirCPF" : "' . $request->incluirCPF . '",
            //         "incluirEmail" : "' . $request->incluirEmail . '"
            //     }';
            //     // Configurações da imagem da assinatura
            //     if ($request->incluirIMG === 'true') {
            //         $data['imagem'] = new \CURLFILE(storage_path() . '/app/imagem/imagemAssinatura.png');
            //     };


            // }

            // Cria o CURL que será enviada à API de Assinatura.
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://hub2.bry.com.br/fw/v1/pdf/kms/lote/assinaturas",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    // 'Authorization: ' . self::token,
                    'Authorization: ' . self::access_token,
                    'kms_credencial: ' . self::kmsCredencial,
                    'kms_credencial_tipo: ' . self::kmsCredencialTipo,
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $objResponse = json_decode($response);

            // Retorno o link do documento assinado para ser baixado no front-end
            return $objResponse->documentos[0]->links[0]->href;

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}
