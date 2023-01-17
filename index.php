<?php 
require_once('./routes/Ruta.php');
require_once('./controllers/MatrizController.php');
require_once('./config/ResponseJson.php');

use Routes\Ruta;
use Config\ResponseJson as Response;

// se instancia la clase Ruta
$ruta = new Ruta();

// Ruta que obtiene la vista principal
$ruta->get('/', 'MatrizController@index');

// Ruta de ejemplo para la funcionalidad GET
$ruta->get('/ejemplo', function(){
    Response::response(true, 'Ejemplo');
});

// Ruta que se encarga de obtener la transpuesta de la matriz
$ruta->put('/matriz-transpuesta', 'MatrizController@getTranspuesta');

// Ruta de ejemplo para la funcionalidad PUT
$ruta->put('/', function($data){
    var_dump($data);
});

// Ruta de ejemplo para la funcionalidad PUT
$ruta->put('/ejemplo', function(){
    echo 'Ejemplo';
});

$ruta->ejecutar();

exit();