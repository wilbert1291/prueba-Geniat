<?php
    abstract class validations 
    {

        static function validarID($id, $errores) {
            if(empty($id)) {
                array_push($errores, ["id" => "Se debe enviar el ID del registro a consultar."]);
            } else if(!is_numeric($id)) {
                array_push($errores, ["id" => "Debe ser numérico."]);
            }

            return $errores;
        }

        static function validaNombre($nombre, $errores) {
            if(empty($nombre)) {
                array_push($errores, ["Nombre" => "El campo no puede ir vacío."]);
            } else if(strlen($nombre > 40)){
                array_push($errores, ["Nombre" => "El campo no puede tener mas de 40 caracteres."]);
            }

            return $errores;
        }

        static function validaApellido($apellido, $errores) {
            if(empty($apellido)) {
                array_push($errores, ["Apellido" => "El campo no puede ir vacío."]);
            } else if(strlen($apellido > 40)){
                array_push($errores, ["Apellido" => "El campo no puede tener mas de 40 caracteres."]);
            }

            return $errores;
        }

        static function validarCorreo($correo, $errores) {
            if(empty($correo)) {
                array_push($errores, ["Correo" => "El campo no puede ir vacío."]);
            } else if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                array_push($errores, ["Correo" => "Se debe ingresar un correo válido."]);
            } else if(strlen($correo > 60)){
                array_push($errores, ["Correo" => "El campo no puede tener mas de 60 caracteres."]);
            }

            return $errores;
        }

        static function validarPassword($password, $errores) {
            if(empty($password)) {
                array_push($errores, ["Password" => "El campo no puede ir vacío."]);
            }

            return $errores;
        }

        static function validarRol($idRol, $errores) {
            if(empty($idRol)) {
                array_push($errores, ["Rol" => "Debe seleccionar un Rol."]);
            } else if(!is_numeric($idRol)) {
                array_push($errores, ["Rol" => "Debe ser un número."]);
            }

            return $errores;
        }


        static function validarTitulo($titulo, $errores) {
            if(empty($titulo)) {
                array_push($errores, ["Titulo" => "El campo no puede ir vacío."]);
            } else if(strlen($titulo > 50)){
                array_push($errores, ["Titulo" => "El campo no puede tener mas de 50 caracteres."]);
            }

            return $errores;
        }

        static function validarDescripcion($descripcion, $errores) {
            if(empty($descripcion)) {
                array_push($errores, ["Descripción" => "El campo no puede ir vacío."]);
            } else if(strlen($descripcion > 1000)){
                array_push($errores, ["Descripción" => "El campo no puede tener mas de 1000 caracteres."]);
            }

            return $errores;
        }

        
    }
    
?>