<?php
/*
    Dada una matriz cuadrada ingresada por el usuario (de n x n) hallar su transpuesta. 
    La transpuesta de una matriz se obtiene al cambiar sus filas por columnas ordenadamente, 
    a continuación se expone un ejemplo:

        | 0 1 2 |             | 0 0 0 |  
    A = | 0 1 2 |         At =| 1 1 1 |
        | 0 1 2 |             | 2 2 2 |

        * Para la entrada se debe desarrollar una interfaz web con un formulario en el cual un usuario
        pueda ingresar los datos de la matriz. 

        * La interfaz debe proveer la opción para que el usuario 
        cree la matriz cuadrada de cualquier tamaño (n x n, no sólo de 3x3). 

        * La interfaz debe llevar un botón para calcular la transpuesta de la matriz ingresada.

        * La salida con el resultado de la matriz transpuesta debe ser mostrada en pantalla de la manera que considere.
*/
echo "Este es un programa para hallar la transpuesta de una matriz de orden ( n1 x n2 ), 
por favor ingrese los valores numéricos correspondientes para el orden 
(en caso de números decimales solo se tendrá en cuenta su parte entera):\n";

$largo = 0;
$ancho = 0;

try{
    $largo = (int)readline("Ingrese número de filas:\n ");
    $ancho = (int)readline("Ingrese número de columnas:\n ");

    if($largo <= 0 || $ancho <= 0){
        throw new Exception("Por favor ingrese un número superior a 0.\n");
    }

    $matriz = [];
    
    // Lee la entrada del usuario
    for($i = 0; $i < $largo; $i++){
        $fila = [];
        $restante = $ancho - 1;
    
        echo "($ancho) restantes\n";
    
        for($j = 0; $j < $ancho; $j++){
    
            $fila[] = (int)readline("Ingrese valor para la fila ". ($i + 1). ": \n");
    
            echo "($restante) restantes\n";
    
            $restante--;
        }
    
        $matriz[] = $fila;
    }

    echo "La matriz es de ( $largo x $ancho ): \n";

    // muestra de manera gráfica lo resultados ingresados
    $front = "";

    foreach($matriz as $filas){
        $front .= "|";

        for($k=0; $k < $ancho; $k++){
            $front .= " ". $filas[$k];
        }
        $front .= " | \n";
    }

    echo $front;

    // Operación de la transpuesta

    $transpuesta = [];
    
    for($l = 0; $l < $ancho; $l++){
        $fila_t = [];

        for($m = 0; $m < $largo; $m++){

            $fila_t[] = $matriz[$m][$l];
        }

        $transpuesta[] = $fila_t;
    }

    // muestra de manera gráfica el resultado de la transpuesta

    $front2 = "";

    foreach($transpuesta as $filas_t){
        $front2 .= "|";

        for($k=0; $k < count($filas_t); $k++){
            $front2 .= " ". $filas_t[$k];
        }
        $front2 .= " | \n";
    }

    echo "la transpuesta es: \n";

    echo $front2;

}catch(Exception $e){
    echo "Error: ". $e->getMessage();
}
