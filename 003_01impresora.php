<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00301']) && ($_POST['00301'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		
		$sql = "UPDATE impresora SET
		modelo = '" . $_POST["modelo"]. "', 
		serial = '" . $_POST["serial"].  "', 
		activo = '" . $_POST["activo"]. "', 
		idarea = '" . $_POST["idarea"]. 
		"' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 003_impresora.php");
		
}
else {	
	if ($_SESSION["modifica_impresora"] && $_POST['00301'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from impresora where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$modelo = $row["modelo"];
			$area = "<select name='idarea'>".optionArea($row["idarea"]).optionsArea()."</select>";
			$serial = $row["serial"];
			$activo = $row["activo"];
			$header_content .="
			<form action='003_01impresora.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar impresora</legend>	
			<label>Modelo:</label><input type='text' NAME='modelo' MAXLENGTH='20' id='campo' value='$modelo'>
			<label>Area</label>".$area."<br><br>
			<label>Serial</label><input type='text' NAME='serial' MAXLENGTH='20' id='campo' value='$serial'>			
			<label>Activo:</label><input type='text' NAME='activo' MAXLENGTH='20' id='campo' value='$activo'>
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00301' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

