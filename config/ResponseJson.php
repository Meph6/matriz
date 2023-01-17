<?php
namespace Config;

class ResponseJson
{
    public static function response($success, $mensaje)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        if($success){
            http_response_code(200);
        }else{
            http_response_code(500);
        }

        $data = [
            'message' => $mensaje
        ];

        echo (json_encode($data));

        exit();
    }
}