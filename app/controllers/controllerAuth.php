<?php 
    include_once '../app/auth.php';

    class controllerAuth {
        function loginUsuario($correo, $password) {
            if(!isset($_COOKIE['uniqueToken']) && empty($_COOKIE['uniqueToken'])) {
                $classUsuario = new Auth();
                $respuesta = $classUsuario->loginUsuario($correo, $password);
                return $respuesta;
            } else{
                $json = genericResponse::SesionIniciada_400();
                return $json;
            }
        }

        function cerrarSesion() {
            if(!isset($_COOKIE['uniqueToken']) && empty($_COOKIE['uniqueToken'])) {
                $json = genericResponse::SesionCerrada_400();
                return $json;
            } else{
                $classUsuario = new Auth();
                $respuesta = $classUsuario->cerrarSesion();
                return $respuesta;
            }
        }
    }

    
    
?>