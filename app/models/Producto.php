<?php

class Producto {
    private $conn;
    private $table = "productos";

    public $id_productos;
    public $nombre;
    public $precio;
    public $categoria;

    public function __construct($db){
        $this->conn =  $db;
    }

    public function listar(){
        $query = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
