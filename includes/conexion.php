<?php

class conexion {
    private $host;
    private $bbdd;
    private $user;
    private $pass;
    private $conexion;

    public function __construct() {
        $this->host = "localhost";
        $this->bbdd = "taller";
        $this->user = "root";
        $this->pass = "";
    }

    public function connect() {
        $this->conexion = new mysqli($this->host, $this->user, $this->pass, $this->bbdd);

        if ($this->conexion->connect_error) {
            die("No se ha podido conectar con la base de datos: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");

        return $this->conexion;
    }

    public function close() {
        $this->conexion->close();
    }
}


?>