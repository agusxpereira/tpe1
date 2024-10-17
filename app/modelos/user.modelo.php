<?php
require_once 'Modelo.base.php';
class UserModelo extends ModeloBase{

    public function getUserByNombre($nombre){
        $query = $this->db->prepare("SELECT * FROM Usuarios WHERE Usuario = ?");
        $query->execute([$nombre]);
        $user = $query->fetch(PDO::FETCH_OBJ); 
        
        return $user;
    }


}