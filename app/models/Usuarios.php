<?php

class Usuario {
    private $conn ;
    private $table = "usuarios";

    public $nombre;
    public $email;
    public $password;
    public $direccion;

    public function __construct($db){
        $this->conn = $db;
    }

    public function crear(){
        $query = "INSERT INTO " . $this->table . "
        (nombre, email, password, direccion)
        VALUES (:nombre, :email, :password, :direccion)";

        $stmt = $this->conn->prepare($query);

        //ENCRIPTAR CONTRASEÑA 
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":direccion", $this->direccion); 

        return $stmt->execute();
    }

}