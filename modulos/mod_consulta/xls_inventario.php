<?php
$fecha = date('Y-m-d H_i_s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=IQe_Inventario_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");


//print_r($_GET);



$ac=$_GET["ac"];
	if($ac!=='exportar_catalogo_excel') die();
$linea=$_GET["linea"];
$campo=$_GET["campo"];
$operador=$_GET["operador"];
$criterio=$_GET["criterio"];
$orden=$_GET["orden"];
$asc_desc=$_GET["asc_desc"];
$lista_campos=$_GET["lista_campos"];
$lista_camposX=explode(',',$lista_campos);
//echo "<br>"; 	print_r($lista_camposX); //  LIMIT 10 

($operador=='LIKE')?$campo_operador_criterio=" $campo $operador '%$criterio%' ":$campo_operador_criterio=" $campo $operador '$criterio' ";
$status1=array('Uso Constante','Lento Movimiento','Obsoleto');
$m_activo=array('NO','SI');

//echo "<br><br>".
$sql="SELECT ".$lista_campos." FROM catprod WHERE activo='1' AND linea LIKE '%$linea%'  AND $campo_operador_criterio ORDER BY `$orden` $ascdes; ";
include ("../conf/conectarbase.php");
if ($res=mysql_db_query($sql_db,$sql,$link)){ 
	$ndr=mysql_num_rows($res);
	if($ndr>0){	
		?>
		<table>
		<tr>
			<?php
			foreach($lista_camposX as $campoX){
				$campoX=str_replace('`','',$campoX);
				$campoX=str_replace('exist_','existencias_',$campoX);
				echo "<th>$campoX</th>";
			}
			?>	
		</tr>
		<?php
		while($reg=mysql_fetch_array($res)){
			//echo "<br>"; 	print_r($reg);
			echo "<tr>";
			foreach($lista_camposX as $campoX){
				$campoX=trim($campoX);
				$campoX=str_replace('`','',$campoX);
				$primeras_letras=substr($campoX,0,6);
				if($campoX=='status1'){
					echo "<td>".$status1[$reg[$campoX]]."</td>";
				}elseif($campoX=='activo'){
					echo "<td align='center'>".$m_activo[$reg[$campoX]]."</td>";
				}elseif($primeras_letras=='exist_'){
					echo "<td align='right'>".$reg[$campoX]."</td>";
				}else{
					echo "<td>&nbsp;".$reg[$campoX]."</td>";
				}
			}
			echo "</tr>";			
		}
		?>
		</table>
		<?php		
	}else{ die ("<h3 align='center'> Sin resultados </h3>"); }
} else{ die ("<h3 align='center'> Error SQL (".mysql_error($link)."). </h3>");	}	
?>