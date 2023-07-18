<?php

$servidor = "localhost";
$baseDatos="curso php develoteca 2";
$usuario="root";
$contraseña="";

try {
    $conexion= new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contraseña);
} catch (Exception $ex) {
echo $ex->getMessage();
};

?>