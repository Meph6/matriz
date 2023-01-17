<?php

namespace Routes;

require_once('./config/ResponseJson.php');

class Ruta
{
    private $rutas = [];
    private $accion = [];

    private $rutas_put = [];
    private $accion_put = [];

    public function get($url, $metodo)
    {
        $this->rutas[] = $url;

        if(!empty($metodo)){
            $this->accion[] = $metodo;
        }
    }

    public function put($url, $metodo)
    {
        $this->rutas_put[] = $url;

        if(!empty($metodo)){
            $this->accion_put[] = $metodo;
        }
    }

    public function ejecutar()
    {
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET';
                $url = isset($_GET['url']) ? '/'.$_GET['url'] : '/';

                $this->ejecutar_get($url);

                break;
            case 'PUT';
                /* 
                    Al no existir algo como $_PUT, sino solo $_GET y $_POST,
                    file_get_contents('php://input') obtiene 
                    los datos enviador por medio de PUT:
                    {
                        "data": [
                            { "param1": "hola" },
                            { "param2": "hola" }
                        ]
                    }
                */
                $data = json_decode(file_get_contents('php://input'), true);

                // inquietudes con REQUEST_URI
                $url = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
                $url = empty($url[1]) ? '/' : '/'. $url[1];
                
                $this->ejecutar_put($url, $data);
            break;
        }

        exit();
    }

    private function ejecutar_get($url)
    {
        foreach($this->rutas as $key => $values){

            if($values !== $url) continue;

            if($this->accion[$key] instanceof \Closure)
            {
                return $this->accion[$key]();
            }

            $datos = explode( '@', $this->accion[$key]);

            $controlador = "Controller\\". $datos[0];
            $metodo = $datos[1];

            return (new $controlador)->{$metodo}();
        }
    }

    private function ejecutar_put($url, $data)
    {
        foreach($this->rutas_put as $key => $values){

            if($values !== $url) continue;

            if($this->accion_put[$key] instanceof \Closure)
            {
                return $this->accion_put[$key]($data);
            }

            $datos = explode( '@', $this->accion_put[$key]);

            $controlador = "Controller\\". $datos[0];
            $metodo = $datos[1];

            return (new $controlador)->{$metodo}($data);
        }
    }
}