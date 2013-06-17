<?php
$id_centro_costo=$_GET["id_cc"];
if(empty($id_centro_costo)||(!is_numeric($id_centro_costo))){
	die("<h2 align='center'>Error : Parametro Incorrecto. </h2>");
}

$fecha = date('Y');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Consumo_anual_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");


	// =======================================
	function dame_no_resultados($sql){
		include ("../../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				while($reg=mysql_fetch_array($res)){
					//echo "<br>"; 	print_r($reg);
					return $reg[0];
				}
			}else{ return " "; }
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}

include ("../../conf/conectarbase.php");
$total_consumo=0;
$sql_1="SELECT 
	DISTINCT (cat_cuentas.cuenta), cat_cuentas.descripcion, SUM(prodxmov.cantidad*prodxmov.cu) AS subtotal 
FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
WHERE 
	mov_almacen.id_mov=prodxmov.nummov
	
	AND rel_cc_vs_productos.id_producto=prodxmov.id_prod
	AND cat_cuentas.id_cuenta=rel_cc_vs_productos.id_cc
	
	AND mov_almacen.almacen IN (1,48,77)
	AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
	AND mov_almacen.asociado='$id_centro_costo'
	
	AND mov_almacen.fecha BETWEEN '2011-05-01' AND '2011-05-31'	
	
GROUP BY  cat_cuentas.cuenta	
ORDER BY cat_cuentas.a ASC, cat_cuentas.b ASC, cat_cuentas.c ASC, cat_cuentas.d ASC
";	
if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
	//echo "<br>NDR=".
	$ndr1=mysql_num_rows($res_1);
	if ($ndr1>0){

	}else{ die("<br>Sin resultados"); }
}else{ die("<br>Error SQL : <br>".mysql_error($link)); }								
?>
<style type="text/css">
body{ font-family:Arial, Helvetica, sans-serif; font-size:12pt; }
table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
td,th { font-size:normal; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }		
th{ background-color:#efefef; }
a{ text-decoration:none; color:#0033FF; }

</style>
<h4 align="center">Desglose de Consumo Mayo (<?=date("Y")?>)</h4>
<h5 align="center">
	<?=$id_centro_costo?> 
	&quot; <?=dame_no_resultados("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$id_centro_costo."' LIMIT 1; ")?> &quot; 
</h5>
<table align="center" cellspacing="0" cellpadding="3" width="600">
<tr>
	<th>cuenta</th>
	<th>descripci&oacute;n</th>
	<th>$ subtotal</th>
</tr>
<?php 
while ($reg_1=mysql_fetch_array($res_1)){ 
	$total_consumo+=$reg_1["subtotal"];	
	$datos_grafica_swf.="<set label='".$reg_1["descripcion"]."' value='".round($reg_1["subtotal"],2)."'  />";
	?>
<tr>
	<td align="center"><?=$reg_1["cuenta"]?></td>
	<td><?=$reg_1["descripcion"]?></td>
	<td align="right"><?=number_format($reg_1["subtotal"],2,".",",")?></td>	
</tr>
<?php } ?>
<tr>
	<th align="right" colspan="2">Total $ </th>
	<th align="right"><?=number_format($total_consumo,2,".",",")?></th>
</tr>
</table><br />