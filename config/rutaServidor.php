<?php
    $routesArray = explode("/", $_SERVER["REQUEST_URI"]);
    $routesArray = array_filter($routesArray);

    $functionEjecutar = $routesArray[2];
?>