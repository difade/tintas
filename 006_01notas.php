<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00601']) && ($_POST['00601'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		$sql = "UPDATE otrasn SET 
		fecha = '" . cambiaf_a_mysql($_POST["fecha"]). "', 
		nro = '" . $_POST["nro"]. "',		 
		firma = '" . $_POST["firma"]. "', 
		descripcion = '" . $_POST["descripcion"]. "',
		autoriza = '" . $_POST["autoriza"]. "',
		observaciones = '" . $_POST["observaciones"]."',
		obs1 = '" . $_POST["obs1"]."',
		obs2 = '" . $_POST["obs2"].
		"' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 006_notas.php");
		
}
else {	
	if ($_SESSION["modifica_notas"] && $_POST['00601'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from otrasn where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$nro = $row["nro"];
			$fecha = cambiaf_a_normal($row["fecha"]);
			$firma = $row["firma"];			
			$descripcion = $row["descripcion"];			
			$autoriza = $row["autoriza"];
			$observaciones = $row["observaciones"];			
			$obs1 = $row["obs1"];
			$obs2 = $row["obs2"];
			
			$header_content .="
			<form action='006_01notas.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar Otras Notas</legend>			
			<label>Nro:</label><input type='text' NAME='nro' MAXLENGTH='20' id='campo' value='$nro'> 		
			<label>Fecha:</label><input type='text' NAME='fecha' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" value='$fecha'>			
			<label>Firma</label><input type='text' NAME='firma' MAXLENGTH='20' id='campo' value='$firma'><br>
			<label>Descripcion</label><textarea cols='40' NAME='descripcion' id='campo' onkeypress=\" return limita(this, event,50)\" onkeyup=\"cuenta(this, event,400,'contador')\">$descripcion</textarea><br>
			<label>Autoriza</label><input type='text' NAME='autoriza' MAXLENGTH='20' id='campo' value='$autoriza'><br>
			<label>Observaciones</label><textarea cols='40' NAME='observaciones' id='campo'>$observaciones</textarea><br>
						
			<label>Obs 1</label><textarea cols='40' NAME='obs1' id='campo' onkeypress=\" return limita(this, event,255)\" onkeyup=\"cuenta(this, event,255,'contador')\">$obs1</textarea><br>
			<label>Obs 2</label><textarea cols='40' NAME='obs2' id='campo' onkeypress=\" return limita(this, event,255)\" onkeyup=\"cuenta(this, event,255,'contador')\">$obs2</textarea><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00601' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} else $header_content .="NO HAY DATOS<br>ID=".$id;}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

