<?php 
include ('bloquedeseguridad.php');
include ('header.php');

$header_content .= "	
	<script src='datatables/jquery-1.12.3.js'></script>        
	<script type='text/javascript' language='javascript' src='datatables/jquery.dataTables.min.js'></script>
<link rel='stylesheet' type='text/css' href='datatables/jquery.dataTables.min.css' />	
    <script src='datatables/dataTables.rowsGroup.js'></script>
    <script type='text/javascript'>
$(document).ready( function () {
    $('#table_id').DataTable({
    'paging':false,
    'ordering':false,
    'searching':false,
    'info':false
    });
} );
</script>
	";

include ('content.php');

//Open database connection
$con = mysqli_connect(host,usuario,password);
mysqli_select_db($con,db);

$sqltodos = "select tt.nombre as tipo,a.nombre as area,t.nro,t.estado from toner as t inner join impr_toner as it ON it.idtoner=t.id inner join impresora as i ON i.id=it.idimpr inner join area as a ON a.id=i.idarea inner join impr_ttoner as itt ON itt.idimpr=i.id inner join tipotoner as tt ON tt.id=t.idtipo where t.estado!='B' order by tipo,area,nro";
$result = mysqli_query($con,$sqltodos);

$header_content .="<h1>Mapa de Tintas</h1>";
$header_content .="
<table id='table_id' class='tabla2'>
    <thead>
        <tr>";
/*$header_content .="        		
            <th>Tipo Toner</th>                    
            <th>Area</th>
            <th>Vacio</th>
            <th>Instalado</th>
				<th>Listo para usar</th>            
				<th>Enviado</th>
				<th>Desconocido</th>
        </tr>
    
   ";
         */        
$header_content .="        		
            <th>Tipo Toner</th>                    
            <th>Area</th>
            <th>Vacio</th>
            <th>Instalado</th>
				<th>Listo para usar</th>            
				<th>Enviado</th>
				<th>Desconocido</th>
        </tr>
    </thead>
    <tfoot>
         <tr>";
$header_content .="         
         	<th>Tipo Toner</th>                    
            <th>Area</th>
            <th>Vacio</th>
            <th>Instalado</th>
				<th>Listo para usar</th>            
				<th>Enviado</th>
				<th>Desconocido</th>
         </tr>      
    </tfoot>
  <tbody>";

$tipo="";
$ltipo ="";   
$cont = 1;
$t1 = "<td rowspan='"; $t2 ="'>"; $t3 = "</td>";
$EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";
$estado = ""; $cadena ="";
while($row = mysqli_fetch_array($result))
{	
//$cadena .= $row["tipo"]."|".$row['area']."|".$row["nro"]."|".$row["estado"]."<br>";
	if($tipo ==$row["tipo"]) {		
		if($larea==$row["area"]) {
			switch($row["estado"]) {
			case "V": $EV.= "- ".$row["nro"]; break;
			case "I": $EI.= "- ".$row["nro"]; break;
			case "L": $EL.= "- ".$row["nro"]; break;
			case "E": $EE.= "- ".$row["nro"]; break;
			case "D": $ED.= "- ".$row["nro"]; break;
			}
		}
		else {
			$cont++;
			$tcol .="<td>".$larea."</td><td>".$EV."</td><td>".$EI."</td><td>".$EL."</td><td>".$EE."</td><td>".$ED."</td></tr>";
			 $EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";
				$tcol.="<tr>";
				$larea = $row["area"];
				switch($row["estado"]) {
				case "V": $EV.= "- ".$row["nro"]; break;
				case "I": $EI.= "- ".$row["nro"]; break;
				case "L": $EL.= "- ".$row["nro"]; break;
				case "E": $EE.= "- ".$row["nro"]; break;
				case "D": $ED.= "- ".$row["nro"]; break;
					
			}
		}
		}
	else 
	{
		if($ltipo!="") {
			
			$tcol .= "<td>".$larea."</td><td>".$EV."</td><td>".$EI."</td><td>".$EL."</td><td>".$EE."</td><td>".$ED."</td></tr>";		
			$header_content .= "<tr>".$t1.$cont.$t2.$ltipo.$t3.$tcol;
			$tcol = "";
		//	$ltipo = "";
		$EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";
			}
		$ltipo = $row["tipo"];		
		$cont=1;
		$larea = $row["area"];
		switch($row["estado"]) {
			case "V": $EV.= "- ".$row["nro"]; break;
			case "I": $EI.= "- ".$row["nro"]; break;
			case "L": $EL.= "- ".$row["nro"]; break;
			case "E": $EE.= "- ".$row["nro"]; break;
			case "D": $ED.= "- ".$row["nro"]; break;
			}
			$tipo = $ltipo;
	}
	/*$header_content .="<tr> ";	
	$header_content .="
				<td>".$row['tipo']."</td>
            <td>".$row['area']."</td>
            <td>".$row['nro']."</td>            
				<td>".$row['estado']."</td>					
        </tr>
	";*/
}    
$header_content .="        
    </tbody>
</table>
";
	//$header_content .= $cadena;
	echo $header_content;
	include ('footer.php');
?>