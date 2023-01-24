<?php

date_default_timezone_set('America/Montevideo');

class Db_manager {

    private $con;

    public function get_connection_string() {
        return $this->con;
    }

    public function set_connection_string($value) {
        $this->con = $value;
    }

    public function __construct($connection_string = null) {
        if ($connection_string === null) {

            $URL = "localhost";
            $user = "root";
            $pass = "";
            $bd = "prueba_actotal";

            $this->con = new mysqli($URL, $user, $pass, $bd); //A definir
            $this->con->set_charset("utf8");
        }
    }

    public function conn_bd() {


        $URL = localhost;
        $user = "root";
        $pass = "";
        $bd = "prueba_actotal";

        $conn = new mysqli($URL, $user, $pass, $bd); //A definir
        $conn->set_charset("utf8");

        return $conn;
    }

    //retorna un array de arrays asociativo, uno por cada select
    //retorna null en caso de error
    public function execute_command($sql_command_obj) {
        $ret = array();
        try {
            $sql = $sql_command_obj->get_str_command();

            if (mysqli_multi_query($this->con, $sql)) {
                do {
                    $table = array();

                    if ($result = mysqli_store_result($this->con)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            array_push($table, $row);
                        }

                        mysqli_free_result($result);
                        array_push($ret, $table);
                    }
                } while (mysqli_more_results($this->con) && mysqli_next_result($this->con));
            }
        } catch (Exception $e) {
            throw new Db_manager_exception("Error en execute_command(), db_manager.class.php");
        }

        return $ret;
    }

}

class Db_command {

    private $sql_command;

    public function __construct($sql_raw_command) {
        $this->sql_command = $sql_raw_command;

        $this->sql_command = str_replace(" ", "", $this->sql_command);
        $this->sql_command = str_replace("@", "\\", $this->sql_command);
        $this->sql_command = str_replace(",", "\\,", $this->sql_command);
        $this->sql_command = str_replace(")", "\\)", $this->sql_command);
    }

    public function assign_ddmmyyyy_param($key, $value) {
        $key = "\\" . str_replace("@", "", $key) . "\\";

        $d = DateTime::createFromFormat('d/m/Y', $value);

        if ($d) {
            $this->sql_command = str_replace($key, "'" . $d->format('Y-m-d') . "'", $this->sql_command);
        } else {
            $this->sql_command = str_replace($key, "NULL", $this->sql_command);
        }
    }

    public function assign_null_param($key) {
        $key = "\\" . str_replace("@", "", $key) . "\\";

        $this->sql_command = str_replace($key, "NULL", $this->sql_command);
    }

    public function assign_numeric_param($key, $value) {
        $key = "\\" . str_replace("@", "", $key) . "\\";

        if ($value === null || $value === -1) {
            $this->sql_command = str_replace($key, "NULL", $this->sql_command);
        } else {
            $this->sql_command = str_replace($key, $value, $this->sql_command);
        }
    }

    public function assign_string_param($key, $value) {
        $key = "\\" . str_replace("@", "", $key) . "\\";

        if ($value === null || trim($value) === "") {
            $this->sql_command = str_replace($key, "NULL", $this->sql_command);
        } else {
            $value = str_replace("&", "&amp;", $value);
            $value = str_replace('"', "&quot;", $value);
            $value = str_replace("<", "&lt;", $value);
            $value = str_replace(">", "&gt;", $value);
            $value = str_replace("'", "&#34;", $value);
            $value = str_replace("\\", "/", $value);
            $value = str_replace("\n", "&#13;", $value);
            $value = str_replace("\r", "&#10;", $value);

            $this->sql_command = str_replace($key, "'" . trim($value) . "'", $this->sql_command);
        }
    }

    public function get_str_command() {
        return $this->sql_command;
    }

}

class Db_manager_exception extends Exception {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        if (!$message) {
            $message = sprintf('Error en db_manager.class.php');
        }
        parent::__construct($message, $code, $previous);
    }

}

?>