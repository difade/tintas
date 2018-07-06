<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00403']) && ($_POST['00403'] == "Guardar"))
{	
	$con = conectar();
	$fcompra = $_POST["fcompra"];
	$fbaja = $_POST["fbaja"];
		if (is_null($fcompra) or $fcompra =="")
			$fcompra = "1970-01-01";
		else $fcompra = cambiaf_a_mysql($_POST["fcompra"]);
		
		if (is_null($fbaja) or $fbaja =="")			
			$fbaja = "1970-01-01";
		else $fbaja = cambiaf_a_mysql($_POST["fbaja"]);
		//Insert record into database
		$sql = "INSERT INTO toner(nro,idtipo,fcompra,fbaja,estado,recargado) VALUES ('" .$_POST["nro"] . "', '" .$_POST["idtipo"]."','". $fcompra. "', '" . $fbaja. "', '" . $_POST["estado"]."' ,0);";
		$result = mysqli_query($con,$sql);		
				
	historial($sql,$_SESSION["usuario"]);
	//Close database connection
	mysqli_close($con);
 	header("Location: 004_toner.php");
		
}
else {	
	if ($_SESSION["modifica_toner"])
		{
			$tipo = "<select name='idtipo'>".optionsTipo()."</select>";
			$estado = "<select name='estado'><option value='V'>Vacio</option><option value='I'>Instalado</option></select>";
			$header_content .="
			<form action='004_03toner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar toner</legend>	
			<label>Numero</label><input type='text' NAME='nro' MAXLENGTH='20' id='campo'><br>
			<label>Tipo de Toner</label>".$tipo."<br><br>		
			<label>Fecha de Compra:</label><input type='text' NAME='fcompra' MAXLENGTH='10' id='campo' onkeyup=\"mascara(this,'/',patron,true)\" onBlur=\"esFechaValida(this);\"><br>
			<label>Fecha de baja:</label><input type='text' NAME='fbaja' MAXLENGTH='10' id='campo' onkeyup=\"mascara(this,'/',patron,true)\" onBlur=\"esFechaValida(this);\"><br>
			<label>Estado</label>".$estado."<br><br>
			
			<input type='submit' NAME='00403' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

