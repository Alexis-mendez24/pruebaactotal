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
    public static function get_all($pagina = 1) {
        $cant_por_pagina = 8;
        $inicio = ($pagina - 1) * $cant_por_pagina;
        try {
            $db = new Db_manager();
            $conn = $db->conn_bd();

            $result = mysqli_query($conn, "SELECT * from usuarios");
            $registros = [];
            while ($r = mysqli_fetch_assoc($result)) {
                $registros[] = $r;
            }

            $result2 = mysqli_query($conn, "SELECT count(*) as CANTIDAD from usuarios");
            $array = mysqli_fetch_assoc($result2);
            $paginas = ceil($array['CANTIDAD'] / $cant_por_pagina);
        } catch (Exception $e) {
            throw new Usuario_exception("Error en get_all(), usuario.class.php");
        }

        return [ 'resultados' => $registros, 'paginas' => $paginas, 'actual' => $pagina];
    }

    public function save() {
        try {

            $db = new Db_manager();

            $conn = $db->conn_bd();

            $sqli = mysqli_query($conn, "INSERT INTO usuarios (nombre,email,telefono)VALUES('$this->nombre','$this->email','$this->telefono')");
        
            
        } catch (Exception $e) {
            throw new Usuario_exception("Error en save(), usuario.class.php");
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

