<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00501']) && ($_POST['00501'] == "Guardar"))
{	
	$con = conectar();
	$idtoner = $_POST["idtoner"];
		//Update record in database		
		$sql = "UPDATE historial SET 
		fuso = '" . cambiaf_a_mysql($_POST["fuso"]). "', 
		area = '" . $_POST["area"]. "', 
		idimpr = '" . $_POST["idimpr"].  
		"' WHERE id = '" . $_POST["id"] . "' ;";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		$sql = "update toner set estado='I' where id='$idtoner'";
		$result = mysqli_query($con,$sql);
		//Close database connection
		mysqli_close($con);
 header("Location: 005_historial.php");
		
}
else {	
	if ($_SESSION["modifica_historial"] && $_POST['00501'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from historial where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {			
			$idtoner = $row["idtoner"];
			
			$sqli = "select i.id,i.modelo,i.serial,a.nombre as area from impr_toner as it
	inner join impresora as i ON i.id=it.idimpr
	inner join area as a ON a.id=i.idarea
	 where it.idtoner='$idtoner'";
	//historial($sql,"erica");
			$resulti = mysqli_query($con,$sqli);	
			$optionAI = "";	
		if($rowi = mysqli_fetch_array($resulti)) 
		{	
			$idi = $rowi["id"]; $narea = $rowi["area"];
			$impresora = "<input type='hidden' name='idimpr' value='$idi'>".$rowi["modelo"]."(".$rowi["serial"].") ".$narea;
			$optionAI = "<option value='$narea'>".$narea."</option>";
		}
		else $impresora = "<input type='hidden' name='idimpr' value='0'> Sin impresora asociada"; 
		
			
			$area = "<select name='area'>".$optionAI.ListarAreas()."</select>";
			
			$header_content .="
			<form action='005_01historial.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Instalar Toner Nro ".mostrarNroT($idtoner)." - ".mostrarTTipo($idtoner)."</legend>			
			<label>Impresora:</label>".$impresora."<br> <BR>		
			<label>Fecha de Uso:</label><input type='text' NAME='fuso' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" onkeyup=\"mascara(this,'/',patron,true)\"><BR>
			<label>Area</label>".$area."<br>
			
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='idtoner' value='$idtoner'>
			<br><input type='submit' NAME='00501' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} else $header_content .="NO HAY DATOS";}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

