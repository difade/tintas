<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00502']) && ($_POST['00502'] == "BORRAR"))
{	
	$con = conectar();
	$idtoner = $_POST["idtoner"];
    $ffin = cambiaf_a_mysql($_POST["ffin"]);
    $comentarios = $_POST["comentarios"];
		$sql = "UPDATE historial SET 
		ffin = '" . $ffin. "', 
		comentarios = '" . $comentarios. 		 
		"' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		$sql = "update toner set estado='B', fbaja ='$ffin', comentario = '$comentarios' where id='$idtoner'";		
		$result = mysqli_query($con,$sql);
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 005_historial.php");
		
}
else {	
	if ($_SESSION["modifica_historial"] && $_POST['00502'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from historial where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$idtoner = $row["idtoner"];			
			$ffin = cambiaf_a_normal($row["ffin"]);
			$comentarios = $row["comentarios"];			
			$header_content .="
			<form action='005_02historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Dar de Baja Toner: ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)."</legend>
			<label>Fecha de Fin:</label><input type='text' NAME='ffin' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" value='".$ffin."' onkeyup=\"mascara(this,'/',patron,true)\"><br>
			<label>Observaciones</label><textarea cols='40' NAME='comentarios' id='campo'>".$comentarios."</textarea><br>
			<input type='hidden' name='id' value='$id'> 
			<input type='hidden' name='idtoner' value='$idtoner'>
			<br><input type='submit' NAME='00502' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

