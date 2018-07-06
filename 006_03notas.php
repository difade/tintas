<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00603']) && ($_POST['00603'] == "Guardar"))
{	
	$con = conectar();
	$fecha = $_POST["fecha"];
		if (is_null($fecha) or $fecha =="")
			$fecha = "1970-01-01";
		else $fecha = cambiaf_a_mysql($_POST["fecha"]);
		//Insert record into database
		$sql = "INSERT INTO otrasn(nro,fecha,firma,descripcion,autoriza,observaciones,obs1,obs2) VALUES ('" .$_POST["nro"]."','".$fecha."','". $_POST["firma"]. "', '" . $_POST["descripcion"] . "', '" . $_POST["autoriza"]. "', '" . $_POST["observaciones"]. "', '" . $_POST["obs1"]. "', '" . $_POST["obs1"]."');";
		$result = mysqli_query($con,$sql);		
				
	historial($sql,$_SESSION["usuario"]);
	//Close database connection
	mysqli_close($con);
 	header("Location: 006_notas.php");
		
}
else {	
	if ($_SESSION["modifica_notas"])
		{			
			$header_content .="
			<form action='006_03notas.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar pedido de Ayuda Economica</legend>			
			<label>Nro:</label><input type='text' NAME='nro' MAXLENGTH='20' id='campo'> 		
			<label>Fecha:</label><input type='text' NAME='fecha' MAXLENGTH='10' id='campo' onkeyup=\"mascara(this,'/',patron,true)\" onBlur=\"esFechaValida(this);\">			
			<label>Firma</label><input type='text' NAME='firma' MAXLENGTH='20' id='campo'><br>
			<label>Descripcion</label><textarea cols='40' NAME='descripcion' id='campo' onkeypress=\" return limita(this, event50)\" onkeyup=\"cuenta(this, event,400,'contador')\"></textarea><br><br>
			<label>Autoriza</label><input type='text' NAME='autoriza' MAXLENGTH='20' id='campo'><br>
			<label>Observaciones</label><textarea cols='40' NAME='observaciones' id='campo'></textarea><br>
			<label>Obs 1</label><textarea cols='40' NAME='obs1' id='campo' onkeypress=\" return limita(this, event,255)\" onkeyup=\"cuenta(this, event,255,'contador')\"></textarea><br>
			<label>Obs 2</label><textarea cols='40' NAME='obs2' id='campo' onkeypress=\" return limita(this, event,255)\" onkeyup=\"cuenta(this, event,255,'contador')\"></textarea><br>
			
			<input type='submit' NAME='00603' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

