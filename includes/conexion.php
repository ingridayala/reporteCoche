<?php

class conexion{
    private $host;
    private $bbdd;
    private $user;
    private $pass;

    public function __construct(){
        $this -> host = "192.168.1.237";
        $this -> bbdd = "wetaxi";
        $this -> user = "root";
        $this -> pass = "";
    }
    function connect(){
        try{
            $conexion = new PDO('mysql:host='.$this->host.';dbname='.$this->bbdd,$this->user,$this->pass);
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }catch(Exception $e){
            echo "No se ha podido conectar con la base de datos" . $e->getMessage();
        }
    }
}

?>