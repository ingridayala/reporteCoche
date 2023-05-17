<?php

include_once 'conexion.php';

class Titular extends conexion{
    
    // Datos titular: idTitular 	dni 	nombreApellido 	direccion 	cp 	poblacion 	provincia 	email 	telefonoFijo 	telefono 	cuentaBancaria 	fechaHora 	contrasena

    public function newTitular($dni, $nombreApellido, $direccion, $cp, $poblacion, $provincia, $email, $telefonoFijo, $telefono, $cuentaBancaria, $fechaHora, $contrasena){
        $sql = $this -> connect() -> prepare("INSERT INTO titulares (dni, nombreApellido, direccion, cp, poblacion, provincia, email, telefonoFijo, telefono, cuentaBancaria, fechaHora, contrasena) VALUES (:dni, :nombreApellido, :direccion, :cp, :poblacion, :provincia, :email, :telefonoFijo, :telefono, :cuentaBancaria, :fechaHora, :contrasena)");
        $sql -> execute(['dni' => $dni, 'nombreApellido' => $nombreApellido, 'direccion' => $direccion, 'cp' => $cp, 'poblacion' => $poblacion, 'provincia' => $provincia, 'email' => $email, 'telefonoFijo' => $telefonoFijo, 'telefono' => $telefono, 'cuentaBancaria' => $cuentaBancaria, 'fechaHora' => $fechaHora, 'contrasena' => $contrasena]);
    }
    
    // borra un titular de la base de datos pasandole el dni del titular
    public function deleteTitular($dni){
        $sql = $this -> connect() -> prepare("DELETE FROM titulares WHERE dni = :dni");
        $sql -> execute(['dni' => $dni]);
    }
    
    // actualiza un titular en la base de datos pasandole los datos:  idTitular 	dni 	nombreApellido 	direccion 	cp 	poblacion 	provincia 	email 	telefonoFijo 	telefono 	cuentaBancaria 	fechaHora 	contrasena
    public function updateTitular($dni, $nombreApellido, $direccion, $cp, $poblacion, $provincia, $email, $telefonoFijo, $telefono, $cuentaBancaria, $fechaHora, $contrasena){
        $sql = $this -> connect() -> prepare("UPDATE titulares SET nombreApellido = :nombreApellido, direccion = :direccion, cp = :cp, poblacion = :poblacion, provincia = :provincia, email = :email, telefonoFijo = :telefonoFijo, telefono = :telefono, cuentaBancaria = :cuentaBancaria, fechaHora = :fechaHora, contrasena = :contrasena WHERE dni = :dni");
        $sql -> execute(['dni' => $dni, 'nombreApellido' => $nombreApellido, 'direccion' => $direccion, 'cp' => $cp, 'poblacion' => $poblacion, 'provincia' => $provincia, 'email' => $email, 'telefonoFijo' => $telefonoFijo, 'telefono' => $telefono, 'cuentaBancaria' => $cuentaBancaria, 'fechaHora' => $fechaHora, 'contrasena' => $contrasena]);
    }
    
    // devuelve un array con los datos de un titular pasandole el dni del titular
    public function getTitular($dni){
        $sql = $this -> connect() -> prepare("SELECT * FROM titulares WHERE dni = :dni");
        $sql -> execute(['dni' => $dni]);
        $result = $sql -> fetchAll();
        return $result;
    }
    
    // devuelve un array con todos los titulares
    public function getTitulares(){
        $sql = $this -> connect() -> prepare("SELECT * FROM titulares");
        $sql -> execute();
        $result = $sql -> fetchAll();
        return $result;
    }

}

?>