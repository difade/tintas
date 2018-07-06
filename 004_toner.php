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
$result = mysqli_query($con,"SELECT * FROM toner order by nro;");
	
$header_content .="<h1>Toner</h1>";
if ($_SESSION["modifica_toner"])
$header_content .="
<p><span class='boton'><a href='004_03toner.php' class='enlace'><img src='imagenes/add.png'> Agregar toner</a></span></p>";
$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
if ($_SESSION["modifica_toner"])
$header_content .="        
        		<th width='16px'><img src='imagenes/update.png'></th>
        		<th width='16px'><img src='imagenes/delete.png'></th>";
$header_content .="        		
            <th>Numero</th>
            <th>Tipo</th>
            <th>Fecha Compra</th>
            <th>Fecha Baja</th>
            <th>Estado</th>  
            <th>Recargas</th>
            <th>Asociado a:</th>
				<th>Comentarios</th>          
        </tr>
    </thead>
    <tfoot>
            <tr>";
if ($_SESSION["modifica_toner"])
$header_content .="   
         		<th><img src='imagenes/update.png'></th>
        		<th><img src='imagenes/delete.png'></th>";
$header_content .="                        
               <th>Numero</th>
            <th>Tipo</th>
            <th>Fecha Compra</th>
            <th>Fecha Baja</th>
            <th>Estado</th>
            <th>Recargas</th>
            <th>Asociado a:</th>
            <th>Comentarios</th>
            </tr>
        </tfoot>
    <tbody>";
    
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$header_content .="<tr> ";
	if ($_SESSION["modifica_toner"])
	$header_content .="   
				<td><form action='004_01toner.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00401' value='update' class='btn-link'><img src='imagenes/update.png'></button>
</form></td>
				<td><form action='004_02toner.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00402' value='delete' class='btn-link'><img src='imagenes/delete.png'></button>
</form></td>";
	
	$header_content .="          
            <td>".$row['nro']."</td>
            <td>".mostrarTipo($row['idtipo'])."</td>
            <td>".cambiaf_a_normal($row['fcompra'])."</td>
            <td>".cambiaf_a_normal($row['fbaja'])."</td>
            <td>".LEstado($row['estado'])."</td>		
            <td>".$row['recargado']."</td>
            <td>".toner_Imp($row['id'])."</td>
            <td>".$row['comentario']."</td>            						
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