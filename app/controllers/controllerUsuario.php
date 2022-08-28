<?php 
    include_once '../app/usuario.php';

    class controllerUsuario {
        function obtenerTodosLosUsuarios() {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 2 || $_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Usuario();
                    $respuesta = $classUsuario->obtenerTodosLosUsuarios();
                    return $this->cargarJSON($respuesta);  
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }
            return $json;
        }

        function obtenerUsuarioPorID($id) {
            if(isset($_COOKIE['uniqueToken']) && !empty($_COOKIE['uniqueToken'])) {
                if($_COOKIE['idRol'] == 2 || $_COOKIE['idRol'] == 4 || $_COOKIE['idRol'] == 5){
                    $classUsuario = new Usuario();
                    $respuesta = $classUsuario->obtenerUsuarioPorID($id);
                    return $this->cargarJSON($respuesta);   
                } else {
                    $json = genericResponse::SinAutorizacion_401();
                }
            } else {
                $json = genericResponse::ErrorCliente_400(["Debes iniciar sesión"]);
            }
            return $json;
        }    

        function insertarUsuario($nombre, $apellido, $correo, $password, $idRol) {
            $classUsuario = new Usuario();
            $respuesta = $classUsuario->insertarUsuario($nombre, $apellido, $correo, $password, $idRol);

            return $respuesta;   
        }

        function cargarJSON($respuesta) {
            $totalRegistros = $respuesta->rowCount();
            if($totalRegistros > 0) {
                foreach ($respuesta as $key => $value) {
                    $data[$key] = array(
                        'id' => $value->idUsuario,
                        'nombre' => $value->nombre,
                        'apellido' => $value->apellido,
                        'correo' => $value->correo,
                        'password' => $value->password,
                        'rol' => $value->descripcionRol
                    );
                }
                $json = genericResponse::InformacionRecibida_200($totalRegistros, $data);
            } else {
                $json = genericResponse::ErrorRegistroNoEncontrado_404();
            }

            return $json;
        }        
    }
