<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00203']) && ($_POST['00203'] == "Guardar"))
{	
	$con = conectar();			
	//Insert record into database
	$sql = "INSERT INTO tipotoner(nombre,rinde) VALUES ('" .$_POST["nombre"]."','" . $_POST["rinde"]."');";
	$result = mysqli_query($con,$sql);
				
	historial($sql,$_SESSION["usuario"]);
	//Close database connection
	mysqli_close($con);
 	header("Location: 002_ttoner.php");
		
}
else {	
	if ($_SESSION["modifica_ttoner"])
		{			
			$header_content .="
			<form action='002_03ttoner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar Tipo de Toner</legend>
			<label>Nombre:</label><input type='text' NAME='nombre' MAXLENGTH='20' id='campo'>
			<label>Rinde (paginas)</label><input type='text' NAME='rinde' MAXLENGTH='20' id='campo'><br>
			<input type='submit' NAME='00203' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

