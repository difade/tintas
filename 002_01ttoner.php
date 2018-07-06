<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00201']) && ($_POST['00201'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		$sql = "UPDATE tipotoner SET 
			nombre = '" . $_POST["nombre"] . "',			 
			rinde = '" . $_POST["rinde"] . "'  
			 WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 002_ttoner.php");
		
}
else {	
	if ($_SESSION["modifica_ttoner"] && $_POST['00201'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from tipotoner where id='$id'";
		//$header_content .= $sql;
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$nombre = $row["nombre"];			
			$rinde = $row["rinde"];
			$header_content .="
			<form action='002_01ttoner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar Tipo de Toner</legend>
			<label>Nombre:</label><input type='text' NAME='nombre' MAXLENGTH='50' id='campo' value='$nombre'> 		
			<label>Rinde (paginas)</label><input type='text' NAME='rinde' MAXLENGTH='50' id='campo' value='$rinde'><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00201' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

