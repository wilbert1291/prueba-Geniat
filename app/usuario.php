<?php 
    include_once("../config/conexion.php");

    class Usuario extends conexion {
        function obtenerTodosLosUsuarios() {
            $sql = "select u.idUsuario, u.nombre, u.apellido, u.correo, u.password, tr.descripcionRol from tblusuarios u inner join tblroles tr on u.idRol = tr.idRol;";
            $query = $this->conexion()->query($sql);
            return $query;
        }

        function obtenerUsuarioPorID($id) {
            $sql = "select u.idUsuario, u.nombre, u.apellido, u.correo, u.password, tr.descripcionRol from tblusuarios u inner join tblroles tr on u.idRol = tr.idRol where u.idUsuario = :id;";
            $query = $this->conexion()->prepare($sql);
            $query->execute([
                'id' => $id
            ]);
            return $query;
        }

        function insertarUsuario($nombre, $apellido, $correo, $password, $idRol) {

            $conexion = $this->conexion();

            //Validar correo repetido
            $sql = "SELECT correo FROM tblusuarios WHERE correo = :correo;";
            $query = $conexion->prepare($sql);
            $query->execute([
                'correo' => $correo
            ]);

            if($query->rowCount() > 0) {
                $json = genericResponse::ErrorCliente_400(["Ya existe un usuario con el correo: " . $correo]);
                return $json;
            }

            //Validar Rol Existente
            $sql = "SELECT idRol FROM tblroles WHERE idRol = :idRol;";
            $query = $conexion->prepare($sql);
            $query->execute([
                'idRol' => $idRol
            ]);

            if($query->rowCount() == 0) {
                $json = genericResponse::ErrorCliente_400(["El Rol seleccionado no existe, favor de seleccionar uno valido."]);
                return $json;
            }

            //Proceder a insertar el usuario
            $sql = "INSERT INTO tblusuarios (nombre, apellido, correo, password, idRol) VALUES (:nombre, :apellido, :correo, md5(:password), :idRol);";
            $query = $conexion->prepare($sql);
            $query->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $query->bindParam(":apellido", $apellido, PDO::PARAM_STR);
            $query->bindParam(":correo", $correo, PDO::PARAM_STR);
            $query->bindParam(":password", $password, PDO::PARAM_STR);
            $query->bindParam(":idRol", $idRol, PDO::PARAM_INT);
            $query->execute();

            //Se obtiene el ultimo ID ingresado
            $lastId = $conexion->lastInsertId();
                   
            if($lastId != 0) {
                $data = array(
                    "idUsuario" => $lastId,
                    "Nombre" => $nombre,
                    "Apellido" => $apellido,
                    "Correo" => $correo,
                    "Rol" => $idRol
                );
                $json = genericResponse::PeticionCompletaConExito_201("POST", $data);
            } else {
                $data = array(
                    "Nombre" => $nombre,
                    "Apellido" => $apellido,
                    "Correo" => $correo,
                    "Rol" => $idRol
                );
                $json = genericResponse::ErrorDelServidor_500($data);
            }
            
            return $json;
        }
    }
?>