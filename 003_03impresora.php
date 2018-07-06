<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00303']) && ($_POST['00303'] == "Guardar"))
{	
	$con = conectar();		
		//Insert record into database
		/*$entregado = "True";
		if (empty($_POST["entregado"])) $entregado = "False";*/
		$sql = "INSERT INTO impresora(modelo,serial,activo,idarea) VALUES ('" .$_POST["modelo"]."','". $_POST["serial"] . "', '" . $_POST["activo"]."', '" . $_POST["idarea"]."');";
		$result = mysqli_query($con,$sql);
				
	historial($sql,$_SESSION["usuario"]);
	//Close database connection
	mysqli_close($con);
 	header("Location: 003_impresora.php");
		
}
else {	
	if ($_SESSION["modifica_impresora"])
		{
			//<span class='verde'> Ultimo nro nota registrado:".LastNM()." </span><br><br>
			$area = "<select name='idarea'>".optionsArea()."</select>";
			
			$header_content .="
			<form action='003_03impresora.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Agregar Nueva Impresora</legend>	
			<label>Modelo:</label><input type='text' NAME='modelo' MAXLENGTH='50' id='campo'>
			<label>Serial</label><input type='text' NAME='serial' MAXLENGTH='50' id='campo'>
			<label>Area</label>".$area."<br><br>
			<input type='hidden' name='activo' value='1'>
			<br><input type='submit' NAME='00303' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}
}
echo $header_content;

include ('footer.php');
?>

