<?php
#define ('dirbase',"/SGT/");
define ('dirbase',"/");
define ('e1'," style='color: #08088A' ");
define ('e2'," style='color: #610B38' ");
define ('host',"localhost");
define ('usuario',"informatica");
define('password',"fadec0");
define ('db',"fadetoner");

////////////////////////////////////////////////////
//Convierte fecha de mysql a normal 
//////////////////////////////////////////////////// 
function cambiaf_a_normal($fecha){ 
   	
   	$lafecha ="--";
   	if (preg_match( "#([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})#", $fecha, $mifecha))   	
   		{$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; }
   	return $lafecha; 
} 

//////////////////////////////////////////////////// 
//Convierte fecha de normal a mysql 
//////////////////////////////////////////////////// 
function cambiaf_a_mysql($fecha)
{ 
   /*$fecha= preg_replace("/\//","-",$fecha);
  $lafecha = date("Y-m-d",strtotime($fecha));*/
//  list ($dia, $mes, $anyo) = split ('/', $fecha);
  list ($dia, $mes, $anyo) = explode ('/', $fecha);
// Lo juntamos a nuestro antojo (en este caso a ISO):
$salida = "$anyo-$mes-$dia";
  return $salida; 
}

function conectar() {
	//Open database connection
	$con = mysqli_connect(host,usuario,password);
	mysqli_select_db($con,db);
	return $con;
}

function mostrarNroT($id) {
	$con = conectar();	
	$sql = "select t.nro from toner as t	
	 where t.id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["nro"];
	}
	else return "--"; 
}

function Recargas($id) {
	$con = conectar();	
	$sql = "select t.recargado from toner as t	
	 where t.id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["recargado"];
	}
	else return ""; 
}

function Comentario($id) {
	$con = conectar();	
	$sql = "select t.comentario from toner as t	
	 where t.id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["comentario"];
	}
	else return ""; 
}

function mostrarTTipo($id) {
	$con = conectar();	
	$sql = "select tt.nombre from toner as t
	inner join tipotoner as tt ON tt.id=t.idtipo
	 where t.id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["nombre"];
	}
	else return "--"; 
}

function optionTonerVC() {
	$con = conectar();	
	$sql = "select t.id,t.nro,tt.nombre,t.recargado from toner as t
	 join tipotoner as tt ON tt.id=t.idtipo
	 where t.estado='V'
    order by nro";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	$listado = "<option value='0'>Elija toner</option>";
	while($row = mysqli_fetch_array($result)) 
	{
		$id = $row["id"];
		$listado .= "<option value='$id'>".$row["nro"]."/".$row["nombre"]."(".$row["recargado"].")"."</option>";
	}
	return $listado;
}

function optionsToners() {
	$con = conectar();	
	$sql = "select * from tipotoner";
	$result = mysqli_query($con,$sql);
	$options = "<option value='0'>Sin Definir</option>";		
	while($row = mysqli_fetch_array($result)) 
	{
		$id = $row["id"];
		$options .= "<option value='$id'>".$row["nombre"]."</option>";
	}
	return $options; 
}

function LastFUso ($id) {
	$sql = "select max(fuso) as fecha from historial where idtoner='$id'";
	$con = conectar();	
	$resp = "";
	$result = mysqli_query($con,$sql);
	if($row = mysqli_fetch_array($result))
	{ 
	$resp = cambiaf_a_normal($row["fecha"]) ;
	//$resp = $row["fecha"] ;
	$resp = substr($resp, 0, 6).substr($resp, -2, 2);
	} 	
	return $resp;
}		

function toner_Imp($id) {
	$sql = "select a.nombre, i.serial
	from toner as t 
	inner join impr_toner as it ON it.idtoner=t.id
	inner join impresora as i ON i.id=it.idimpr
	inner join area as a ON a.id=i.idarea
	where t.id='$id'";
	$con = conectar();	
	$resp = "";
	$result = mysqli_query($con,$sql);
	if($row = mysqli_fetch_array($result))
	{ 
    $resp = $row["nombre"]."-".$row["serial"] ;
	} 
	
	return $resp;
	}

function mostrar_noasociados()
{
    $sql="select t.nro,tt.nombre as tipo,t.recargado,t.estado
    from toner as t
    inner join tipotoner as tt ON tt.id=t.idtipo
    where t.id not in (select idtoner from impr_toner)";
    $con = conectar();	
    $resp = ""; $aux = "";
	if($result = mysqli_query($con,$sql))
        {
        $resp .= "<div class='centrado noasoc'><h3>Toners no asociados a ninguna impresora</h3>";
        $aux = "<tr><td><i>Tipo</i></td><td><i>Nro</i></td><td><i>Recargas</i></td><td><i>Estado</i></td></tr>";
        }
	$resp .= "<table>".$aux ;
	while($row = mysqli_fetch_array($result))
	{ 
    $estado = $row["estado"];
    if ($estado=="E") $estado = "Pendiente de compra";
    if ($estado=="L") $estado = "Comprado";
    $resp .= "<tr><td>".$row["tipo"]."</td><td>".$row["nro"]."</td><td align='center'>".$row["recargado"]."</td><td>".$estado."</td></tr>";
	} 
	$resp .= "</table></div>";
	return $resp;	
}

function mostrarImpre($id) {
	$con = conectar();	
	$sql = "select modelo,serial from impresora where id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["modelo"]."(".$row["serial"].")";
	}
	else return "--"; 
}

function mostrarArea($id) {
	$con = conectar();	
	$sql = "select nombre from area where id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["nombre"];
	}
	else return "Elija un area"; 
}

function optionArea($id) {
	$con = conectar();	
	$sql = "select * from area where id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return "<option value='$id'>".$row["nombre"]."</option>";
	}
	else return "<option value='0'>Sin Definir</option>"; 
}

function optionsArea() {
	$con = conectar();	
	$sql = "select * from area order by nombre";
	$result = mysqli_query($con,$sql);
	$options = "<option value='0'>Sin Definir</option>";		
	while($row = mysqli_fetch_array($result)) 
	{
		$id = $row["id"];
		$options .= "<option value='$id'>".$row["nombre"]."</option>";
	}
	return $options; 
}

function ListarAreas() {
	$con = conectar();	
	$sql = "select * from area order by nombre";
	$result = mysqli_query($con,$sql);
	$options = "<option value='0'>Sin Definir</option>";		
	while($row = mysqli_fetch_array($result)) 
	{		
		$nombre = $row["nombre"];
		$options .= "<option value='$nombre'>".$nombre."</option>";
	}
	return $options; 
}

function LEstado($id) {
$tipo = "";
switch($id) {
	case "V": $tipo = "Vacio"; break;
	case "I": $tipo = "Instalado"; break;
	case "E": $tipo = "Enviado"; break;
	case "B": $tipo = "Baja"; break;
	case "D": $tipo = "Desconocido"; break;
	case "L": $tipo = "Listo para usar"; break;
	}
	return $tipo;
}

function mostrarTipo($id) {
	$con = conectar();	
	$sql = "select nombre from tipotoner where id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return $row["nombre"];
	}
	else return "Elija un tipo"; 
}

function optionTipo($id) {
	$con = conectar();	
	$sql = "select * from tipotoner where id='$id'";
	//historial($sql,"erica");
	$result = mysqli_query($con,$sql);		
	if($row = mysqli_fetch_array($result)) 
	{		
		return "<option value='$id'>".$row["nombre"]."</option>";
	}
	else return "<option value='0'>Sin Definir</option>"; 
}

function optionsTipo() {
	$con = conectar();	
	$sql = "select * from tipotoner";
	$result = mysqli_query($con,$sql);
	$options = "<option value='0'>Sin Definir</option>";		
	while($row = mysqli_fetch_array($result)) 
	{
		$id = $row["id"];
		$options .= "<option value='$id'>".$row["nombre"]."</option>";
	}
	return $options; 
}

function historial($sql,$usuario) {
$narchivo = "logs/".date('ymd')."_admin.log";

$fpw=fopen($narchivo,"a+");

$datos = date('d/m/Y H:i:s')." ".$sql." Usuario:".$usuario."\n";

fwrite($fpw, $datos);
fclose($fpw);
return;
}

?>
