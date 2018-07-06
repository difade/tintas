<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00102']) && ($_POST['00102'] == "BORRAR"))
{	
	$con = conectar();
		$sql = "DELETE FROM area WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 001_area.php");
		
}
else {	
	if ($_SESSION["modifica_area"] && $_POST['00102'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from area where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {	
			$nombre = $row["nombre"];			
			$header_content .="
			<form action='001_02area.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Eliminar Area</legend>
			Nombre: ".$nombre."<br>				 
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00102' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

