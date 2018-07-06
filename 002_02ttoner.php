<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00202']) && ($_POST['00202'] == "BORRAR"))
{	
	$con = conectar();
		$sql = "DELETE FROM tipotoner WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 002_ttoner.php");
		
}
else {	
	if ($_SESSION["modifica_ttoner"] && $_POST['00202'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from ttoner where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$nombre = $row["nombre"];			
			$rinde = $row["rinde"];
			$header_content .="
			<form action='002_02ttoner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Eliminar Tipo de toner</legend>
			Nombre: ".$nombre."<br>			
			Rinde (paginas)".$rinde."<br>
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00202' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

