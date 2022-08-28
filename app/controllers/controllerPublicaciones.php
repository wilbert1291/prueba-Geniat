<?php 
    include_once '../app/publicaciones.php';

    class controllerPublicaciones {
        function crearPublicacion($titulo, $descripcion) {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 3 || $_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Publicaciones();
                    $respuesta = $classUsuario->crearPublicacion($titulo, $descripcion);
                    return $respuesta;   
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }

            return $json;
        }

        function actualizarPublicacion($titulo, $descripcion, $idPublicacion) {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Publicaciones();
                    $respuesta = $classUsuario->actualizarPublicacion($titulo, $descripcion, $idPublicacion);
                    return $respuesta;   
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }

            return $json;
        }

        function eliminarPublicacion($idPublicacion) {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 5){
                    $classUsuario = new Publicaciones();
                    $respuesta = $classUsuario->eliminarPublicacion($idPublicacion);
                    return $respuesta;  
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }

            return $json;
        }

        function consultarPublicaciones() {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 2 || $_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Publicaciones();
                    $respuesta = $classUsuario->consultarPublicaciones();
                    return $this->cargarJSON($respuesta);  
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }

            return $json;
        }

        function consultarPublicacionID($id) {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 2 || $_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Publicaciones();
                    $respuesta = $classUsuario->consultarPublicacionID($id);
                    return $this->cargarJSON($respuesta);  
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }

            return $json;
        }

        function cargarJSON($respuesta) {
            $totalRegistros = $respuesta->rowCount();
            if($totalRegistros > 0) {
                foreach ($respuesta as $key => $value) {
                    $data[$key] = array(
                        'id' => $value->idPublicacion,
                        'titulo' => $value->titulo,
                        'descripcion' => $value->descripcion,
                        'fechaCreacion' => $value->fechaCreacion,
                        'autor' => $value->autor
                    );
                }
                $json = genericResponse::InformacionRecibida_200($totalRegistros, $data);
            } else {
                $json = genericResponse::ErrorRegistroNoEncontrado_404();
            }

            return $json;
        }   
    }

    
    
?>