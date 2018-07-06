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

$sqltodos = "select tt.nombre as tipo,a.nombre as area,t.nro,t.estado,t.id,t.comentario, i.serial,i.modelo
from toner as t 
inner join impr_toner as it ON it.idtoner=t.id 
inner join impresora as i ON i.id=it.idimpr 
inner join area as a ON a.id=i.idarea 
inner join impr_ttoner as itt ON itt.idimpr=i.id 
inner join tipotoner as tt ON tt.id=t.idtipo 
where t.estado!='B' 
group by nro
order by tipo,area,nro
";
$result = mysqli_query($con,$sqltodos);

$header_content .="<h1>Mapa de Tintas</h1>";
$header_content .=mostrar_noasociados()."
<table id='table_id' class='tabla2' width='85%'>
    <thead>
        <tr>";    
$header_content .="        		
            <th width='100px'>Tipo Toner</th>                    
            <th width='200px'>Area</th>
            <th width='150px'>Vacio</th>
            <th width='150px'>Instalado</th>
				<th width='150px'>Listo para usar</th>            
				<th width='150px'>Enviado</th>
				<th width='150px'>Desconocido</th>
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
$t1 = "<td rowspan='"; $t2 ="'>"; $t3 = "</td>";
$EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";
$estado = ""; $cadena =NULL;
while($row = mysqli_fetch_array($result))
{	
//$cad .= $row["tipo"]."|".$row['area']."|".$row["nro"]."|".$row["estado"]."<br>";
	$id = $row["id"];
	if($tipo ==$row["tipo"]) {		
		if($larea==$row["area"]) {
            if ($serial != $row["serial"]) {
                $lserial .= " <br> ".$row["serial"]." - ".$row["modelo"];
                $serial = $row["serial"];
            }
            $rec =  Recargas($id);
			switch($row["estado"]) {
			case "V":
						$coment = Comentario($id);
						$leyenda = $row["nro"]." [".$rec."] ";
						if($coment!="") 
							$leyenda = "<a href'#' class='Ntooltip'>".$leyenda."<span>".$coment."</span></a>"; 
						$EV.= " ".$leyenda; break;
			case "I": $fecha = LastFUso($id); $EI.= " ".$row["nro"]."<br>[".$fecha."]"." [".$rec."] <br>";  break;
			case "L": $EL.= " ".$row["nro"]." [".$rec."] "; break;
			case "E": $EE.= " ".$row["nro"]; break;
			case "D": $ED.= " ".$row["nro"]." (".$row["comentario"].") <br>"; break;
			}
		}
		else {
			$cadena[]= array($row['tipo'],$larea.$lserial."</span>",$EV,$EI,$EL,$EE,$ED); 
			$EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";				
			$larea = $row["area"]; $serial = $row["serial"]; $lserial = "<span class='small'> <br>".$row["serial"]." - ".$row["modelo"];
            $rec =  Recargas($id);
			switch($row["estado"]) {
				case "V":
						$coment = Comentario($id);
						$leyenda = $row["nro"]." [".$rec."] ";
						if($coment!="") 
							$leyenda = "<a href'#' class='Ntooltip'>".$leyenda."<span>".$coment."</span></a>";  
						$EV.= $leyenda; break;
				case "I": $fecha = LastFUso($id); $EI.= " ".$row["nro"]."<br>[".$fecha."]"." [".$rec."]<br><br> ";  break;
				case "L": $EL.= " ".$row["nro"]." [".$rec."] "; break;
				case "E": $EE.= " ".$row["nro"]; break;
				case "D": $ED.= " ".$row["nro"]." (".$row["comentario"].")<br>"; break;
					
			}
		}
		}
	else 
	{
		if($ltipo!="") {
			$cadena[]= array($ltipo,$larea.$lserial."</span>",$EV,$EI,$EL,$EE,$ED);			
			$cadena[]= array("","","","","","","");
			$EV =""; $EI =""; $EL =""; $EE = ""; $ED ="";
			}
		$ltipo = $row["tipo"];
		$larea = $row["area"]; $serial = $row["serial"]; $lserial = "<span class='small'> <br>".$row["serial"]." - ".$row["modelo"];
        $rec =  Recargas($id);
		switch($row["estado"]) {
			case "V":						
						$coment = Comentario($id);
						$leyenda = $row["nro"]." [".$rec."] ";
						if($coment!="") 
							$leyenda = "<a href'#' class='Ntooltip'>".$leyenda."<span>".$coment."</span></a>";  
					$EV.= $leyenda; break;
			case "I": $fecha = LastFUso($row["id"]); $EI.= " ".$row["nro"]."<br>[".$fecha."]"." [".$rec."]<br><br> ";  break;
			case "L": $EL.= " ".$row["nro"]." [".$rec."] "; break;
			case "E": $EE.= " ".$row["nro"]; break;
			case "D": $ED.= " ".$row["nro"]." (".$row["comentario"].")<br>"; break;
			}
			$tipo = $ltipo;
	}
	
}
$cadena[]= array($ltipo,$larea.$lserial."</span>",$EV,$EI,$EL,$EE,$ED);    
foreach($cadena as $datos)
{
	if($datos[0]=="") 
		$header_content .="<tr class='negro'> ";
	else
		$header_content .="<tr> ";	
	$header_content .="
				<td>".$datos[0]."</td>
            <td>".$datos[1]."</td>
            <td class='rojo'>".$datos[2]."</td>            
				<td class='naranja'>".$datos[3]."</td>
				<td class='verde'>".$datos[4]."</td>
				<td class='azul'>".$datos[5]."</td>
				<td class='azul'>".$datos[6]."</td>						
        </tr>
	";
}
$header_content .="        
    </tbody>
</table>
";
	//$header_content .= $cad;
	echo $header_content;
	include ('footer.php');
?>
