<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00101']) && ($_POST['00101'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		$sql = "UPDATE area SET 
			nombre = '" . $_POST["nombre"] . "'
			 WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 001_area.php");
		
}
else {	
	if ($_SESSION["modifica_area"] && $_POST['00101'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from area where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$nombre = $row["nombre"];			
			$header_content .="
			<form action='001_01area.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar Area</legend>
			<label>Nombre</label><input type='text' NAME='nombre' MAXLENGTH='50' id='campo' value='$nombre'><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00101' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} else $header_content .="NO HAY DATOS";}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

