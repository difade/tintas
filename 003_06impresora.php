<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />	
    
    <script type='text/javascript'>
$(document).ready( function () {
    $('#table_id').DataTable({'paging':   false});
} );
</script>
";
include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);
//Get records from database
$result = mysqli_query($con,"SELECT * FROM impresora where activo=1;");
	
$header_content .="<h1>Listado de Impresoras/Toners</h1>";
$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
$header_content .="        		
        <th>Area</th>
        <th>Modelo</th>                    
        <th>Serial</th>                    
        <th>Usa toners:</th>
        <th>Toners asociados: nro [tipo] (cantidad recargas)</th>
        </tr>
    </thead>
    <tfoot>
         <tr>";

$header_content .="        		
        <th>Area</th>
        <th>Modelo</th>                    
        <th>Serial</th> 
        <th>Usa toners:</th>
        <th>Toners asociados: nro [tipo] (cantidad recargas)</th>
        </tr>
    </thead>
    <tfoot>  <tbody>";
    
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
	$cttoner = "Select t0.nro,t.nombre,t0.recargado 
				from toner as t0, tipotoner as t, impr_toner as it
				where it.idimpr='$id' and it.idtoner=t0.id and t0.idtipo=t.id and t0.estado != 'B'";
	$rttoner = mysqli_query($con,$cttoner);
	//historial($cttoner,$_SESSION["usuario"]);
	
	$tonerasoc ="";
	while($rowtt = mysqli_fetch_array($rttoner))
	{	$tonerasoc .= " - ".$rowtt['nro']." [".$rowtt['nombre']."] (".$rowtt['recargado'].")";}
	
	$header_content .="<tr>";
$header_content .="
                <td>". mostrarArea($row['idarea'])."</td>
				<td>".$row['modelo']."</td>
                <td>". $row['serial']."</td>
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
