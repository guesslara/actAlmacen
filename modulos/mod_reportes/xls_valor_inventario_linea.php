<?php
$fecha = date('m-d-Y');

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=valor_inventario_linea_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");

$year=2011;
include ("../conf/conectarbase.php");
// definir la bd
if ($year==2010) $mi_bd_actual="iqe_inv_2010";
if ($year==2011) $mi_bd_actual=$sql_db;
if(empty($year)||empty($mi_bd_actual)){
	die("parametros Incorrectos");
}
mysql_select_db($mi_bd_actual);

$id_almacen=1;
$m_almacenes_ids=array(1,44,48);
$m_statusX=array('Uso Constante','Lento Movimiento','Obsoleto');
//echo "<br><hr>";

//echo "<br>".$mi_bd_actual." --> ".
$sql="
SELECT 
	catprod.id AS idp, catprod.id_prod AS claveX, catprod.descripgral, catprod.especificacion, catprod.control_alm, catprod.status1,
	catprod.linea, lineas.descripcion AS linea_descripcion,
	sum(prodxmov.existen*prodxmov.cu) AS total_existencias
FROM concepmov,mov_almacen,prodxmov,catprod,lineas 
WHERE 
	mov_almacen.id_mov=prodxmov.nummov 
	AND catprod.id=prodxmov.id_prod
	AND mov_almacen.tipo_mov=concepmov.id_concep 
	
	AND lineas.linea=catprod.linea
	
	AND concepmov.tipo='Ent' 
		AND mov_almacen.almacen='$id_almacen'
	AND catprod.exist_$id_almacen>0
	AND prodxmov.existen>0
GROUP BY prodxmov.id_prod
ORDER BY catprod.linea ASC, prodxmov.id_prod ASC

;" ;
//LIMIT 10
$total_existencias=0;
$m_statusX=array('Uso Constante','Lento Movimiento','Obsoleto');
if($res=mysql_query($sql,$link)){
	
	?>
	<h3>Almac&eacute;n <?=$id_almacen?></h3>
	<h4>A&ntilde;o : <?=$year?></h4>	
	<table>
	<tr>
		<th>id</th>
		<th>clave</th>
		<th>descripcion</th>
		<th>especificacion</th>
		<th>control_alm</th>
		<th>status</th>
		<th>linea</th>
		<th>valor</th>
	</tr>
	
	<?php
	
	while($reg=mysql_fetch_array($res)){
		//echo "<br>";	print_r($reg);
		$total_existencias+=$reg["total_existencias"];
		
		?>
		<tr>
			<td><?=$reg["idp"]?></td>
			<td><?=$reg["claveX"]?></td>
			<td><?=$reg["descripgral"]?></td>
			<td><?=$reg["especificacion"]?></td>
			<td>&nbsp;<?=$reg["control_alm"]?></td>
			<td><?=$m_statusX[$reg["status1"]]?></td>
			<td>&nbsp;<?=$reg["linea_descripcion"]?></td>
			<td align="right"><?=number_format($reg["total_existencias"],2,'.',',')?></td>
		</tr>
		<?php
		
	}
	
	?>
	</table>
	<?php
			
}else{
	echo "<h3>".mysql_error($link)."</h3>";
}


?>
<h1>Valor Total : $<?=number_format($total_existencias,2,'.',',')?></h1>
