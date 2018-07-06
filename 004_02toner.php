<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00402']) && ($_POST['00402'] == "BORRAR"))
{	
	$con = conectar();
	$fbaja = cambiaf_a_mysql($_POST["fbaja"]);
		$sql = "UPDATE toner SET estado='B' , fbaja = '$fbaja' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 004_toner.php");
		
}
else {	
	if ($_SESSION["modifica_toner"] && $_POST['00402'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from toner where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$nro = $row["nro"];
			$tipo = mostrarTipo($row["idtipo"]);
			
			$header_content .="
			<form action='004_02toner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Dar de Baja toner</legend>			
			Numero: ".$nro."<br>
			Tipo: ".$tipo."<br><br>
			<label>Fecha de baja:</label><input type='text' NAME='fbaja' MAXLENGTH='10' id='campo' onkeyup=\"mascara(this,'/',patron,true)\" onBlur=\"esFechaValida(this);\"><br>	 
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00402' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

