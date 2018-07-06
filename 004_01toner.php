<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<script type='text/javascript' src='scripts.js'></script>";
include ('content.php');

$header_content .= "";
if ( isset($_POST['00401']) && ($_POST['00401'] == "Guardar"))
{	
	$con = conectar();
		//Update record in database	
        if(isset($_POST["idtipo"]))
        {
            $idttoner = $_POST["idtipo"];
            $tipo = "idtipo = '$idttoner',";
        }
		$sql = "UPDATE toner SET 
		fcompra = '" . cambiaf_a_mysql($_POST["fcompra"]). "',
		fbaja = '" . cambiaf_a_mysql($_POST["fbaja"]). "', 
		recargado = '" . $_POST["recargado"]. "',
		comentario = '" . $_POST["comentario"]. "', ".$tipo."
		estado = '" . $_POST["estado"]. "' 
		WHERE id = " . $_POST["id"] . ";";
		$result = mysqli_query($con,$sql);
				
		historial($sql,$_SESSION["usuario"]);
		//Close database connection
		mysqli_close($con);
 header("Location: 004_toner.php");
		
}
else {	
	if ($_SESSION["modifica_toner"] && $_POST['00401'] == "update")
	{
		$id = $_POST["id"];
		$sql = "select * from toner where id='$id'";
		$con = conectar();
		$result = mysqli_query($con,$sql);
		if($row = mysqli_fetch_array($result)) {
			$tipo = mostrarTipo($row["idtipo"]);
			$nro = $row["nro"];
			$estado = $row['estado'];
			$recargado = $row["recargado"];
			$comentario = $row["comentario"];
			$fcompra = cambiaf_a_normal($row["fcompra"]);
			$fbaja = cambiaf_a_normal($row["fbaja"]);
			$estado = "<select name='estado'><option value='$estado'>".LEstado($estado)."</option><option value='L'>Listo para usar</option><option value='I'>Instalado</option><option value='V'>Vacio</option><option value='E'>Enviado a Recarga</option><option value='B'>Dado de baja</option><option value='D'>Desconocido</option></select>";

            $tag_tipo = "<label>Tipo toner</label>".$tipo."<br><br>";
            $sql_toner_asoc_impr = "select idtoner from impr_toner where idtoner='$id'";
            $result_tai = mysqli_query($con,$sql_toner_asoc_impr);
            $sql_tipo ="select id,idimpr from historial where idtoner='$id'";
            $result_tipo = mysqli_query($con,$sql_tipo);
            $cantidadr = mysqli_num_rows($result_tipo);
            if (!mysqli_fetch_array($result_tai))
            {
            if ($cantidadr<1)
                $tag_tipo = "<label>Tipo de Toner</label><select name='idtipo'>".optionTipo($row["idtipo"]).optionsTipo()."</select><br><br>";
            if ($cantidadr=1)
            {
                $rtipo = mysqli_fetch_array($result_tipo);
                if ($rtipo["idimpr"]==0)
                    $tag_tipo = "<label>Tipo de Toner</label><select name='idtipo'>".optionTipo($row["idtipo"]).optionsTipo()."</select><br><br>";
            }}
			
			$header_content .="
			<form action='004_01toner.php' id='formulario' method='post'> 
			<fieldset id='items'>
			<legend>Modificar Registro de toner</legend>
			<label>Numero</label>".$nro."<br><br>".
			$tag_tipo
			."<label>Fecha Compra:</label><input type='text' NAME='fcompra' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" onkeyup=\"mascara(this,'/',patron,true)\" value='$fcompra'><br>
			<label>Fecha Baja:</label><input type='text' NAME='fbaja' MAXLENGTH='10' id='campo' onBlur=\"esFechaValida(this);\" onkeyup=\"mascara(this,'/',patron,true)\" value='$fbaja'>
			<label>Estado</label>".$estado."<br>
			<label>Recargas</label><input type='text' NAME='recargado' MAXLENGTH='50' id='campo' value='$recargado'><br>
			<label>Comentarios</label><textarea cols='40' NAME='comentario' id='comentario'>".$comentario."</textarea><br><br>
			
			<input type='hidden' name='id' value='$id'>
			<br><input type='submit' NAME='00401' VALUE='Guardar' id='boton'>
			</fieldset>
			</form> 
		";} else $header_content .="NO HAY DATOS<br>ID=".$id;}
//		$header_content .="Modificar";
}
echo $header_content;

include ('footer.php');
?>

