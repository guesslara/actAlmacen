<?php
	$a=$_GET["action"];
	if ($a=="exportar"){
		$i=$_GET["idp"];	
		include ("../conf/conectarbase.php");
		$fecha = date('Y-m-d H:i:s');
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=Ficha_producto ($fecha).xls");
		header("Pragma: no-cache");
		header("Expires: 0");		
		
		
		$lista_campos=" `id`,`id_prod`, `descripgral`, `especificacion`, `control_alm`, `marca`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `unidad`, `stock_min`, `linea`, `marca`, `observa`, `status1` ";	
		$sql_1="SELECT $lista_campos FROM catprod WHERE id= '$i'";
		if (!$result_1=mysql_db_query($sql_db,$sql_1)){ echo "Error SQL (1)."; exit; }
		$ndr_1=mysql_num_rows($result_1);
		$c="#FFFFFF";
		if ($ndr_1>0){
			while ($fila_1=mysql_fetch_array($result_1)){
				//echo "<br>";	print_r($fila_1);
				$id=$fila_1["id_producto"];		$cl=$fila_1["id_prod"];		$de=$fila_1["descripgral"];		$es=$fila_1["especificacion"];
				$ca=$fila_1["control_alm"];		$cp=$fila_1["cpromedio"];	$un=$fila_1["unidad"];			$ue=$fila_1["uni_entrada"];
				$us=$fila_1["uni_salida"];		$sm=$fila_1["stock_min"];	$sx=$fila_1["stock_max"];		$st=$fila_1["status1"];
				
				$li=$fila_1["linea"];			$ma=$fila_1["marca"];		$ob=$fila_1["observa"];			$ub=$fila_1["ubicacion"];		
			}
		} else {	echo "<div align=center>No se encontraron resultados del producto seleccionado.</div>";	}
		
		//echo "<br>".
		$sql_2="SELECT * FROM tipoalmacen WHERE activo=1 ORDER BY id_almacen ";
		if (!$result_2=mysql_db_query($sql_db,$sql_2)){ echo "Error SQL (2)."; exit; }
		$ndr_2=mysql_num_rows($result_2);
		$c="#FFFFFF";
		
		if (!$ndr_2>0){	echo "<div align=center>No se encontraron resultados en la consulta a los almacenes.</div>";	}		
		
		// KARDEX
		//echo "<hr><br>".
		$sql_kardex="SELECT mov_almacen.id_mov, concepmov.id_concep, concepmov.concepto,concepmov.tipo,concepmov.asociado as asociado0,mov_almacen.asociado,mov_almacen.almacen, mov_almacen.fecha, prodxmov.id as id_item, prodxmov.cantidad, prodxmov.existen, prodxmov.cu, tipoalmacen.almacen as nombre_almacen
		FROM mov_almacen, prodxmov, concepmov, tipoalmacen
		WHERE prodxmov.id_prod=$i AND mov_almacen.id_mov=prodxmov.nummov AND mov_almacen.tipo_mov=concepmov.id_concep AND mov_almacen.almacen=tipoalmacen.id_almacen    
		ORDER BY mov_almacen.fecha ASC,prodxmov.id ASC
		";
		$result_kardex=mysql_db_query($sql_db,$sql_kardex);
		//echo "<br>NDR3=".
		$ndrr_kardex=mysql_num_rows($result_kardex);

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha del Producto <?=$i?></title>
</head>

<body>
<div id="all">
<style type="text/css">
	.campos{ text-align:center; font-weight:bold;  }
	.td1a{ border-left:#CCC 1px solid; border-right:#CCC 1px solid; }
	.td1i{ border-left:#CCC 1px solid; }
	.a_ss{ text-decoration:none; }
	
	table{ border:#333 1px solid; }
	.campo_n{ font-weight:bold; background-color:#efefef; }
	.campo_nc{ font-weight:bold; text-align:center; border-bottom:#333 1px solid; background-color:#333; color:#FFF;  }
	.total{ text-align:right; font-weight:bold; border-top:#333 1px solid; }	
</style>
<h3 align=center>Datos generales del producto.</h3>
<table width="800" cellspacing="0" align="center">
  <tr>
    <td width="197" class="campo_n">Id Producto</td>
    <td width="597">&nbsp;<?=$i?></td>
  </tr>
  <tr>
    <td class="campo_n">Clave del Producto &nbsp;&nbsp;</td>
    <td>&nbsp;<?=$cl?></td>
  </tr>
  <tr>
    <td class="campo_n">Descripci&oacute;n</td>
    <td>&nbsp;<?=$de?></td>
  </tr>
  <tr>
    <td class="campo_n">Descripci&oacute;n en ingl&eacute;s </td>
    <td>&nbsp;<?=$ob?></td>
  </tr>
  <tr>
    <td class="campo_n">Especificaci&oacute;n</td>
    <td>&nbsp;<?=$es?></td>
  </tr>
  <tr>
    <td class="campo_n">Control de Almac&eacute;n </td>
    <td>&nbsp;<?=$ca?></td>
  </tr>
  <tr>
    <td class="campo_n">L&iacute;nea</td>
    <td>&nbsp;<?=$li?></td>
  </tr>
  <tr>
    <td class="campo_n">Marca</td>
    <td>&nbsp;<?=$ma?></td>
  </tr>
  <tr>
    <td class="campo_n">Ubicaci&oacute;n</td>
    <td>&nbsp;<?=$ub?></td>
  </tr>
  <tr>
    <td class="campo_n">Unidad</td>
    <td>&nbsp;<?=$un?></td>
  </tr>
  <tr>
    <td class="campo_n">Unidad de Entrada </td>
    <td>&nbsp;<?=$ue?></td>
  </tr>
  <tr>
    <td class="campo_n">Unidad de Salida </td>
    <td>&nbsp;<?=$us?></td>
  </tr>
  <tr>
    <td class="campo_n">Stock M&iacute;nimo </td>
    <td>&nbsp;<?=$sm?></td>
  </tr>
  <tr>
    <td class="campo_n">Stock M&aacute;ximo </td>
    <td>&nbsp;<?=$sx?></td>
  </tr>
  <tr>
    <td class="campo_n">Status</td>
    <td>&nbsp;<?php
		if ($st==2){			echo "Obsoleto";	
		} else if($st==1) {		echo "Lento Movimiento";
		} else {				echo "Uso Constante";	} 	
	?></td>
  </tr>
  
  <tr>
    <td class="campo_n">Observaciones</td>
    <td>&nbsp;<?=$ob?></td>
  </tr>
  </table>
<p>&nbsp;</p>
<h3 align=center>Existencias del Producto.</h3>
<table width="800" cellspacing="0" align="center">
  <tr>
    <td width="86" class="campo_nc">Id Almac&eacute;n</td>
    <td width="505" class="campo_nc">Almac&eacute;n</td>
    <td width="112" class="campo_nc">Existencias</td>
    <td width="87" class="campo_nc">Transferencias</td>
  </tr>
  
  
  <? 
  $tdeX=0;
  $c="#FFFFFF";
  while ($fila_2=mysql_fetch_array($result_2)){ 
		$existenciasX=0;
		$nombre_campo_almacen="a_".$fila_2["id_almacen"]."_".$fila_2["almacen"];
		//echo "<br>".
		$sql_3="SELECT $nombre_campo_almacen, exist_".$fila_2["id_almacen"]." as existenciaX, trans_".$fila_2["id_almacen"]." as transferenciaX FROM catprod WHERE id=$i AND a_".$fila_2["id_almacen"]."_".$fila_2["almacen"]."=1";
		if (!$result_3=mysql_db_query($sql_db,$sql_3)){ echo "Error SQL (3)."; exit; }
		$fila_3=mysql_fetch_array($result_3);
		if ($fila_3[$nombre_campo_almacen]==1){
		$existenciasX=$fila_3["existenciaX"];
		$transferenciaX=$fila_3["transferenciaX"];
		
  ?>
  <tr bgcolor="<?=$c?>">
    <td align="center">&nbsp;<?=$fila_2["id_almacen"]?></td>
    <td class="td1a">&nbsp;<?=$fila_2["almacen"]?></td>
    <td align="right"><?php echo $existenciasX; $tdeX+=$existenciasX; ?></td>
    <td class="td1i" align="right"><?php echo $transferenciaX; $tdtX+=$transferenciaX; ?></td>
  </tr>
  <? ($c=="#FFFFFF")? $c="#EFEFEF" : $c="#FFFFFF"; } } ?>
  <tr>
    <td colspan="2" class="total">Total</td>
    <td align="right" class="total"><?=$tdeX?></td>
    <td align="right" class="total"><?=$tdtX?></td>
  </tr>
  </table>
<p>&nbsp;</p>
<h3 align=center>Movimientos del producto (kardex).</h3>
<?php 
	if ($ndrr_kardex<=0)
	{
		?>
<div style="font-size:15px; font-weight:bold; text-align:center; margin-top:5px; color:#000000; text-decoration:blink;">El producto <?=$id?> no presenta Movimientos.</div>
		<?php
		exit();
	}
?>
<table width="1019" cellspacing="0" align="center">
  <tr>
    <td width="21" class="campo_nc">#</td>
    <td width="95" class="campo_nc">Fecha</td>
    <td width="64" class="campo_nc">Id Mov.</td>
    <td width="160" class="campo_nc">Concepto</td>
    <td width="102" class="campo_nc">Almac&eacute;n</td>
    <td width="283" class="campo_nc">Asociado</td>
    <td width="50" class="campo_nc">Tipo</td>
    <td width="21" class="campo_nc">+/-</td>
    <td width="59" class="campo_nc">Cantidad</td>
    <td width="59" class="campo_nc">C.U.($)</td>
    <td width="59" class="campo_nc">Subtotal($)</td>
  </tr>
  <? 
  $c="#FFFFFF";
  while ($fila_kardex=mysql_fetch_array($result_kardex)){ 
		//echo "<br>"; print_r($fila_kardex); 
		$concepto_tipo=$result_kardex["tipo"];
		$series_gen=$result_kardex["seriesGen"];
		
		// CLIENTE ...
		if ($fila_kardex["asociado0"]=="Cliente")
		{
			$sql_cliente="SELECT r_social FROM cat_clientes WHERE id_cliente=".$fila_kardex["asociado"];
			$result_cliente=mysql_db_query($sql_db,$sql_cliente);
			$row_cliente=mysql_fetch_array($result_cliente);
			$xasociado=$row_cliente["r_social"];	
		}
		// ALMACENES
		if ($fila_kardex["asociado0"]=="Almacen")
		{
			$sql_almacen_asociado="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`=".$fila_kardex["asociado"];
			$result_almacen_asociado=mysql_db_query($sql_db,$sql_almacen_asociado);	
			while($row_almacen_asociado=mysql_fetch_array($result_almacen_asociado)){	
				$xasociado=$row_almacen_asociado["almacen"];
			}
		}
		
		// Origen ...
		if ($fila_kardex["asociado0"]=="Origen")
		{
			$sql_origen="SELECT descripcion FROM cat_origenes WHERE id=".$fila_kardex["asociado"];
			$result_origen=mysql_db_query($sql_db,$sql_origen);
			$row_origen=mysql_fetch_array($result_origen);
			$xasociado=$row_origen["descripcion"];	
		}		
		?>  
  <tr bgcolor="<?=$c?>">
    <td>&nbsp;<?=$fila_kardex["id_item"]?></td>
    <td class="td1a">&nbsp;<?=$fila_kardex["fecha"]?></td>
    <td><?=$fila_kardex["id_mov"]?></td>
    <td class="td1a">&nbsp;<?=$fila_kardex["id_concep"]." ".$fila_kardex["concepto"]?></td>
    <td><?=$fila_kardex["almacen"]." ".$fila_kardex["nombre_almacen"]?></td>
    <td class="td1a">&nbsp;<?=$fila_kardex["asociado0"]." ".$fila_kardex["asociado"]." ".$xasociado?></td>
    <td>&nbsp;<?=$t=$fila_kardex["tipo"]?></td>
    <td class="td1a" align="center">&nbsp;<?php
    	$caracter="";
		if ($t=="Ent"){ $tckX+=$fila_kardex["cantidad"]; $caracter="+"; }
		if ($t=="Sal"){ $tckX-=$fila_kardex["cantidad"]; $caracter="-"; }
		echo $caracter;	
	?></td>
    <td align="right"><?=$fila_kardex["cantidad"]?></td>
    <td class="td1a" align="right"><?=number_format($fila_kardex["cu"],2,'.',',')?></td>
    <td align="right"><?=number_format($fila_kardex["cantidad"]*$fila_kardex["cu"],2,'.',',')?></td>
  </tr>
  <?php ($c=="#FFFFFF")? $c="#EFEFEF" : $c="#FFFFFF"; } ?>
  <tr>
    <td colspan="7" class="total">Total</td>
    <td class="total">&nbsp;</td>
    <td class="total"><?=$tckX?></td>
    <td class="total">&nbsp;</td>
    <td class="total">&nbsp;</td>
  </tr>
  </table>
<br />
</div>


</body>
</html>
