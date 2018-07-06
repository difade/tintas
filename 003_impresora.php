<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />	
    
    <script type='text/javascript'>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
";
include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);
//Get records from database
$result = mysqli_query($con,"SELECT * FROM impresora;");
	
$header_content .="<h1>Impresoras</h1>";
if ($_SESSION["modifica_impresora"])
$header_content .="<div id='print'>
<p><span class='boton'><a href='003_03impresora.php' class='enlace'><img src='imagenes/add.png'> Agregar impresora</a></span>
<span class='boton'><a href='003_06impresora.php' class='enlace'><img src='imagenes/add.png'> Listado impresoras imprimible</a></span>
</p></div>";$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
if ($_SESSION["modifica_impresora"])
$header_content .="        
        		<th width='16px'><img src='imagenes/update.png'></th>
        		<th width='16px'><img src='imagenes/delete.png'></th>
        		<th width='16px'><img src='imagenes/tipo.png' title='Asociar tipo de toner'></th>
        		<th width='16px'><img src='imagenes/instalar.png' title='Asociar toner'></th>";
$header_content .="        		
            <th>Modelo</th>                    
            <th>Numero Serial</th>
            <th>Area</th>
            <th>Activa?</th>
            <th>Usa toners:</th>
            <th>Nro toners asociados:</th>                                                
        </tr>
    </thead>
    <tfoot>
         <tr>";
if ($_SESSION["modifica_impresora"])
$header_content .="   
         		<th><img src='imagenes/update.png'></th>
        		<th><img src='imagenes/delete.png'></th>
        		<th width='16px'><img src='imagenes/tipo.png'></th>
        		<th width='16px'><img src='imagenes/instalar.png'></th>";
$header_content .="        		
           <th>Modelo</th>                    
            <th>Numero Serial</th>
            <th>Area</th>
            <th>Activa?</th>
            <th>Usa toners:</th>
            <th>Nro toners asociados:</th>   
         </tr>      
    </tfoot>
  <tbody>";
    
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
/*	$entregado = "<img src='imagenes/bullet.gif'><span class='small'>Pendiente</span>";
	if($row["entregado"]=="True") $entregado = "<img src='imagenes/bullet_checked.gif'><span class='small'>Entregado</span>";*/
	
	/* Obtener los tipo de toner asociados */
	$cttoner = "Select t.nombre from tipotoner as t, impr_ttoner as it
				where it.idimpr='$id' and it.idttoner=t.id";
	$rttoner = mysqli_query($con,$cttoner);
	//historial($cttoner,$_SESSION["usuario"]);
	$ttonerasoc ="";
	while($rowtt = mysqli_fetch_array($rttoner))
	{	$ttonerasoc .= $rowtt['nombre']."<br> ";}
	
	/* Obtener los nro de toner y sus tipos asociados */
	$cttoner = "Select t0.nro,t.nombre 
				from toner as t0, tipotoner as t, impr_toner as it
				where it.idimpr='$id' and it.idtoner=t0.id and t0.idtipo=t.id and t0.estado != 'B'";
	$rttoner = mysqli_query($con,$cttoner);
	//historial($cttoner,$_SESSION["usuario"]);
	
	$tonerasoc ="";
	while($rowtt = mysqli_fetch_array($rttoner))
	{	$tonerasoc .= " - ".$rowtt['nro']." [".$rowtt['nombre']."]";}
	
	$header_content .="<tr>";
if ($_SESSION["modifica_impresora"])
$header_content .="   
				<td><form action='003_01impresora.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00301' value='update' class='btn-link'><img src='imagenes/update.png'></button>
</form></td>
			
				<td><form action='003_02impresora.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00302' value='delete' class='btn-link'><img src='imagenes/delete.png'></button>
</form></td>

				<td><form action='003_04impresora.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00304' value='update' class='btn-link' title='Asociar tipo de toner'><img src='imagenes/tipo.png' ></button>
</form></td>
				<td><form action='003_05impresora.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00305' value='update' class='btn-link' title='Asociar toner'><img src='imagenes/instalar.png'></button>
</form></td>";
$header_content .="
				<td>".$row['modelo']."</td>
            <td>". $row['serial']."</td>
            <td>". mostrarArea($row['idarea'])."</td>
            <td>".$row['activo']."</td>
            <td>".$ttonerasoc."</td>            
				<td>".$tonerasoc."</td>
        </tr>
	";
}    
$header_content .="        
    </tbody>
</table>
";
	echo $header_content;
	include ('footer.php');
?>
