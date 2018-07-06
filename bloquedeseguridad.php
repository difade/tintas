<?php session_start();
//Inicio la sesión
//COMPRUEBA QUE EL USUARIO ESTA AUTENTICADO
if ($_SESSION["autenticado"] != "usuario" and $_SESSION["autenticado"] != "admin") 
{
	//si no existe, va a la página de autenticacion
	header("Location: index.php");
	//salimos de este script
	exit();
}
?>
