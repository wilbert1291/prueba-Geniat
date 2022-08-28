<?php
    include_once '../config/rutaServidor.php';
    include_once '../config/genericResponse.php';
    include_once '../config/validations.php';
    
    if(count($routesArray) == 0) {
        //Respuesta en caso de que no se haga ninguna petición
        $json = genericResponse::ErrorPaginaNoEncontrada_404();
    } else if(count($routesArray) != 0 && isset($_SERVER['REQUEST_METHOD'])){
        
        //Respuesta cuando si se hace una petición a la API
        $json = null;
        include_once '../app/controllers/controllerPublicaciones.php';
        $api = new controllerPublicaciones();
        $errores = array();

        $Request_Method = $_SERVER['REQUEST_METHOD'];

        switch ($Request_Method) {
            case 'GET':
                switch ($functionEjecutar) {
                    case 'Posts':
                        $json = $api->consultarPublicaciones();
                        break;
                    case 'Post':
                        $idPublicacion = (isset($_GET['idPublicacion']) ? $_GET['idPublicacion'] : "");

                        $errores = validations::validarID($idPublicacion, $errores);

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }

                        $json = $api->consultarPublicaciones();
                        break;
                    
                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;
                }
                break; 

            case 'POST':
                switch ($functionEjecutar) {
                    case 'createPost':
                        $titulo = (isset($_POST['titulo']) ? $_POST['titulo'] : "");
                        $descripcion = (isset($_POST['descripcion']) ? $_POST['descripcion'] : "");

                        $errores = validations::validarTitulo($titulo, $errores);
                        $errores = validations::validarDescripcion($descripcion, $errores);

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }

                        $json = $api->crearPublicacion($titulo, $descripcion);
                        break;
                    
                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;
                }
                break;

            case 'PUT':
                switch ($functionEjecutar) {
                    case 'updatePost':
                        $datos = json_decode(file_get_contents('php://input'));
                        
                        if($datos != null) {

                            $idPublicacion = (isset($datos->idPublicacion) ? $datos->idPublicacion : "");
                            $titulo = (isset($datos->titulo) ? $datos->titulo : "");
                            $descripcion = (isset($datos->descripcion) ? $datos->descripcion : "");

                            $errores = validations::validarID($idPublicacion, $errores);
                            $errores = validations::validarTitulo($titulo, $errores);
                            $errores = validations::validarDescripcion($descripcion, $errores);

                            if(count($errores) != 0) {
                                $json = genericResponse::ErrorCliente_400($errores);
                                break;
                            }

                            $json = $api->actualizarPublicacion($titulo, $descripcion, $idPublicacion);
                        }
                        break;
                    
                    default:
                        $json = genericResponse::ErrorPaginaNoEncontrada_404();
                        break;
                }
                break;

            case 'DELETE':
                switch ($functionEjecutar) {
                    case 'deletePost':
                        $idPublicacion = (isset($_GET['idPublicacion']) ? $_GET['idPublicacion'] : "");
                        
                        $errores = validations::validarID($idPublicacion, $errores);

                        if(count($errores) != 0) {
                            $json = genericResponse::ErrorCliente_400($errores);
                            break;
                        }

                        $json = $api->eliminarPublicacion($idPublicacion);
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