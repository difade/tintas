<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00305']) && ($_POST['00305'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database		
		
		$sql = "INSERT INTO impr_toner (idimpr,idtoner) VALUES ('".$_POST['id']."','".$_POST['idtoner']."')";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 003_impresora.php");
		
}
else {	
	if ($_SESSION["modifica_impresora"] && $_POST['00305'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from impresora where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$modelo = $row["modelo"];
			$serial = $row["serial"];
			
			$optionstoners ="<select name='idtoner'>";
			$sqlttoners = "select idttoner from impr_ttoner where idimpr='$id'";
			historial($sqlttoners,$_SESSION["usuario"]);
			$resulttt = mysqli_query($con,$sqlttoners);
			while($rowttoner = mysqli_fetch_array($resulttt)) {
					$tipotoner = $rowttoner["idttoner"];
					$sqltoners = "select * from toner where idtipo='$tipotoner' and id not in (select idtoner from impr_toner)";
					historial($sqltoners,$_SESSION["usuario"]);
					$resultt = mysqli_query($con,$sqltoners);
					while($rowtoner = mysqli_fetch_array($resultt)) {
						$rtid = $rowtoner['id'];
					$optionstoners .= "<option value='$rtid'>".$rowtoner["nro"]." / ".mostrarTTipo($rtid)."</option>";
				}}
			$optionstoners .= "</select>";
			
			$header_content .="
			<form action='003_05impresora.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Asociar Numero de Toner a impresora: ".$modelo." (".$serial.")</legend>
			<label>Nro Toner</label>".$optionstoners."<br><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00305' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";}}
//		$header_content .="Modificar";
}

echo $header_content;

include ('footer.php');
?>

