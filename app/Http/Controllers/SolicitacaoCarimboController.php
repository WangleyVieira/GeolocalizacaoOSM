<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EmissorCarimboService;
use GuzzleHttp\Psr7\Request;

class SolicitacaoCarimboController extends Controller
{
    // require_once ("trustedTimestamps.php");

    // public function index(Request $request, $id){

    //     require_once ("EmissorCarimboService.php");

    //     // $document = 'teste carimbo';
    //     $document = $request->anexo;

    //     dd($document);

    //     $documentHash = hash ( 'sha256', $document);
    //     $urlCarimbadora = 'https://cloud.bry.com.br/carimbo-do-tempo/tsp';
    //     $clientId = '58810866-9a80-4cdd-ae02-6ec27077747f';
    //     $clientSecret = 'vu/mgVZzGOe2uoxeXgT6k1QTOwENqiaBj/DrNkk+p/sdkT41LZFb1A==';

    //     try {

    //         //TrustedTimestamp é o EmissorCarimboController
    //         // $requestFilePath = TrustedTimestamp::createRequestfile ( $documentHash );
    //         $requestFilePath = EmissorCarimboService::createRequestfile ( $documentHash );
    //         $response = EmissorCarimboService::signRequestfile ( $requestFilePath, $urlCarimbadora, $clientId, $clientSecret );

    //         //Enviando requisição de carimbo do tempo
    //         $timestampDate = EmissorCarimboService::getTimestampFromAnswer ( $response ['response_string'] );

    //         } catch ( \Exception $e ) {

    //         $response = array();
    //         $response ['message'] = "Falha ao carimbar.";
    //         $response ['erro_info'] = $e->getMessage();

    //         }

    //     var_dump($response);
    // }

}
