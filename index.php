<?php ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="css/estilos.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="librerias/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="pages_js/alta_Usuarios.js" type="text/javascript"></script>   
    </head>

    <body style="background: #051725; color:white;">	
        <div class="container">
            <h1>Ingreso de datos</h1>

            <div class="row row-padding col-sm-4">

                <div class=" form-group">
                    <label>Nombre</label>
                    <input class="form-control"  id="_nombre" type="text">
                </div>
                <div class=" form-group">
                    <label>Email</label>
                    <input class="form-control"  id="_email" type="email">
                </div>
                <div class=" form-group">
                    <label>Telefono</label>
                    <input class="form-control" id="_telefono" type="number">
                </div>

                <div class="">
                    <button onclick='btnGuardarUsuario_Click();' type="button" class="btn btn-primary" id="guardar_Usuario">
                        Guardar
                    </button>
                </div>
            </div>
            <div class="border-right form-group col-sm-6">
                <h3>Listado de datos</h3>
                <div id="listado">
                    <div id="paginador">
            </div>
                </div>
<!--                <div id="paginador">
            </div>-->
            </div>
        </div>
    </body>	
</html>



