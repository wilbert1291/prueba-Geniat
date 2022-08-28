<?php 
    include_once("../config/conexion.php");

    class Publicaciones extends conexion {
        function crearPublicacion($titulo, $descripcion) {
            $conexion = $this->conexion();

            $sql = "INSERT INTO tblpublicaciones (titulo, descripcion, fechaCreacion, idUsuario, borrado) VALUES (:titulo, :descripcion, NOW(), :idUsuario, 0);";
            $query = $conexion->prepare($sql);
            $query->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $query->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $query->bindParam(":idUsuario", $_COOKIE['idUsuario'], PDO::PARAM_INT);
            $query->execute();

            //Se obtiene el ultimo ID ingresado
            $lastId = $conexion->lastInsertId();

            if($lastId != 0) {
                $data = array(
                    "idPublicacion" => $lastId,
                    "titulo" => $titulo,
                    "idUsuario" => $_COOKIE['idUsuario']
                );

                $json = genericResponse::PeticionCompletaConExito_201("POST", $data);

            } else {
                $data = array(
                    "titulo" => $titulo,
                    "descripcion" => $descripcion,
                    "idUsuario" => $_COOKIE['idUsuario'],
                );

                $json = genericResponse::ErrorDelServidor_500($data);
            }
            
            return $json;
        }

        function actualizarPublicacion($titulo, $descripcion, $idPublicacion){
            $conexion = $this->conexion();
            
            $sql = "SELECT idPublicacion FROM tblpublicaciones WHERE idPublicacion = :idPublicacion AND borrado = 1;";
            $query = $conexion->prepare($sql);
            $query->bindParam(":idPublicacion", $idPublicacion, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() > 0) {
                $json = genericResponse::ErrorCliente_400(["El registro que intentas actualizar ya no esta disponible."]);
                return $json;
            }

            $sql = "UPDATE tblpublicaciones SET titulo = :titulo, descripcion = :descripcion WHERE idPublicacion = :idPublicacion;";
            $query = $conexion->prepare($sql);
            $query->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $query->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $query->bindParam(":idPublicacion", $idPublicacion, PDO::PARAM_INT);
            $query->execute();

            $data = array(
                "idPublicacion" => $idPublicacion,
                "titulo" => $titulo,
                "idUsuario" => $_COOKIE['idUsuario'],
                "idRol" => $_COOKIE['idRol']
            );

            $json = genericResponse::PeticionCompletaConExito_201("PUT", $data);
            
            return $json;
        }

        function eliminarPublicacion($idPublicacion) {
            $conexion = $this->conexion();

            $sql = "SELECT idPublicacion FROM tblpublicaciones WHERE idPublicacion = :idPublicacion AND borrado = 1;";
            $query = $conexion->prepare($sql);
            $query->bindParam(":idPublicacion", $idPublicacion, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() > 0) {
                $json = genericResponse::ErrorCliente_400(["El registro que intentas eliminar ya ha sido eliminado."]);
                return $json;
            }

            $sql = "UPDATE tblpublicaciones SET borrado = 1 WHERE idPublicacion = :idPublicacion;";
            $query = $conexion->prepare($sql);
            $query->bindParam(":idPublicacion", $idPublicacion, PDO::PARAM_INT);
            $query->execute();

            $data = array(
                "idPublicacion" => $idPublicacion,
                "idUsuario" => $_COOKIE['idUsuario'],
                "idRol" => $_COOKIE['idRol'],
            );

            $json = genericResponse::PeticionCompletaConExito_201("DELETE", $data);
            
            return $json;
        }

        function consultarPublicaciones() {
            $conexion = $this->conexion();
            $sql = "SELECT tp.idPublicacion, tp.titulo, tp.descripcion, tp.fechaCreacion, concat(tu.nombre, ' ',tu.apellido, ' - ', tr.descripcionRol) AS autor FROM tblpublicaciones tp INNER JOIN tblusuarios tu ON tp.idUsuario = tu.idUsuario INNER JOIN tblroles tr ON tr.idRol = tu.idRol WHERE tp.borrado = 0;";
            $query = $conexion->query($sql);
            return $query;
        }

        function consultarPublicacionID($idPublicacion) {
            $conexion = $this->conexion();

            $sql = "SELECT tp.idPublicacion, tp.titulo, tp.descripcion, tp.fechaCreacion, concat(tu.nombre, ' ',tu.apellido, ' - ', tr.descripcionRol) AS autor FROM tblpublicaciones tp INNER JOIN tblusuarios tu ON tp.idUsuario = tu.idUsuario INNER JOIN tblroles tr ON tr.idRol = tu.idRol WHERE tp.borrado = 0 AND tp.idPublicacion = :id;";
            $query = $conexion->prepare($sql);
            $query->execute([
                'id' => $idPublicacion
            ]);
            return $query;
        }
    }
?>