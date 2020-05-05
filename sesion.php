<?php
//Iniciamos sesión
session_start();
//Si existe la variable usuario
if (isset($_SESSION['usuario'])){
	//Pasando los valores a variables de trabajo
	$nombre = $_SESSION['usuario']['nombre'];
	$apellido = $_SESSION['usuario']['apellido'];
}
?>