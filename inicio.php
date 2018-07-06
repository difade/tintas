<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "<link href='themes/redmond/jquery-ui-1.8.16.custom.css' rel='stylesheet' type='text/css' />
	<link href='scripts/jtable/themes/lightcolor/blue/jtable.css' rel='stylesheet' type='text/css' />
	
	<script src='scripts/jquery-1.6.4.min.js' type='text/javascript'></script>
    <script src='scripts/jquery-ui-1.8.16.custom.min.js' type='text/javascript'></script>
    <script src='scripts/jtable/jquery.jtable.js' type='text/javascript'></script>
";
include ('content.php');
	
$header_content .="<div class='centrado'><img src='".dirbase."imagenes/logo_opaco.png'></div>
";
	echo $header_content;
	include ('footer.php');
?>