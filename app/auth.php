<?php 
    include_once("../config/conexion.php");

    class Auth extends conexion {
        function loginUsuario($correo, $password) {
            $conexion = $this->conexion();
            $sql = "SELECT idUsuario, correo, idRol FROM tblusuarios WHERE correo = :correo AND password = md5(:password);";
            $query = $conexion->prepare($sql);
            $query->bindParam(":correo", $correo, PDO::PARAM_STR);
            $query->bindParam(":password", $password, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount() != 0) {
                $datos = $query->fetch(PDO::FETCH_ASSOC);
                $idUsuario = $datos['idUsuario'];
                $correo = $datos['correo'];
                $idRol = $datos['idRol'];

                //Se genera el JWT
                $jwt = JWTGenerator::generadorJWT($idUsuario, $correo, $idRol);

                $jwtResponse = json_decode($jwt);

                $tokenJWT = $jwtResponse->tokenJWT;
                $creacionToken = $jwtResponse->data->iat;
                $expiracionToken = $jwtResponse->data->exp;

                //Se actualiza el usuario en la BD
                $sql = "UPDATE tblusuarios SET tokenJWT = :tokenJWT, creacionToken = :creacionToken, expiracionToken = :expiracionToken WHERE idUsuario = :idUsuario";
                $query = $conexion->prepare($sql);
                $query->bindParam(":tokenJWT", $tokenJWT, PDO::PARAM_STR);
                $query->bindParam(":creacionToken", $creacionToken, PDO::PARAM_STR);
                $query->bindParam(":expiracionToken", $expiracionToken , PDO::PARAM_STR);
                $query->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
                $query->execute();

                //Guardar coockies
                setcookie('idUsuario',      $idUsuario,     $expiracionToken);
                setcookie('correo',         $correo,        $expiracionToken);
                setcookie('idRol',          $idRol,         $expiracionToken);
                setcookie('uniqueToken',    $tokenJWT,      $expiracionToken);

                $json = genericResponse::SesionIniciada_200($tokenJWT);
            } else {
                $json = genericResponse::ErrorCliente_400(["El correo o la contraseña son incorrectos."]);
            }

            return $json;
        }

        function cerrarSesion() {
            setcookie('idUsuario',      '',     time()-60);
            setcookie('correo',         '',     time()-60);
            setcookie('idRol',          '',     time()-60);
            setcookie('uniqueToken',    '',     time()-60);
            $json = genericResponse::SesionCerrada_200();
            return $json;
        }
    }
?>