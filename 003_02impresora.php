<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00302']) && ($_POST['00302'] == "BORRAR"))
{	
	$con = conectar();
		$sql = "UPDATE impresora SET activo=0 WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 003_impresora.php");
		
}
else {	
	//$header_content .="BORRAR";
	if ($_SESSION["modifica_impresora"] && $_POST['00302'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from impresora where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$modelo = $row["modelo"];			
			$serial = $row["serial"];
			$header_content .="
			<form action='003_02impresora.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Borrar Impresora?</legend>	
			<p>Modelo:".$modelo." <br> 		
			Serial:".$serial."<br>
			Area:".mostrarArea($row['idarea'])."<br>
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00302' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

