<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inicio</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script></head>
<body>
    <section class="text-center bg-warning">
        <h1>Matriz Transpuesta</h1>
    
        <h3>Ingrese orden de la matriz</h3>
        <div id="form-orden" class="bg-success">
            <div>
                <label for="n1">Filas: </label>
                <input id="n1" type="number" value="1">
            </div>
            <br>
            <div>
                <label for="n2">Columnas: </label>
                <input id="n2" type="number" value="1">
            </div>
            <br>
            <button class="btn btn-info" id="orden">Enviar</button>
        </div>
    </section>
    <div id="form-matrices" class="text-center bg-info">

        <h2 id="titulo-matrices">
            Matriz de orden
            <span id="descripcion-matrices">( 1 x 1)</span>
        </h2>

        <div class="container bg-secondary" style="width: 50%;">
            <div class="row p-4">
                <div id="matriz-normal" class="col-5 bg-warning px-4">
                    <div class="row gap-2">
                        <input class="col" type="number" value="0">
                    </div>
                </div>

                <button id="obtener-transpuesta" type="button" class="col-2 btn btn-success">
                    obtener transpuesta
                </button>

                <div id="matriz-transpuesta" class="col-5 bg-warning px-4">
                    <div class="row gap-2">
                        <input class="col" type="number" value="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
     <!-- Proceso -->
    <script>
        let n1;
        let n2;

        $('#orden').click(function()
        {
            n1 = parseInt($('#n1').val());
            n2 = parseInt($('#n2').val());

            if(n1 && n2 )
            {
                $('#descripcion-matrices').text('( '+ n1 + ' x '+ n2 + ' )');

                matrices(n1, n2, 'normal');

                matrices(n2, n1, 'transpuesta');
            }else{
                alert('Por favor ingrese un número');
                $('#n1').val('');
                $('#n2').val('');
               return; 
            }
        }); 

        $('#obtener-transpuesta').click(function()
        {
            let datos = {
                orden: { filas: n1, columnas: n2 },
                matriz: getValuesMatriz()
            };

            $.ajax({
                url: `${ window.location.href }matriz-transpuesta`,
                type: "PUT",
                data: JSON.stringify(datos),
                contentType:"application/json; charset=utf-8",
                dataType : "json",
                success: function(response) {
                    let transpuesta = response.message.transpuesta;

                    matrices(n2, n1, 'transpuesta', transpuesta);
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            });
        });

        /*
            Función que crea la matriz con inputs en la parte del usuario
        */
        function matrices(n1, n2, nombre_matriz, data = false)
        {
            let matriz = $('#matriz-' + nombre_matriz);
            matriz.empty();

            for(let i = 0; i < n1; i++)
            {
                let fila = $('<div/>');

                fila.addClass('row gap-2');
                fila.attr('id', nombre_matriz + '-fila-' + i);

                for(let j = 0; j < n2; j++)
                {
                    let columna = $('<input />');

                    columna.addClass('col');

                    if(nombre_matriz === 'normal')
                    {
                        columna.attr('type', 'number');
                        columna.attr('name', `fila[${ i }]`);

                        columna.val(j);
                    }
                    else if(nombre_matriz === 'transpuesta')
                    {
                        let value = (data) ? data[i][j] : '';

                        columna.attr('type', 'text');
                        columna.attr('name', `${ nombre_matriz }-fila[${ i }]`);

                        columna.css('cursor', 'none');
                        columna.prop('readonly', true);

                        columna.val( value );
                    }

                    fila.append(columna);
                }

                matriz.append(fila);
            }
        }

        /*
            Función que obtiene los valores ingresados en la matriz y los
            prepara para enviarlos al back
        */
        function getValuesMatriz()
        {
            let matriz = [];

            for(let i = 0; i <= n1 - 1; i++)
            {
                let fila = [];

                $(`input[name="fila[${ i }]"]`).each(function()
                {
                    fila.push(this.value);
                });

                matriz.push(fila);
            }

            return matriz;
        }

        function resetValues()
        {
            $('#n1').val(1);
            $('#n2').val(1);
        }

        resetValues();
    </script>
</body>
</html>