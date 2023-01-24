<?php

include_once(dirname(__FILE__) . '/../reglas_negocio/usuario.class.php');

class cb_Usuarios {

    public static function carga_usuarios($param) {
        

        try {
            $usuarios = Usuario::get_all($param);
            

			foreach($usuarios as $item){
				json_encode($array) = array($item->get_nombre(),$item->get_email(), $item->get_telefono(), $item->get_fecha());			
			}
        } catch (Exception $err) {

            cb_Usuarios::ajax_error_handler($err, "Error en carga_usuario.");
        }
        echo $array;
    }

    public static function guardar_usuario($nombre, $email, $telefono) {
        $echoVar = "error";
        try {


            $usuario = new Usuario();
            $usuario->set_nombre($nombre);
            $usuario->set_email($email);
            $usuario->set_telefono($telefono);


            $usuario->save();
        } catch (Exception $err) {

            cb_Usuarios::ajax_error_handler($err, "Error en guardar_usuario.");
        }
        echo $echoVar;
    }

}

try {
    //Derivamos a las funciones que son llamadas desde ajax
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'carga_usuarios' :
                cb_Usuarios::carga_usuarios($_POST['usuarios']);
                break;

            case 'guardar_usuario' :
                cb_Usuarios::guardar_usuario($_POST['nombre'], $_POST['email'], $_POST['telefono']);
                break;
        }
    }
} catch (Exception $err) {
    cb_Usuarios::ajax_error_handler($err, "Error en al delegar ajax.");
}
?>