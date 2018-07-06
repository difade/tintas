<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00503']) && ($_POST['00503'] == "Guardar"))
{	
	$con = conectar();
	$fenvio = $_POST["fenvio"];
		if (is_null($fenvio) or $fenvio =="")
			$fenvio = "1970-01-01";
		else $fenvio = cambiaf_a_mysql($_POST["fenvio"]);
		$idtoner = $_POST["idtoner"];
		//Insert record into database
		$sql = "INSERT INTO historial(idtoner,notaenvio,fenvio,comercio,estado,obs,idimpr,frecibo,fuso,ffin) VALUES ('" .$idtoner."','".$_POST["notaenvio"]."','". $fenvio . "', '" . $_POST["comercio"]. "', '" . $_POST["estado"] . "', '" . $_POST["obs"]."', 0,'1970-01-01','1970-01-01','1970-01-01');";
		$result = mysqli_query($con,$sql);		
				
	historial($sql,$_SESSION["usuario"]);
	$sql = "update toner set estado='E' where id='$idtoner'";
	$result = mysqli_query($con,$sql);
	if ($_POST["estado"]=="R")
		{
			$sql = "update toner set recargado=recargado+1 where id='$idtoner'";
			$result = mysqli_query($con,$sql);
		}
	//Close database connection
	mysqli_close($con);
 	header("Location: 005_historial.php");
		
}
else {	
	if ($_SESSION["modifica_historial"])
		{			
			$header_content .="
			<form action='005_03historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar pedido de Recarga/Compra Toner</legend>
			<label>Tipo Pedido</label><select name='estado'><option value='R'>Recarga</option><option value='C'>Compra</option><option value='X'>Reclamo</option></select><br>			
			<label>Nro:</label><select name='idtoner'>".optionTonerVC()."</select><br>
			<label>Nota Envio</label><input type='text' NAME='notaenvio' MAXLENGTH='20' id='campo'><br> 		
			<label>Fecha Envio:</label><input type='text' NAME='fenvio' MAXLENGTH='10' id='campo' onkeyup=\"mascara(this,'/',patron,true)\" onBlur=\"esFechaValida(this);\"><br>
			<label>Comercio</label><input type='text' NAME='comercio' MAXLENGTH='20' id='campo'><br>
			<label>Observaciones/<br>Pedidos Dpto Info</label><textarea cols='40' NAME='obs' id='campo'></textarea><br>
			
			
			<input type='submit' NAME='00503' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

