<?php
    abstract class genericResponse 
    {
        static function ConexionExitosa_200() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 200,
                'message' => 'Conexión establecida.',
                'token' => $token
            );
            return $json;
        }

        static function InformacionRecibida_200($length, $data) {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 200,
                'message' => 'Información obtenida exitosamente.',
                'length' => $length,
                'token' => $token,
                'data' => $data
            );
            return $json;
        }

        static function SesionIniciada_200($token) {
            $json = array(
                'status' => 200,
                'message' => 'Sesion iniciada exitosamente.',
                'token' => $token
            );
            return $json;
        }

        static function SesionCerrada_200() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 200,
                'message' => 'Sesion cerrada exitosamente.',
                'token' => $token
            );
            return $json;
        }

        static function PeticionCompletaConExito_201($metodo, $data = null) {
            $mensaje = "Acción ejecutada con éxito";
            if ($metodo == "POST") {
                $mensaje = "Registro se ha creado satisfactoriamente.";    
            } else if($metodo == "PUT") {
                $mensaje = "Registro se ha actualizado satisfactoriamente.";
            } else if($metodo == "DELETE") {
                $mensaje = "Registro se ha eliminado satisfactoriamente.";
            }

            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 201,
                'message' => $mensaje,
                'data' => $data,
                'token' => $token
            );
            return $json;
        }

        static function ErrorCliente_400($errores) {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 400,
                'message' => 'Se han encontrado uno o varios errores.',
                'errores' => $errores, 
                'token' => $token
            );
            return $json;
        }

        static function SesionIniciada_400() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 400,
                'message' => 'Ya cuentas con una sesión iniciada.',
                'token' => $token
            );
            return $json;
        }

        static function SesionCerrada_400() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 400,
                'message' => 'No cuentas con ninguna sesión activa.',
                'token' => $token
            );
            return $json;
        }

        static function SinAutorizacion_401() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 401,
                'message' => 'No cuentas con permisos para realizar esta acción.',
                'token' => $token
            );
            return $json;
        }

        static function ErrorPaginaNoEncontrada_404() {
            $json = array(
                'status' => 404,
                'message' => 'Pagina no encontrada.'
            );
            return $json;
        }

        static function ErrorRegistroNoEncontrado_404() {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 404,
                'message' => 'Sin información recibida.',
                'token' => $token
            );
            return $json;
        }

        static function ErrorDelServidor_500($data) {
            $token = (isset($_COOKIE['uniqueToken']) ? $_COOKIE['uniqueToken'] : null);
            $json = array(
                'status' => 500,
                'message' => 'Error desconocido por parte del servidor',
                'token' => $token,
                'datosUsuario' => $data
            );
            return $json;
        }
    }
    
?>