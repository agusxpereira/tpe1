<?php
class UserModelo{
    private $db;
    public function __construct(){
     
        $this->db = new PDO('mysql:host=localhost;'.'dbname=DB_TPE;harset=utf8', 'root', '');
    }

    public function getUserByNombre($nombre){
        $query = $this->db->prepare("SELECT * FROM Usuarios WHERE Usuario = ?");
        $query->execute([$nombre]);
        $user = $query->fetch(PDO::FETCH_OBJ); 
        
        return $user;
    }


}