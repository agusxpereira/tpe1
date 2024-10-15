<?php
    function sessionAuthMiddleware($res){
        
        session_start();
        if(isset($_SESSION['USER_ID'])){
            //si la cookie se inicio en algún momento
            $res->user = new stdClass();
            //creamos la clase user en res
            $res->user->id = $_SESSION['USER_ID'];
            $res->user->email = $_SESSION['USER'];
            return;
        }
    }
?>
