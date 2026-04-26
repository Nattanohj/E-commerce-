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

    public function login(){
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            if(password_verify($this->password, $usuario['password'])){
                return $usuario;
            }
        }

        return false;
    }

}