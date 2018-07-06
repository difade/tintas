<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00505']) && ($_POST['00505'] == "Guardar"))
{	
	$con = conectar();
	$idtoner = $_POST["idtoner"];
	$id = $_POST["id"];
		//Update record in database		
		$sql = "UPDATE historial SET 
		frecibo = '" . cambiaf_a_mysql($_POST["frecibo"]). "', 
		obs = '" . $_POST["obs"]. 
		"' WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		$sql = "update toner set estado='L' where id='$idtoner'";
		$result = mysqli_query($con,$sql);
		//Close database connection
		mysqli_close($con);
 	header("Location: 005_historial.php");
		
}
else { 
	if (isset($_POST['00505']) && ($_POST['00505'] == "Seleccionar"))
	{ 
		$id = $_POST["hist"];
		$sql = "select * from historial where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {			
			$idtoner = $row["idtoner"];						
			$comentarios = $row["obs"];
			$id = $row['id'];
			$header_content .="
			<form action='005_05historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Recibir Toner: ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)."</legend>	
			<h4>C/R: ".$row['estado']."<br>
			 Fecha envio: ".cambiaf_a_normal($row['fenvio'])." <br>
			 Nota Envio: ".$row['notaenvio']." <br> Comercio: ".$row['comercio']."</h4> 
			<label>Fecha de Recibido:</label><input type='text' NAME='frecibo' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" onkeyup=\"mascara(this,'/',patron,true)\"><br>
			<label>Observaciones</label><textarea cols='40' NAME='obs' id='campo'>".$comentarios."</textarea><br>
			
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='idtoner' value='$idtoner'>
			<br><input type='submit' NAME='00505' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} }
	else
		if ($_SESSION["modifica_historial"])
		{ 
		$sql = "select h.* from historial as h inner join toner as t0 on t0.id=h.idtoner
		where t0.estado='E' and frecibo='1970-01-01'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		$sel_historial ="<select name='hist'>";
		while($row = mysqli_fetch_array($result)) {			
			$idtoner = $row["idtoner"];						
			$comentarios = $row["comentarios"];
			$id = $row['id'];
			$sel_historial .= "<option value='$id'>Toner: ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)." C/R: ".$row['estado']." Fecha envio: ".cambiaf_a_normal($row['fenvio'])." <br></option>";		
			}
		$sel_historial .= "</select>";
		$header_content .="
			<form action='005_05historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Recibir Toner: </legend>	
			<label>Fecha de Recibido:</label>".$sel_historial."<br>
			
			<input type='hidden' name='id' value='$id'>			
			<br><input type='submit' NAME='00505' VALUE='Seleccionar' id='boton'>
			</fieldset>
			</form> ";
		} 
		else {$header_content .="NO HAY TONERES ENVIADOS A COMERCIO";}
}
echo $header_content;

include ('footer.php');
?>

