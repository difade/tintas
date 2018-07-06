<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00506']) && ($_POST['00506'] == "ACTUALIZAR"))
{	
	$con = conectar();
	$idtoner = $_POST["idtoner"];
    $ffin = cambiaf_a_mysql($_POST["ffin"]);
    $fuso = cambiaf_a_mysql($_POST["fuso"]);
    $pit = $_POST["pit"];
    $pi = $_POST["pi"];
		$sql = "UPDATE historial SET 
		ffin = '" . $ffin. "', 
		fuso = '" . $fuso. "', 
		pit = '" . $pit. "', 
		cpaginas = '" . $pi. 		 
		"' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 005_historial.php");
		
}
else {	
	if ($_SESSION["modifica_historial"] && $_POST['00506'] == "actualizar")
	{
		$id = $_POST["id"];
		$sql = "select * from historial where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$idtoner = $row["idtoner"];			
			$ffin = cambiaf_a_normal($row["ffin"]);
            $fuso = cambiaf_a_normal($row["fuso"]);
			$pit = $row["pit"];
			$pi = $row["cpaginas"];
			$header_content .="
			<form action='005_06historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar: ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)."</legend>
			<label>Fecha de Uso:</label><input type='text' NAME='fuso' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" value='".$fuso."' onkeyup=\"mascara(this,'/',patron,true)\"><br>
			<label>Fecha de Fin:</label><input type='text' NAME='ffin' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" value='".$ffin."' onkeyup=\"mascara(this,'/',patron,true)\"><br>
			<label>PIT</label><input type='text' NAME='pit' MAXLENGTH='20' id='campo' value='$pit'><br>
			<label>PI</label><input type='text' NAME='pi' MAXLENGTH='20' id='campo' value='$pi'><br>

			<input type='hidden' name='id' value='$id'> 
			<input type='hidden' name='idtoner' value='$idtoner'>
			<br><input type='submit' NAME='00506' VALUE='ACTUALIZAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

