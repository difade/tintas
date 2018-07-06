<?php
error_reporting(E_ALL);

define ('host',"localhost");
define ('usuario',"informatica");
define('password',"fadec0");
define ('db',"resoluciones");

/*********************************BD************************/
function conectar()
{	
$link = mysql_connect(host,usuario,password)
or die ("no se ha podido conectar");

mysql_select_db(db)
or die("Error al tratar de selecccionar la base de Docentes: ".mysql_error());
//mysql_query ("SET NAMES ' latin1'");
return $link;
}

function cerrar($link)
{mysql_close($link);}

function liberar($result)
{	if($result!=NULL){mysql_free_result($result);}}


/*********************** FUNCIONES DE BD ***********************/
function consulta_docentes($link)
{ 
 return mysql_query("SELECT * FROM docentes order by apellido,nombre",$link);
}

function consulta_docente($link,$id)
{ 
 return mysql_query("SELECT * FROM docentes where id = '$id'",$link);
}

function consulta_tdocente($link,$legajo)
{ 
 $doc =  mysql_query("SELECT * FROM t_docente where Legajo = '$legajo'",$link);
if ($rdoc = mysql_fetch_array($doc))
	return urldecode($rdoc['Apynom']);
else
	return "";
}

function consulta_docente_name_dni($id)
{ 
 $link = conectar();
 $rdoc = mysql_query("SELECT * FROM docentes where id = '$id'",$link);
 $pers ="";
 if ($rowd = mysql_fetch_array($rdoc)) 
	{ $pers .= urldecode($rowd["apellido"]).", ".urldecode($rowd["nombre"])." | ".$rowd["legajo"]. " | ".urldecode($rowd["dni"]); }
 return $pers;
}

function consulta_designaciones($link,$idd)
{
 return mysql_query("SELECT * FROM designaciones where idp = '$idd' order by fecha",$link);
}

function consulta_dedicaciones($link)
{ 
 return mysql_query("SELECT * FROM dedicaciones order by prioridad, dedicacion",$link);
}

function consulta_dedicacion($link,$id)
{ 
// devuelve una cadena de caracteres que es la dedicacion
 $dedicacion =  mysql_query("SELECT dedicacion FROM dedicaciones where id='$id'",$link);
$eded="";
	if ($rded = mysql_fetch_array($dedicacion))
		{ $eded = urldecode($rded["dedicacion"]);}
	else { $eded="SIN DEDICACION DEFINIDO";}
	return $eded;
}

function consulta_cargos($link)
{ 
 return mysql_query("SELECT * FROM cargos order by prioridad,cargo",$link);
}

function consulta_cargo($id)
{  // devuelve una cadena de caracteres que es el cargo
	$link = conectar();
	$cargo = mysql_query("SELECT cargo FROM cargos WHERE id='$id'",$link);
	$ecargo="";
	if ($rcargo = mysql_fetch_array($cargo))
		{ $ecargo = urldecode($rcargo["cargo"]);}
	else { $ecargo="SIN CARGO DEFINIDO";}
	return $ecargo;
}

function consulta_notificaciones()
{ 
 $link = conectar();
 return mysql_query("SELECT * FROM notificacion order by opcion",$link);
}

function consulta_nofiticacion($id)
{ 
 $link = conectar();
 $cargo = mysql_query("SELECT opcion FROM notificacion WHERE id='$id'",$link);
 $ecargo="";
 if ($rcargo = mysql_fetch_array($cargo))
	{ $ecargo = urldecode($rcargo["opcion"]);}
return $ecargo;
}


function mostrar_lista($nolist,$result,$name)
{
	$content = "";
	while($row = mysql_fetch_array($result)) 
	{ if ($row["id"]!=$nolist)
		{$content .="<option value='".$row["id"]."'>".urldecode($row["$name"])."</option>"; }
	}
	return $content;
}

function mostrar_listas($result,$name)
{
	$content = "";
	while($row = mysql_fetch_array($result)) 
	{ $content .="<option value='".$row["id"]."'>".urldecode($row["$name"])."</option>"; }
	return $content;
}

function consulta_carreras ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM carreras order by nombre",$link);
}

function consulta_carrera ($idc)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM carreras where id='$idc' order by nombre",$link);

	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["nombre"]);}
	return $ncrr;
}

function consulta_tcarreras ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM t_carrera order by descrip",$link);
}

function consulta_tcarrera($cc)
{
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM t_carrera where cod_car='$cc'",$link);

	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["descrip"]);}
	return $ncrr;	
}

function consulta_dpto ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM dpto order by nombre",$link);
}

function consulta_dpto_r ($id)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM dpto where id='$id'",$link);
}

function consulta_dpto_rel ($c)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM dpto where idcrr='$c' order by nombre",$link);
}

function consulta_asig_rel7b ($c)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM t_asignat where cod_car='$c' order by descrip",$link);
}

function consulta_dpto_name ($iddpto)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM dpto where id='$iddpto'",$link) or die(mysql_error());
	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["nombre"]);}
	return $ncrr;
}

function consulta_area ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM areas order by nombre",$link);
}

function consulta_area_r ($id)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM areas where id='$id'",$link);
}

function consulta_area_name ($a)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM areas where id='$a'",$link);
	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["nombre"]);}
	return $ncrr;
}

function consulta_area_rel ($d)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM areas where iddpto='$d' order by nombre",$link);
}

function crr_dpto_area($id)
{
	$link = conectar();
	$consulta = "SELECT areas.nombre as area,dpto.nombre as dpto,carreras.nombre as crr FROM areas INNER JOIN dpto ON dpto.id=areas.iddpto
	INNER JOIN carreras ON dpto.idcrr=carreras.id
	 WHERE  $id=areas.id";
	$result = mysql_query($consulta,$link);
	$resultado = null;
	while($row = mysql_fetch_array($result)) {
		$resultado = array(urldecode($row["area"]),urldecode($row["dpto"]),urldecode($row["crr"]));
	}
	return $resultado;
}

function consulta_orientacion ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM orientacion order by nombre",$link);
}
function consulta_orientacion_r ($id)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM orientacion where id ='$id'",$link);
}

function consulta_orientacion_rel ($id)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM orientacion where idarea='$id' order by nombre",$link);
}

function consulta_orientacion_name ($id)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM orientacion where id='$id'",$link);
	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["nombre"]);}
	return $ncrr;
}

function consulta_asignaturas ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM asignaturas order by nombre",$link);
}

function consulta_asignatura ($id)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM asignaturas where id='$id'",$link);
}

function consulta_asignaturas_name ($id)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM asignaturas where id='$id'",$link);
	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["nombre"]." ".$rcrr["obs"]);}
	return $ncrr;
}

function consulta_tasignaturas_name ($id,$crr)
{ 
	$link = conectar();
	$ncrr = "";
	$result = mysql_query("SELECT * FROM t_asignat where cod_asi='$id' and cod_car='$crr'",$link);
	if ($rcrr = mysql_fetch_array($result))
	{ $ncrr = urldecode($rcrr["descrip"]);}
	return $ncrr;
}

function consulta_asignaturas_rel ($id)
{ 
	$link = conectar();	
	return mysql_query("SELECT * FROM asignaturas where idorientacion='$id' and activa=1 order by nombre",$link);	
}

function consulta_catedras ()
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM catedras order by anio",$link);
}

function consulta_catedras_anio ($a)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM catedras WHERE anio='$a' ORDER BY ida",$link);
}

function consulta_catedras_idd($id)
{
	$link = conectar();
	return mysql_query("SELECT * FROM catedras where idd='$id' order by anio",$link);
}

function consulta_periodos ($anio)
{ 
	$link = conectar();
	return mysql_query("SELECT * FROM b_periodocursado where year(finicio)='$anio'",$link);
}
/********BEGIN************ 29/08/2012****************/
function consulta_resolucion($cc)
{
	$link = conectar ();
	$result = mysql_query("SELECT * FROM pdfs where id='$cc'",$link);
	$resolucion = "";
	if ($row = mysql_fetch_array($result))
		{ $resolucion = $row["nro"]."/".$row["anio"];}
	return $resolucion;
}

function consulta_pdf($cc)
{
	$link = conectar ();
	return mysql_query("SELECT * FROM resord where id='$cc'",$link);
}

function consulta_pdfs()
{
	$link = conectar ();
	return mysql_query("SELECT * FROM resord order by nro,anio,fecha",$link);
}

function mostrar_pdf($nro_resolucion)
{
	$link = conectar ();
	$pdf = "";
	$result =  mysql_query("SELECT * FROM resord where id = '$nro_resolucion'",$link);
	if ($row = mysql_fetch_array($result))
		{ if ($row["nombre"]!="") {$pdf = "<a class='enlace' href='".$row["url"].$row["nombre"]."'>".$row["nro"]."/".$row["anio"]."</a>";}
		else $pdf = $row["nro"]."/".urldecode($row["anio"]);}
	return $pdf;
}

function mostrar_fecha($nro_resolucion)
{
	$link = conectar ();
	$fecha = "";
	$result =  mysql_query("SELECT * FROM resord where id = '$nro_resolucion'",$link);
	if ($row = mysql_fetch_array($result))
		{ $fecha = cambiaf_a_normal($row["fecha"]);}
	return $fecha;
}
function consulta_detalle($cc)
{
	$link = conectar ();
	$result = mysql_query("SELECT * FROM resord where id='$cc'",$link);
	$detalle = "";
	if ($row = mysql_fetch_array($result))
		{ $detalle = urldecode($row["detalle"]);}
	return $detalle;
}

/************END********29/08/2012*************************/
/******* BEGIN 31/08/12**********************************/
function consulta_concursos()
{
 $link = conectar ();
 return mysql_query("SELECT * FROM concursos order by idasig",$link);
}

function consulta_concurso($id)
{
 $link = conectar ();
 return mysql_query("SELECT * FROM concursos where id='$id'",$link);
}
/******** END 31/08/12************************************/
function consulta_jurado($idconc)
{
$link = conectar ();
 return mysql_query("SELECT * FROM jurado where idconc='$idconc' order by ocupa",$link);
}
/************************ FUNCIONES DE BD FIN *****************/
function dia_semana($d)
{
$dia ="";
switch ($d){
case 0: $dia ="LUNES"; break;
case 1: $dia ="MARTES"; break;
case 2: $dia ="MIERCOLES"; break;
case 3: $dia ="JUEVES"; break;
case 4: $dia ="VIERNES"; break;
case 5: $dia ="SABADO"; break;
case 6: $dia ="DOMINGO"; break;
}
return $dia;
}

function historial ($datos)
{
$narchivo = "logs/".date('ymd')."_docentes.log";

$fpw=fopen($narchivo,"a+");

$datos = date('d/m/Y H:i:s')." ".$datos."\n";

fwrite($fpw, $datos);
fclose($fpw);
}

function nombre_pdf($url)
{
$pos_c = strpos($url,"#");
return substr($url,0,$pos_c);
}

function url_pdf($url)
{
$pos_c = strpos($url,"#");
$url_archivo = substr($url,$pos_c);
return str_ireplace("#","",$url_archivo);
}
// Aplicar comillas sobre la variable para hacerla segura
function comillas_inteligentes($valor,$link)
{
    // Retirar las barras
    if (get_magic_quotes_gpc()) {
        $valor = stripslashes($valor);        
    }

    // Colocar comillas si no es entero
    if (!is_numeric($valor)) {
        $valor = "'" . mysql_real_escape_string($valor,$link) . "'";
    }
    return $valor;
}

function sustraer_anexo($cadena,$cadena_comienzo)
{
$maximo = strlen($cadena);
$total = strpos($cadena,$cadena_comienzo)+strlen($cadena_comienzo);
$final = substr ($cadena,$total,-4);
return $final;
}

/*function cambiar_fecha($fecha)
{
$fecha = str_ireplace("/","-",$fecha);
$dd = substr($fecha,0,2);
$mm = substr($fecha,3,2);
$yy = substr($fecha,6,2);
return $yy."-".$mm."-".$dd;
}*/
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

function estilos_filas($cant)
{
	if (!($cant%2)) 
   		{$fila="fila_par";
   		$f="#D7E5F2";} 
   	else 
   		{$fila="fila_impar";
   		 $f="#fff";}
   	$content = "id=\"".$fila."\" onMouseOver=\"this.style.backgroundColor='#FFE4C4'\"; onMouseOut=\"this.style.backgroundColor='".$f."'\";";
	return $content;
}

function paginacion($total,$pp,$st,$url) {
/* 
$total. N£mero total de resultados que ha devuelto la busqueda. La forma de obtener este valor se ha explicado en el paso 1).
$pp. N£mero de resultados que queremos mostrar por en cada p gina.
$st. N£mero del primer resultado de la p gina actual. $st vale 0 en la primera p gina, en la siguientes valdr  10, 20, 30,
$url. La direcci¢n completa de las p ginas de resultados pero sin el valor de $st. Es decir, si la direcci¢n de una p gina de resultados es http://tudominio.com/mostrar.php?st=30, el valor de $url debe ser http://tudominio.com/mostrar.php?st=
*/
 
if($total>$pp) 
{
	$resto=$total%$pp;
	if($resto==0) 

		{ $pages=$total/$pp; } 
	else 
		{ $pages=(($total-$resto)/$pp)+1; }
 
	if($pages>10) 
		{
		$current_page=($st/$pp)+1;
		if($st==0) 
		{
			$first_page=0;
			$last_page=10;
		} 
		else 
			if($current_page>=5 && $current_page<=($pages-5)) 
				{
				$first_page=$current_page-5;
				$last_page=$current_page+5;
				}
			else
				if($current_page<5)
					{
					$first_page=0;
					$last_page=$current_page+5+(5-$current_page);
					}
				else
					{
					$first_page=$current_page-5-(($current_page+5)-$pages);
					$last_page=$pages;
					}
		}
	else
	{
	$first_page=0;
	$last_page=$pages;
	}

$estilo_numero ="border: 1px solid rgb(156, 203, 248); color: black; display: inline-block; left: -1px;text-decoration: none;font-size:1em; ";
$estilo_numero_activo ="border: 1px solid rgb(156, 203, 248);background: url(imagenes/active-page.gif) repeat-x; border-color: green; color: white;font-weight:bold;font-size:1.1em; ";

$page_nav = "";
for($i=$first_page;$i< $last_page;$i++)
{
	$pge=$i+1;
	$nextst=$i*$pp;
	if($st==$nextst)
		{ $page_nav .= '<span style=\''.$estilo_numero_activo.'\'>'.$pge.'</span> '; }
	else { $page_nav .= '<a style=\''.$estilo_numero.'\' href="'.$url.$nextst.'">'.$pge.'</a> '; }
}

if($st==0) { $current_page = 1; } else { $current_page = ($st/$pp)+1; }

$page_last=""; $page_next = "";
if($current_page< $pages)
{
	$page_last = '<a href="'.$url.($pages-1)*$pp.'"><img src=\'imagenes/next_top.gif\'></a> ';
	$page_next = '<a href="'.$url.$current_page*$pp.'"><img src=\'imagenes/next.png\'></a> ';
}

$page_first =""; $page_previous ="";
if($st>0)
{
	$page_first = '<a href="'.$url.'0"><img src=\'imagenes/previous_top.gif\'></a> ';
	$page_previous = '<a href="'.$url.''.($current_page-2)*$pp.'"><img src=\'imagenes/previous.png\'></a> ';
}
$paginas="Paginas(s) ";
}
else
{ $page_last=""; $page_next = "";
	$page_first =""; $page_previous ="";$page_nav = "";$paginas="";}

return "<p id='print'>$paginas $page_first $page_previous $page_nav $page_next $page_last</p>";
}

function replacestring($string)
{
$bad_chars ="\\";
$keywords = str_replace($bad_chars, '&#x5c;', $string);

$bad_chars ="\"";
$keywords = str_replace($bad_chars, '&quot;', $keywords);

$bad_chars ="\'";
$keywords = str_replace($bad_chars, ' ', $keywords);

return $keywords;
}

?>
