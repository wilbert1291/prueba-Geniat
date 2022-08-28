<?php
    require_once "../vendor/autoload.php";
    use Firebase\JWT\JWT;

    class JWTGenerator {
        static public function generadorJWT($id, $correo, $rol) {
            $tiempo = time(); //Fecha actual
            $tiempoExpiracion = $tiempo  + (60*60*24); //1 dia mas

            $token = array(
                "iat" => $tiempo, //Inicio del token
                "exp" => $tiempoExpiracion, //Tiempo de expiracion del token
                "data" => [
                    "id" => $id,
                    "email" => $correo,
                    "rol" => $rol
                ]
            );

            $tokenbin2Hex = bin2hex(random_bytes((20 - (20 % 2)) / 2));
            $jwt = JWT::encode($token, $tokenbin2Hex, 'HS256');

            $respuesta = json_encode(array('data' => $token, 'tokenJWT' => $jwt));

            return $respuesta;
        }
    }
?>