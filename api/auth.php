<?php
    $routesArray = explode("/", $_SERVER["REQUEST_URI"]);
    $routesArray = array_filter($routesArray);

    include_once '../config/genericResponse.php';
    include_once '../config/validations.php';
    include_once '../config/jwt.php';
    
    if(count($routesArray) == 0) {
        //Respuesta en caso de que no se haga ninguna petición
        $json = genericResponse::ErrorPaginaNoEncontrada_404();
    } else if(count($routesArray) != 0 && isset($_SERVER['REQUEST_METHOD'])){
        
        //Respuesta cuando si se hace una petición a la API
        $json = null;
        include_once '../app/controllers/controllerAuth.php';
        $api = new controllerAuth();
        $errores = array();

        $Request_Method = $_SERVER['REQUEST_METHOD'];

        switch ($Request_Method) {
            case 'GET':
                switch ($routesArray[2]) {
                    case "cerrar_sesion":
                        $json = $api->cerrarSesion();
                        break;

                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;
                    
                }
                break; 

            case 'POST':
                switch ($routesArray[2]) {
                    case 'iniciar_sesion':
                        $correo = (isset($_POST['correo']) ? $_POST['correo'] : "");
                        $password = (isset($_POST['password']) ? $_POST['password'] : "");

                        $errores = validations::validarCorreo($correo, $errores);
                        $errores = validations::validarPassword($password, $errores);                      

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }

                        $json = $api->loginUsuario($correo, $password);
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