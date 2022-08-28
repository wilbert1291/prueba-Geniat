<?php
    $routesArray = explode("/", $_SERVER["REQUEST_URI"]);
    $routesArray = array_filter($routesArray);
    
    include_once '../config/genericResponse.php';
    include_once '../config/validations.php';

    if(count($routesArray) == 0) {
        //Respuesta en caso de que no se haga ninguna petición
        $json = genericResponse::ErrorPaginaNoEncontrada_404();
    } else if(count($routesArray) != 0 && isset($_SERVER['REQUEST_METHOD'])){
        //Respuesta cuando si se hace una petición a la API

        include_once '../app/controllers/controllerUsuario.php';
        $api = new controllerUsuario();
        $json = null;
        $errores = array();

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                
                switch ($routesArray[2]) {
                    case 'users':
                        $json = $api->obtenerTodosLosUsuarios();
                        break;
                    case 'user':
                        $id = (isset($_GET['id']) ? $_GET['id'] : "");

                        $errores = validations::validarID($id, $errores);

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }

                        $json = $api->obtenerUsuarioPorID($id);
                        break;
                    
                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;
                }
                break;
            
            case 'POST':
                switch ($routesArray[2]) {
                    case 'addUser':
                        $nombre = (isset($_POST['nombre']) ? $_POST['nombre'] : "");
                        $apellido = (isset($_POST['apellido']) ? $_POST['apellido'] : "");
                        $correo = (isset($_POST['correo']) ? $_POST['correo'] : "");
                        $password = (isset($_POST['password']) ? $_POST['password'] : "");
                        $idRol = (isset($_POST['rol']) ? $_POST['rol'] : "");

                        $errores = validations::validaNombre($nombre, $errores);
                        $errores = validations::validaApellido($apellido, $errores);
                        $errores = validations::validarCorreo($correo, $errores);
                        $errores = validations::validarPassword($password, $errores);
                        $errores = validations::validarRol($idRol, $errores);

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }
                        
                        $json = $api->insertarUsuario($nombre, $apellido, $correo, $password, $idRol);
                        break;
                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;       
                }
                break;
            
            default:
                $json = genericResponse::ErrorPaginaNoEncontrada_404();
                break;
        }
    }

    echo json_encode($json, http_response_code($json['status']));

?>