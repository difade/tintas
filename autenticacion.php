<?php
class ClaseDatos
{
	function role($user,$pass)
	{
	$lee_area=1;
	$lee_ttoner=1;
	$lee_impresora=1;
	$lee_toner=1;
	$lee_historial=1;
	$lee_notas=1;
	$modifica_notas=0;
	$modifica_area=0;
	$modifica_ttoner=0;
	$modifica_impresora=0;
	$modifica_toner=0;
	$modifica_historial=0;	
	$rolp = "noautenticado";
	
	if ($user=="usuario" && $pass=="consulta") 
	{
		$rolp = "usuario";
	}

	if ($user=="gspangaro" && $pass=="sga2220") 
	{
		$rolp = "usuario"; 
		$modifica_area=1;
		$modifica_ttoner=1;
		$modifica_impresora=1;
		$modifica_toner=1;
	}
	if ($user=="achafrat" && $pass=="cami2016") 
	{
		$rolp = "usuario"; 
		$modifica_area=1;
		$modifica_ttoner=1;
		$modifica_impresora=1;		
	}
	if ($user=="administrativo" && $pass=="safadecs")
	{
		$rolp = "admin"; 
		$modifica_notas=1;
		$modifica_area=1;
		$modifica_ttoner=1;
		$modifica_impresora=1;
		$modifica_toner=1;
		$modifica_historial=1;	
	}
	if ($user=="erica" && $pass=="adminptg")
		{ $rolp = "admin"; $modifica_notas=1;
	$modifica_area=1;
	$modifica_ttoner=1;	
	$modifica_impresora=1;
	$modifica_toner=1;
	$modifica_historial=1;}
	if ($user=="aborra" && $pass=="sga2016")
	{
		$rolp = "usuario"; 		
		$modifica_area=1;
		$modifica_ttoner=1;
		$modifica_impresora=1;
	}

	return array($user,$rolp,$lee_area,$lee_ttoner,$lee_impresora,$lee_toner,$lee_historial,$lee_notas,$modifica_notas,$modifica_area, $modifica_ttoner,$modifica_impresora,$modifica_toner,$modifica_historial);
	}

}
$datos = new ClaseDatos();
list($v0,$v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13) = $datos->role($_POST["usuario"],$_POST["contrasena"]);
if ($v1=="noautenticado")
{
	$user=$_POST["usuario"];
	header("Location: index.php?errorusuario=si&usuario=$user");
}
else
{
	session_start();
	$_SESSION["usuario"]= $v0;
	$_SESSION["autenticado"]= $v1;
	$_SESSION["lee_area"]= $v2;
	$_SESSION["lee_ttoner"]= $v3;
	$_SESSION["lee_impresora"]=$v4;
	$_SESSION["lee_toner"]=$v5;
	$_SESSION["lee_historial"]=$v6;
	$_SESSION["lee_notas"]=$v7;
	$_SESSION["modifica_notas"]=$v8;
	$_SESSION["modifica_area"]=$v9;
	$_SESSION["modifica_ttoner"]=$v10;
	$_SESSION["modifica_impresora"]=$v11;
	$_SESSION["modifica_toner"]=$v12;
	$_SESSION["modifica_historial"]=$v13;
	header("Location: inicio.php");
}

?>
