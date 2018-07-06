<?php 
include ('bloquedeseguridad.php');
include ('header.php');
$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />	
    
    <script type='text/javascript'>
$(document).ready( function () {
    $('#table_id').DataTable(
     {
        \"language\": {
            \"decimal\": \",\",
            \"thousands\": \".\"
        }
    } 
     );
} );
</script>
";
include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);
//Get records from database
$result = mysqli_query($con,"SELECT * FROM area order by nombre;");
	
$header_content .="<h1>Areas</h1>";
if ($_SESSION["modifica_area"])
$header_content .="
<p><span class='boton'><a href='001_03area.php' class='enlace'><img src='imagenes/add.png'> Agregar Area</a></span</p>";
$header_content .="
<table id='table_id' class='display'>
    <thead>
        <tr>";
if ($_SESSION["modifica_area"])
$header_content .="        
        		<th width='16px'><img src='imagenes/update.png'></th>
        		<th width='16px'><img src='imagenes/delete.png'></th>";
$header_content .="        	
            <th>Nombre </th>                              
        </tr>
    </thead>
    <tfoot>
            <tr>";
if ($_SESSION["modifica_area"])
$header_content .="   
         		<th><img src='imagenes/update.png'></th>
        		<th><img src='imagenes/delete.png'></th>";
$header_content .="            
               <th>Nombre </th>            
            </tr>
        </tfoot>
    <tbody>";
    
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$header_content .="<tr>";
	if ($_SESSION["modifica_area"])
	$header_content .="   
				<td><form action='001_01area.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00101' value='update' class='btn-link'><img src='imagenes/update.png'></button>
</form></td>
				<td><form action='001_02area.php' method='post'>
				<input type='hidden' name='id' value='$id'>
  <button type='submit' name='00102' value='delete' class='btn-link'><img src='imagenes/delete.png'></button>
</form></td>";
	$header_content .="	
            <td>".$row['nombre']."</td>           
        </tr>
	";
}    
$header_content .="        
    </tbody>
</table>
";
	echo $header_content;
	include ('footer.php');
//iconv("UTF-8//TRANSLIT//IGNORE", "ISO-8859-15//TRANSLIT//IGNORE",$string)	
?>
