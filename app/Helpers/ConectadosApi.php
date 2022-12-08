<?php

namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;

class ConectadosApi
{

    public static function getRequest($params): array
    {
        /* Se inicializan respuestas y se toma las variables del env por seguridad y se realiza la petición a los respectivos endpoints de ser requeridos en base a los parámetros enviados del repositorio*/
        
        $res = [
            'code' => 401,
            'data' => "Token incorrecto"
        ];

        $url = env('conectadosweb_url').'/users/'.$params['token'].(isset($params['client_id']) ? '/transaction/'.$params['client_id'] : '');

        $method = "GET";

        try{
            $client = new Client();
            $response = $client->request($method,$url,['verify'=>false]);
            if($response->getStatusCode()==200){
                if ($response->getBody() != "Token incorrecto"){
                    $res['code'] = 200;
                    $res['data'] = json_decode($response->getBody(), true);
                }
            }
        }catch(Exception $ex){
            $res['code'] = $ex->getCode();
            $res['data'] = $ex->getMessage();
        }
        return $res;
    }
}
