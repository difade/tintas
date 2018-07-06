<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00504']) && ($_POST['00504'] == "Guardar"))
{	
	$con = conectar();
	$idtoner = $_POST["idtoner"];
		//Update record in database		
		$sql = "UPDATE historial SET 
		ffin = '" . cambiaf_a_mysql($_POST["ffin"]). "', 
		comentarios = '" . $_POST["comentarios"]. "',
		cpaginas = '" . floatval($_POST["pi"]). "', 
		pit = '" . floatval($_POST["pit"]).  
		"' WHERE id = '" . $_POST["id"] . "' ;";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		$sql = "update toner set estado='V' where id='$idtoner'";
		$result = mysqli_query($con,$sql);
		//Close database connection
		mysqli_close($con);
 header("Location: 005_historial.php");
		
}
else {	
	if ($_SESSION["modifica_historial"] && $_POST['00504'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from historial where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {			
			$idtoner = $row["idtoner"];						
			
			$header_content .="
			<form action='005_04historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Desinstalar Toner Nro ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)."</legend>	
			<label>Fecha de Fin:</label><input type='text' NAME='ffin' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" onkeyup=\"mascara(this,'/',patron,true)\"><br>
			<label>Observaciones</label><textarea cols='40' NAME='comentarios' id='campo'></textarea><br><br>
			<label>PIT</label><input type='text' NAME='pit' MAXLENGTH='20' id='campo'><br>
			<label>PI</label><input type='text' NAME='pi' MAXLENGTH='20' id='campo'><br>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='idtoner' value='$idtoner'>
			<br><input type='submit' NAME='00504' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} else $header_content .="NO HAY DATOS";}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

