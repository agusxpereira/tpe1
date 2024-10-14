<?php
class UserModelo{
    private $db;
    public function __construct(){
     
        $this->db = new PDO('mysql:host=localhost;'.'dbname=DB_TPE;harset=utf8', 'root', '');
    }

    public function getUserByEmail($email){
        $query = $this->db->prepare("SELECT * FROM Usuarios WHERE Usuario = ?");
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_OBJ); 
        
        return $user;
    }


}