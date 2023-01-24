<?php

include_once(dirname(__FILE__) . '/db_manager.class.php');

class Usuario {

    private $id;
    private $nombre;
    private $email;
    private $telefono;
    private $fecha;

    public function get_id() {
        return $this->id;
    }

    public function set_id($value) {
        $this->id = $value;
    }

    public function get_nombre() {
        return $this->nombre;
    }

    public function set_nombre($value) {
        $this->nombre = $value;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($value) {
        $this->email = $value;
    }

    public function get_telefono() {
        return $this->telefono;
    }

    public function set_telefono($value) {
        $this->telefono = $value;
    }

    public function get_fecha() {
        return $this->fecha;
    }

    public function set_fecha($value) {
        $this->fecha = $value;
    }

    public function _construct() {
        $this->id = "";
        $this->nombre = "";
        $this->email = "";
        $this->telefono = "";
        $this->fecha = "";
    }

    //Retorna todos los usuarios.
    public static function get_all($ret) {
        $ret = array();
        try {
            $db = new Db_manager();
            $conn = $db->conn_bd();

            $result = mysqli_query($conn, "SELECT * from usuarios");
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $count = $count + 1;
                $usuario = new Usuario();
                $usuario->id = $row['id'];
                $usuario->nombre = $row["nombre"];
                $usuario->email = $row["email"];
                $usuario->telefono = $row["telefono"];
                $usuario->fecha = $row["fecha"];

                array_push($ret, $usuario);
            }
            
        } catch (Exception $e) {
            throw new Oportunidad_exception("Error en get_all(), usuario.class.php");
        }

        return $ret;
    }

    public function save() {
        try {


            $db = new Db_manager();

            $conn = $db->conn_bd();

            $sqli = mysqli_query($conn, "INSERT INTO usuarios (nombre,email,telefono)VALUES('$this->nombre','$this->email','$this->telefono')");

//            $sqlCommand = new Db_command("CALL `alta_usuario`(@nombre,@email,@telefono);");
//            $sqlCommand->assign_string_param("@nombre", $this->nombre);
//            $sqlCommand->assign_string_param("@email", $this->email);
//            $sqlCommand->assign_string_param("@telefono",$this->telefono);
//            $sqlCommand->assign_string_param("@fecha",$this->fecha);


            $raw_info = $db->execute_command($sqli);
        } catch (Exception $e) {
            throw new Oportunidad_exception("Error en save(), usuario.class.php");
        }
    }

}

class Usuario_exception extends Exception {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        if (!$message) {
            $message = sprintf('Error en usuario.class.php');
        }
        parent::__construct($message, $code, $previous);
    }

}
?>

