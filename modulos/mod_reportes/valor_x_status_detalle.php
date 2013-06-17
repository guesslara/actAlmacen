<?php
	$status_recibido=$_GET["status"];
	$id_almacen=1;
	$mstatus=array('USO CONSTANTE','LENTO MOVIMIENTO','OBSOLETO');
	
	require("../conf/conectarbase.php");
	$total_existencias=0;
	
	
	//sum(prodxmov.existen*prodxmov.cu) AS total_existencias
	//catprod.id_prod,catprod.descripgral,catprod.especificacion,
	//echo "<br>".
	$sql="SELECT 
		catprod.id,catprod.id_prod,catprod.descripgral,catprod.especificacion,catprod.exist_$id_almacen,prodxmov.existen*prodxmov.cu AS subtotal
	from concepmov,mov_almacen,prodxmov,catprod 
	where 
		mov_almacen.id_mov=prodxmov.nummov 
		AND catprod.id=prodxmov.id_prod
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND concepmov.tipo='Ent' 
			AND mov_almacen.almacen=$id_almacen
		AND catprod.exist_$id_almacen>0
		AND catprod.status1=$status_recibido
				
		AND prodxmov.existen>0 
	order by catprod.id; ";
	if($res=mysql_db_query($sql_db,$sql,$link)){
		//echo "<br> Resultados=".mysql_num_rows($res);
	}else{
		echo mysql_error($link);
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detalle del Valor por estado : <?=$mstatus[$status_recibido]?></title>
<style type="text/css">
.tablaX{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; /*font-size:small;*/ font-family:"Courier New", Courier, monospace;  }
.tablaX th{ border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; text-align:center; background-color:#efefef; }
.tablaX td{ border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; padding:3px; }	
</style>
</head>

<body>
<h3 align="center">Estado : <?=$mstatus[$status_recibido]?></h3>
<h4 align="center">Almac&eacute;n : <?=$id_almacen?></h4>
<table align="center" cellspacing="0" class="tablaX">
<tr>
	<th>id</th>
	<th>clave</th>
	<th>descripci&oacute;n</th>
	<th>especificaci&oacute;n</th>
	<th>existencias</th>
	<th>subtotal $</th>
</tr>
<?php 
	while($reg=mysql_fetch_array($res)){
		//echo "<br>";	print_r($reg);
		$total_existencias+=$reg["subtotal"];
		?>
		<tr>
			<td align="center"><?=$reg["id"]?></td>
			<td><?=$reg["id_prod"]?></td>
			<td><?=$reg["descripgral"]?></td>
			<td><?=$reg["especificacion"]?></td>
			<td align="right"><?=$reg["exist_$id_almacen"]?></td>
			<td align="right"><?=number_format($reg["subtotal"],2,'.',',')?></td>
		</tr>		
		<?php
		//$total_existencias=$reg["total_existencias"];
	}
?>
</table>
<h2 align="center">Total : $ <?=number_format($total_existencias,2,'.',',')?></h2>
</body>
</html>
