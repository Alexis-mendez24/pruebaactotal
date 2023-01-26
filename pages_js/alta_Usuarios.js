$(document).ready(function () {
    Usuarios_load();
});

function Usuarios_load() {
    try {

        var parametros = {
            "action": "carga_usuarios"
        };

        $.ajax({
            data: parametros,
            url: 'codebehind/cb_Usuarios.class.php',
            type: 'post',
            //async: false,
            success: function (data)

            {
                var json_listar;
                json_listar = $.parseJSON(data);
                var filas = json_listar.resultados.length;

                for (i = 0; i < filas; i++) {

                    document.getElementById("listado").innerHTML += '<div class="col-sm-6">' +
                            'Nombre:' + ' ' + json_listar.resultados[i]['nombre'] + '</div>'+ '<div class="col-sm-6">' +
                            'Email:' + ' ' + json_listar.resultados[i]['email'] + '</div>' + '' + '<div class="col-sm-6">' +
                            'Telefono:' + ' ' + json_listar.resultados[i]['telefono'] + '</div>' + '' + '<div class="col-sm-6">' +
                            'Fecha:' + ' ' + json_listar.resultados[i]['fecha'] + '</div>'+'<br>';

                }
                for (i = 1; i <= json_listar.paginas; i++) {
                    //var actual = $i == 1 ? " class='actual'" : '';
                    document.getElementById("paginador").innerHTML += '<li><a data-pagina="i" href="pagina-1.html" actual>' + i + '</a></li>';
                }

            }
        });

    } catch (err) {

        Al_Usuarios_exception_handler(err, "Error en Usuarios_load");
    }
}


function get_nombre() {
    try {
        var ret = $("#_nombre").val();
        return ret.trim();
    } catch (err) {
        return "";
    }
}
function get_email() {
    try {
        var ret = $("#_email").val();
        return ret.trim();
    } catch (err) {
        return "";
    }
}
function get_telefono() {
    try {
        var ret = $("#_telefono").val();
        return ret.trim();
    } catch (err) {
        return "";
    }
}

function esEmailValido(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function btnGuardarUsuario_Click() {
    try {


        if (validar_formulario()) {

            var parametros = {
                "action": 'guardar_usuario',
                "nombre": get_nombre(),
                "email": get_email(),
                "telefono": get_telefono()
            };

            $.ajax({
                data: parametros,
                url: 'codebehind/cb_Usuarios.class.php',
                type: 'post',
                success: function (data)
                {

                    alert("Alta exitosa");

                    clean_formulario();
                    Usuarios_load();

                }

            });

        }

    } catch (err) {
        Al_Usuarios_exception_handler(err, "Error en Guardar Usuario");
    }

}

function validar_formulario() {
    try {


        var error = 0;
        var errorMail = false;

        if (get_nombre().length == 0) {

            $("#_nombre").css({'border': '1px solid red'});
            error++;
            alert("Tienes que ingresar el nombre.");
        } else {
            $("#_nombre").css({'border': '1px solid gray'});
        }
        if (get_email().length == 0) {

            $("#_email").css({'border': '1px solid red'});
            error++;
            alert("Tienes que ingresar el email.");
        } else {
            $("#_email").css({'border': '1px solid gray'});
        }
        if (!esEmailValido(get_email())) {
            if (!errorMail) {
                alert("No ingresaste un email válido.");
            }
            $("#_email").css({'border': '1px solid red'});
            errorMail = true;
            error++;
        } else {
            $("#_email").css({'border': '1px solid gray'});
        }
        if ((get_telefono().length !== 9) && (!isNaN(get_telefono())))
        {
            $("#_telefono").css({'border': '1px solid red'});
            error++;
            alert("El telefono debe tener un largo de 9 numeros");


        } else {
            $("#_telefono").css({'border': '1px solid gray'});
        }
        if (error > 0) {
            event.preventDefault();
            return false;
        } else {
            return true;
        }

    } catch (err) {
        alert(err, "Error en validar_formulario");
    }

}

function clean_formulario() {
    try {
        clean_nombre();
        clean_email();
        clean_telefono();


    } catch (err) {
        alert(err, "Error en clean_formulario");
    }
}

function clean_nombre() {
    try {
        $("#_nombre").val("");
    } catch (err) {
        alert(err, "Error en clean_titulo");
    }
}
function clean_email() {
    try {
        $("#_email").val("");
    } catch (err) {
        alert(err, "Error en clean_email");
    }
}
function clean_telefono() {
    try {
        $("#_telefono").val("");
    } catch (err) {
        alert(err, "Error en clean_telefono");
    }
}

function Al_Usuarios_exception_handler(exception, message) {
    alert(message + "; Detalle: " + exception);
}
