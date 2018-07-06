<?php
//include ('bloquedeseguridad.php');
include_once('definidos.php');
$header_content .= "
</head>
<body>
<a name='up'></a>";
$header_content .="<div id='print'><nav><ul class='menu'>";
if ($_SESSION["lee_area"])
$header_content .="
<li><a href='".dirbase."001_area.php'>Area</a>
</li>";

if ($_SESSION["lee_ttoner"])
$header_content .="	
<li><a href='".dirbase."002_ttoner.php'>Tipo Toner</a>
</li>";

if ($_SESSION["lee_impresora"])
$header_content .="	
<li><a href='003_impresora.php'>Impresoras</a>
</li>";

if ($_SESSION["lee_toner"])
$header_content .="	
<li><a href='004_toner.php'>Toner</a>
</li>";

if ($_SESSION["lee_historial"])
$header_content .="	
<li><a href='005_historial.php'>Historial</a>
</li>";

if ($_SESSION["lee_notas"])
$header_content .="
</li><li><a href='006_mapa.php'>Mapa</a>
";
$header_content .="<li><a href='".dirbase."salir.php'>Salir</a></li></ul></nav></div>";

$header_content .= "<div class='centrado'>
<h1 class='titulo'><img src='imagenes/logouncdti.png' height='20px' width='20px'> Sistema de Gestion de Toners - FADECS</h1></div>



";
?>
