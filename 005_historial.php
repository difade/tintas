<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
	<script type='text/javascript' language='javascript' src='datatables/moment.min.js'></script>
	<script type='text/javascript' language='javascript' src='datatables/datetime-moment.js'></script>
	
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />
    
    <script type='text/javascript'>
$(document).ready( function () {
	
	 $.fn.dataTable.moment( 'DD/MM/YYYY' );
    $('#table_id').DataTable();
} );
</script>
";
include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);
//Get records from database
$result = mysqli_query($con,"SELECT * FROM historial;");
	
$header_content .="<h1>Historial</h1>";
if ($_SESSION["modifica_historial"])
$header_content .="
<p><span class='boton'><a href='005_03historial.php' class='enlace'><img src='imagenes/add.png'> Pedir compra/recarga</a></span> | <span class='boton'>
<a href='005_05historial.php' class='enlace'><img src='imagenes/recibir.png'> Recibir pedido</a></span></p>";
$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
if ($_SESSION["modifica_historial"])
$header_content .="
        		<th width='16px'><img src='imagenes/instalar.png'></th>
        		<th width='16px'><img src='imagenes/printer_delete.png'></th>
				<th width='16px'><img src='imagenes/trash.png'></th>
				<th width='16px'><img src='imagenes/update.png'></th>
        		";
$header_content .="
				<th>C/R</th>        		
            <th>Nro</th>   
            <th>Tipo</th>                 
            <th>Nota Pedido</th>
            <th>Fecha Envio</th>
            <th>Fecha Recibo</th>
            <th>Comercio</th>
            <th>Datos Pedido</th>
            <th>Fecha Uso</th>
            <th>Area</th>
            <th>Impresora</th>
            <th>Fecha Fin</th>
            <th>Observaciones</th>
            <th>PIT</th>
            <th>PI</th>                                    
        </tr>
    </thead>
    <tfoot>
         <tr>";
if ($_SESSION["modifica_historial"])
$header_content .="
         		<th><img src='imagenes/instalar.png'></th>
         		<th><img src='imagenes/printer_delete.png'></th>
			    <th><img src='imagenes/trash.png'></th>
				<th width='16px'><img src='imagenes/update.png'></th>
        		";
$header_content .="                                 
         	<th>C/R</th>        		
            <th>Nro</th>   
            <th>Tipo</th>                 
            <th>Nota Pedido</th>
            <th>Fecha Envio</th>
            <th>Fecha Recibo</th>
            <th>Comercio</th>
            <th>Datos Pedido</th>
            <th>Fecha Uso</th>
            <th>Area</th>
            <th>Impresora</th>
            <th>Fecha Fin</th>
            <th>Observaciones</th>
            <th>PIT</th>
            <th>PI</th>       
         </tr>      
    </tfoot>
  <tbody>";
    
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$header_content .="<tr> ";
	if ($_SESSION["modifica_historial"])
	$header_content .="   
				<td><form action='005_01historial.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00501' value='update' class='btn-link' title='Instalar en impresora'><img src='imagenes/instalar.png'></button>
</form></td>
				<td><form action='005_04historial.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00504' value='update' class='btn-link' title='Desinstalar en impresora'><img src='imagenes/printer_delete.png'></button>
</form></td>
				<td><form action='005_02historial.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00502' value='delete' class='btn-link' title='Dar de baja el toner'><img src='imagenes/trash.png'></button>
</form></td>
	<td><form action='005_06historial.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00506' value='actualizar' class='btn-link' title='Modificar'><img src='imagenes/update.png'></button>
</form></td>";
	$fenvio = cambiaf_a_normal($row['fenvio']);
	$frecibo = cambiaf_a_normal($row['frecibo']);
	$fuso = cambiaf_a_normal($row['fuso']);
	$ffin = cambiaf_a_normal($row['ffin']);
	$rojofe ="<span>"; $rojofr ="<span>"; $rojofu ="<span>"; $rojoff ="<span>";$rojo="</span>";
	if ($fenvio == "01/01/1970") { $rojofe ="<span style='color:red'>"; }
	if ($frecibo == "01/01/1970") { $rojofr ="<span style='color:red'>"; }
	if ($fuso == "01/01/1970") { $rojofu ="<span style='color:red'>"; }
	if ($ffin == "01/01/1970") { $rojoff ="<span style='color:red'>"; }
		
	$header_content .="
				<td>".$row['estado']."</td>        
				<td>#".mostrarNroT($row['idtoner'])."</td>
				<td>".mostrarTTipo($row['idtoner'])."</td>
				<td>".$row['notaenvio']."</td>            
            <td>".$rojofe.$fenvio.$rojo."</td>
            <td>".$rojofr.$frecibo.$rojo."</td>
            <td>".$row['comercio']."</td>
            <td>".$row['obs']."</td>
            <td>".$rojofu.$fuso.$rojo."</td>
            <td>".$row['area']."</td>
            <td>".mostrarImpre($row['idimpr'])."</td>
            <td>".$rojoff.$ffin.$rojo."</td>
            <td>".$row['comentarios']."</td>				
				<td>".$row['pit']."</td>
				<td>".$row['cpaginas']."</td>				
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
