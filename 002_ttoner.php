<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />	
    
    <script type='text/javascript' class='init'>
$(document).ready( function () {
    $('#table_id').DataTable(
    
	);
} );
</script>
";
include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);
//Get records from database
$result = mysqli_query($con,"SELECT * FROM tipotoner;");
	
$header_content .="<h1>Tipos de Toner</h1>";
if ($_SESSION["modifica_ttoner"])
$header_content .="
<p><span class='boton'><a href='002_03ttoner.php' class='enlace'><img src='imagenes/add.png'> Agregar Tipo de Toner</a></span></p>";
$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
if ($_SESSION["modifica_ttoner"])
$header_content .="        
        		<th width='16px'><img src='imagenes/update.png'></th>
        		<th width='16px'><img src='imagenes/delete.png'></th>";
$header_content .="        		
        		<th>Nombre</th>
            <th>Rinde (paginas)</th>      
        </tr>
    </thead>
    <tfoot>
         <tr>";
if ($_SESSION["modifica_ttoner"])
$header_content .="   
         		<th><img src='imagenes/update.png'></th>
        		<th><img src='imagenes/delete.png'></th>";
$header_content .="            
         	<th>Nombre</th>
            <th>Rinde (paginas)</th>    
         </tr>      
    </tfoot>
  <tbody>";
    
while($row = mysqli_fetch_array($result))
{	
	$id = $row['id'];
	if ($_SESSION["modifica_ttoner"])
	$header_content .="   
				<td><form action='002_01ttoner.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00201' value='update' class='btn-link'><img src='imagenes/update.png'></button>
</form></td>
				<td><form action='002_02ttoner.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00202' value='delete' class='btn-link'><img src='imagenes/delete.png'></button>
</form></td>";	
	$header_content .="
				<td>".$row['nombre']."</td>				            
				<td>".$row['rinde']."</td>           	
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