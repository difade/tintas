<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00304']) && ($_POST['00304'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		
		$sql = "INSERT INTO impr_ttoner (idimpr,idttoner) VALUES ('".$_POST['id']."','".$_POST['idttoner']."')";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 003_impresora.php");
		
}
else {	
	if ($_SESSION["modifica_impresora"] && $_POST['00304'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from impresora where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$modelo = $row["modelo"];
			$toneres = "<select name='idttoner'>".optionsToners()."</select>";
			$serial = $row["serial"];			
			$header_content .="
			<form action='003_04impresora.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Asociar Tipo de Toner a Impresora ".$modelo ."(".$serial.")</legend>
			<label>Tipos de Toner</label>".$toneres."<br><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00304' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

