<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00602']) && ($_POST['00602'] == "BORRAR"))
{	
	$con = conectar();
		$sql = "DELETE FROM otrasn WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 006_notas.php");
		
}
else {	
	if ($_SESSION["modifica_notas"] && $_POST['00602'] == "delete")
	{
		$id = $_POST["id"];
		$sql = "select * from otrasn where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {			
			$fecha = cambiaf_a_normal($row["fecha"]);
			$nro = $row["nro"];			
			$firma = $row["firma"];			
			$descripcion = $row["descripcion"];			
			$autoriza = $row["autoriza"];
			$observaciones = $row["observaciones"];
			$header_content .="
			<form action='006_02notas.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Eliminar Compras</legend>
			Nro: ".$nro."<br>
			Fecha:".$fecha."<br>			
			Firma".$firma."<br>
			Descripcion:".$descripcion."<br>
			Autoriza:".$autoriza."<br>
			Observaciones:".$observaciones."<br>	 
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00602' VALUE='BORRAR' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

