<?php 	
include ('header.php');
$header_content .=utf8_encode("</head><body><center><h1>Sistema Gestion de Tintas y Toners</h1><h2>Formulario de autenticaci&oacute;n</h2>");
if ($_GET["errorusuario"]=="si"){
	$header_content .="<font color='red'><b>Datos incorrectos</b><br>Usuario: ".$_GET["usuario"]."</font>";}
else{$header_content .=""; }
$header_content .=utf8_encode("
<form action='autenticacion.php' method='post' id='formulario'>
<fieldset id='items'> 
 	<legend>.- Introduce tu nombre de usuario y contrase&ntilde;a -.</legend>
	<label>Nombre de usuario:</label><input id='campo' name='usuario' size='25'/>
	<br><label>Contrase&ntilde;a:</label></td><td><input id='campo' name='contrasena' size='25' type='password'/>
	<input id='boton' type='submit' value='Inicio de sesi&oacute;n'/>
</fieldset>
</form>");

// $header_content .="ATENCION!! El navegador recomendado es Mozilla Firefox. El uso de un navegador no recomendado puede provocar que algunos componentes del sistema no se visualicen correctamente.";
echo $header_content;

include ('footer.php');

?>
