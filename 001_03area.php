<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00103']) && ($_POST['00103'] == "Guardar"))
{	
	$con = conectar();
	$fecha = $_POST["fecha"];
		if (is_null($fecha) or $fecha =="")
			$fecha = "1970-01-01";
		else $fecha = cambiaf_a_mysql($_POST["fecha"]);
		//Insert record into database
		
		$sql = "INSERT INTO area(nombre) VALUES ('". $_POST["nombre"] ."');";
		$result = mysqli_query($con,$sql);		
				
	historial($sql,$_SESSION["usuario"]);
	//Close database connection
	mysqli_close($con);
 	header("Location: 001_area.php");
		
}
else {	
	if ($_SESSION["modifica_area"])
		{			
			$header_content .="
			<form action='001_03area.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar Area</legend>			
			<label>Nombre:</label><input type='text' NAME='nombre' MAXLENGTH='20' id='campo'>
			
			<input type='submit' NAME='00103' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

