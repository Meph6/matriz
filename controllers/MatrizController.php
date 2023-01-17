<?php
namespace Controller;
use Config\ResponseJson as Response;

class MatrizController
{
    public function index()
    {
        require_once('./views/home.php');
        exit();
    }

    public function getTranspuesta($data)
    {
        $transpuesta = [];

        $filas = $data['orden']['filas'];
        $columnas = $data['orden']['columnas'];

        for($l = 0; $l < $columnas; $l++){
            $fila_t = [];
    
            for($m = 0; $m < $filas; $m++){
    
                $fila_t[] = $data['matriz'][$m][$l];
            }
    
            $transpuesta[] = $fila_t;
        }

        return Response::response(
            true, 
            [ 'transpuesta' => $transpuesta ]
        );
    }
}