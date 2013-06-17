<?php 
	session_start();
	include ("../conf/conectarbase.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	//print_r($_SESSION);
	
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Producto</title>
<style type="text/css">
<!--
body {
	margin-top: 0px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;
}
.td3{ background-color:#CCCCCC; text-align:left; padding:1px; font-weight:bold;}
.td3a{ background-color:#ffffff; text-align:left; padding:1px; font-weight:normal;}
.td3B{ background-color:#FFFFCC; text-align:left; padding:1px; font-weight:bold; }
.td3C{ background-color:#FFFFCC; text-align:left; padding:1px; font-weight:bold; }
/*#div_kit{ border:#000000 1px solid; padding:2px; background-color:#FFFFCC;}*/
-->
</style>
<style type="text/css" media="print">
.invisible { display:none;}
</style>
</head>
<?
	$id=$_GET['id'];
	$lista_campos=" `id`,`id_prod`,`familia`,`subfamilia`,`especificaciones`,`no_parte_modelo`,`descripgral`, `especificacion`, `control_alm`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `activo`, `unidad`, `stock_min`, `linea`, `marca`, `observa`, `status1`, `tipo`, `kit` ";	
	//echo "<br>".
	//echo "<br>[$sql_db]=".
	$sql="SELECT $lista_campos FROM catprod WHERE id=$id";
	$result=mysql_db_query($sql_db,$sql);
	$row=mysql_fetch_array($result);
	//echo "<br>[";	print_r($row);	echo "]";	
	$id_prod=$row["id_prod"];		
		$cpromedio=$row["cpromedio"];
		$tipo_producto=$row["tipo"];
		$kit_productos=$row["kit"];	
?>
<body>
<div style="text-align:right; font-size:10px;" class="invisible"><a href="javascript:ver_kardex('<?= $row["id"]; ?>');">Kardex</a> | <a href="../reportes/existencias_por_mes.php?idp=<?= $row["id"]?>">Comportamiento</a> | <a href="../reportes/ficha_producto.php?action=exportar&idp=<?=$row["id"]?>">Exportar</a>&nbsp;&nbsp;&nbsp;
	<?php 
	if ($_SESSION)
	{
		if ($_SESSION["usuario_nivel"]==0) { ?>
		<!--| <a href="javascript:modificar_producto('<?//$row["id"]; ?>');">Modificar</a>//-->
	<?php }
	}
	?>	
</div>
<div class="t1" id="titulo" style=" font-size:14px; text-align:center; font-weight:normal; margin-top:10px; margin-bottom:10px;">
	Producto: <font color="#FF0000"><?=$id_prod."  - ".$row['descripgral'];?></font>
</div>
<div id="div_modificar" style="height:20px; background-color:#FFFFFF; display:none; ">&nbsp;</div>


<table align="center" cellpadding="0" cellspacing="0" style="width:560px; border:#000000 1px solid; text-align:left;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="4" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;  padding:2px;">Datos del Producto   </td>
</tr>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Clave de Producto  </td>
	<td class="td3a">&nbsp;<?= $row["id_prod"]; ?></td>	
    <td class="td3" align="left" bgcolor="#CCCCCC">Activo (0/1) </td>
    <td class="td3a">&nbsp;<?= $row["activo"]; ?></td>
</tr>
<!--
<tr align="center" >
  <td class="td3B" align="left">&nbsp;Familia</td>
  <td colspan="3" align="left" class="td3C">&nbsp;<?= $row["familia"]; ?>    &nbsp;&nbsp;</td>
  </tr>
<tr align="center" >
  <td class="td3B" align="left">&nbsp;Sub-familia</td>
  <td colspan="3" class="td3C" align="left">&nbsp;<?= $row["subfamilia"]; ?></td>
</tr>
<tr align="center" >
  <td class="td3B" align="left">&nbsp;Especificaciones</td>
  <td colspan="3" class="td3C" align="left">&nbsp;<?= $row["especificaciones"]; ?></td>
</tr>
<tr align="center" >
  <td class="td3B" align="left">&nbsp;No parte o Modelo</td>
  <td colspan="3" class="td3C" align="left">&nbsp;<?= $row["no_parte_modelo"]; ?></td>
</tr>
//-->
<tr align="center" >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Descripci&oacute;n </td>
	<td colspan="3" class="td3a" align="left">&nbsp;<?= $row["descripgral"]; ?></td>	
  </tr>
<?php if ($row["linea"]=="NX") { ?>
<tr>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Desc. en Ingl&eacute;s </td>
  <td colspan="3" class="td3a">
		<?php
		if (!$_SESSION)
		{ 
			//echo "<br>=0";
			echo "&nbsp;".$row["observa"]; 
		} else { 
			//echo "<br>=1";
			if ($_SESSION['usuario_nivel']==1&&$row["observa"]=="") { 
				?>
				<div id="div_dei">
				&nbsp;<input type="text" name="txt_dei" id="txt_dei" />
				<input type="button" value="Guardar" onclick="guarda_dei()" />
				</div>
				<div id="div_res_dei"></div>			
				<?php
			} else {
				echo "&nbsp;".$row["observa"];
			}	
		}
		?></td>
  </tr>
<?php } ?>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Especificaci&oacute;n </td>
	<td width="156" class="td3a">&nbsp;<?= $row["especificacion"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;L&iacute;nea de producto  </td>
	<td width="130" class="td3a">&nbsp;<?= $row["linea"]; ?></td>
</tr>
<tr >
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;No. parte o Modelo </td>
  <td class="td3a">&nbsp;<? //= $row["no_parte"]; ?></td>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Marca</td>
  <td class="td3a">&nbsp;<?= $row["marca"]; ?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Control de Almac&eacute;n </td>
	<td width="156" class="td3a">&nbsp;<?= $row["control_alm"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Ubicaci&oacute;n </td>
	<td width="130" class="td3a">
		<?php
		if (!$_SESSION)
		{ 
			//echo "<br>=0";
			echo "&nbsp;".$row["ubicacion"]; 
		} else { 
			//echo "<br>=1";
			if ($_SESSION['usuario_nivel']==1) { 
				?>
				<div id="div_cambio_ubicacion">
					&nbsp;<input type="text" name="txt_ubi" id="txt_ubi" value="<?=$row["ubicacion"]?>" size="5" />
					<input type="button" value="Guardar" onclick="guarda_ubi()" style="font-size:9px;" />
				</div>			
				<?php
			} else {
				echo "&nbsp;".$row["ubicacion"];
			}	
		}
		?>
		<div id="div_cambio_ubicacion2" style="height:50px; background-color:#efefef; display:none;"></div>	</td>
</tr>
<tr >
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad</td>
  <td class="td3a">&nbsp;<?= $row["unidad"]; ?></td>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;<!--Costo Promedio--> </td>
  <td class="td3a">&nbsp;<!--$ <?//= number_format($cpromedio,4,'.',','); ?>--></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad entrada  </td>
	<td width="156" class="td3a">&nbsp;<?= $row["uni_entrada"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad salida </td>
	<td width="130" class="td3a">&nbsp;<?= $row["uni_salida"]; ?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Stock M&iacute;nimo  </td>
	<td width="156" class="td3a">
		<?php
		if (!$_SESSION)
		{ 
			//echo "<br>=0";
			echo "&nbsp;".$row["stock_min"]; 
		} else { 
			//echo "<br>=1";
			if ($_SESSION['usuario_nivel']==1) { 
				?>
				<div id="div_cambio_smin">
					&nbsp;<input type="text" name="txt_smi" id="txt_smi" value="<?=$row["stock_min"]?>" size="5" />
					<input type="button" value="Guardar" onclick="modifica_dato('modifica_smin','txt_smi','stock_min','Stock Minimo');" style="font-size:9px;" />
				</div>			
				<?php
			} else {
				echo "&nbsp;".$row["stock_min"];
			}	
		}
		?>	</td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Stock M&aacute;ximo </td>
	<td width="130" class="td3a">
		<?php
		if (!$_SESSION)
		{ 
			//echo "<br>=0";
			echo "&nbsp;".$row["stock_max"]; 
		} else { 
			//echo "<br>=1";
			if ($_SESSION['usuario_nivel']==1) { 
				?>
				<div id="div_cambio_sma">
					&nbsp;<input type="text" name="txt_sma" id="txt_sma" value="<?=$row["stock_max"]?>" size="5" />
					<input type="button" value="Guardar" onclick="modifica_dato('modifica_smax','txt_sma','stock_max','Stock Maximo');" style="font-size:9px;" />
				</div>			
				<?php
			} else {
				echo "&nbsp;".$row["stock_max"];
			}	
		}
		?>	  
	  	<div id="div_cambio_s_maximo" style="height:50px; background-color:#efefef; display:none;"></div>	</td>
</tr>
<tr>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Status</td>
  <td colspan="3" class="td3a">&nbsp;<?php
	if ($_SESSION["nombre"]=="CIRILO"||$_SESSION["nombre"]=="Administrador")
	{
			if ($row["status1"]==2)
			{
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Obsoleto</a>";	
			} else if($row["status1"]==1) {
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Lento Movimiento</a>";
			} else {
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Uso Constante</a>";
			} 		
	} else { 
			if ($row["status1"]==2)
			{
				echo "Obsoleto";	
			} else if($row["status1"]==1) {
				echo "Lento Movimiento";
			} else {
				echo "Uso Constante";
			} 	
	}			
   ?>
	<div id="div_st_modificado" style="text-align:center; font-weight:bold; border:#000000 2px dotted; margin:2px; padding:2px; display:none;">
		<input type="hidden" name="hdn_idp1" id="hdn_idp1" value="<?=$id?>" size="5" readonly="1" />
		<select name="sel_status1" id="sel_status1">
			<option value="0">0 - Uso Constante</option>
			<option value="1">1 - Lento Movimiento</option>
			<option value="2">2 - Obsoleto</option>
		</select>
		<input type="button" onclick="modificar_status2()" value="Guardar Cambio" />
	</div></td>
</tr>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Observaciones</td>
	<td colspan="3" class="td3a">&nbsp;<?= $row["observa"]; ?>	  	</td>	
  </tr>
</table>
<br />
	<?php
	//echo "<br>[$tipo_producto][$kit_productos]";
	if($tipo_producto==3){
		$matriz_kit=explode(',',trim($kit_productos));
		?>
		<table align="center" cellspacing="0" cellpadding="1" style="width:560px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid;">
		<tr align="center">
		  <td height="20" colspan="5"  style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;  padding:2px;"> KIT de productos:</td>
		  </tr>
		<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
		  <td width="17" height="20"><a href="#" title="Id producto">Id</a> </td>
		  <td width="95"><a href="#" title="Clave de Producto">Clave</a> </td>
		  <td width="180"><a href="#" title="Descripci&oacute;n del producto">Descripci&oacute;n</a></td>
		  <td width="226"><a href="#" title="Especificacion del producto">Especificacion</a></td>
		  <td width="30"><a href="#" title="Cantidad del producto">Cant</a></td>
		  </tr>
		<?php 
			$color="#FFFFFF";
			$matriz_no_kits_elementos=array();
			foreach ($matriz_kit as $kit_elemento){
				$descomponer_kit_elemento=explode('(',$kit_elemento);
					$id_elementoX=$descomponer_kit_elemento[0];
					$cantidadX=intval($descomponer_kit_elemento[1]);
				//echo "<br>".
				$sql_producto_kit="SELECT `id`,`id_prod`,`descripgral`,`especificacion`,`activo`,`$cexi0` FROM catprod WHERE id=$id_elementoX";
				if ($result_producto_kit=mysql_db_query($sql_db,$sql_producto_kit,$link)){
					$ndr_producto_kit=mysql_num_rows($result_producto_kit);			
					$row_producto_kit=mysql_fetch_array($result_producto_kit);
						$id_producto_kit=$row_producto_kit["id"];
						$cl_producto_kit=$row_producto_kit["id_prod"];
						$de_producto_kit=$row_producto_kit["descripgral"];
						$es_producto_kit=$row_producto_kit["especificacion"];
						$ex_producto_kit=$row_producto_kit[$cexi0];
						
			$total_kit_producto=floor($ex_producto_kit/$cantidadX);
			array_push($matriz_no_kits_elementos,$total_kit_producto);							
				} else {
					echo "<br>Error SQL [".mysql_error($link)."]."; 
				}
		?>
		<tr bgcolor="<?=$color?>" align="left">
		  <td height="20"><?=$id_producto_kit?></td>
		  <td><?=$cl_producto_kit?></td>
		  <td><?=$de_producto_kit?></td>
		  <td>&nbsp;<?=$es_producto_kit?></td>
		  <td align="right"><?=$cantidadX?></td>
		  </tr>
		<?php 
			($color=="#FFFFFF")? $color="#D9FFB3" : $color="#FFFFFF"; 
		} 
		$menor_no_kit=min($matriz_no_kits_elementos);
		?>  
		<tr>
		  <td colspan="5" style="background-color:#FFFFCC; border-top:#000000 1px solid; text-align:center; font-weight:bold;">Cantidad de  kits en el almac&eacute;n <?=$idalm." ".$nalm0?>  [<?=$menor_no_kit?>]. </td>
		  </tr>
		</table>
	<?php
	} else {
	?>

<br />
<table align="center" cellpadding="0" cellspacing="0" style="width:560px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="4" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF; padding:1px;">Almacenes Asociados  </td>
</tr>
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td width="36"># </td>
	<td width="311">Almacen </td>	
	<td width="85">Existencias </td>
	<td width="108">Transferencias </td>
</tr>
<?php 
	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen WHERE id_almacen<>43 ORDER BY id_almacen";
	$result0=mysql_db_query($sql_db,$sql_alm);
	while ($row0=mysql_fetch_array($result0))
	{ 
		$id_almacen=$row0["id_almacen"];
		$almacen=$row0["almacen"];
		
		$campo_almacen="a_".$id_almacen."_".$almacen;
		$campo_existencias="exist_".$id_almacen;	
		$campo_transferencias="trans_".$id_almacen;
		
		//echo "<br><br> [$id_almacen] [$almacen] [$campo_almacen] [$campo_existencias] [$campo_transferencias]<br>"; 
		
		$sql_alm1="SELECT `$campo_existencias`,`$campo_transferencias` FROM catprod WHERE id='$id' AND `$campo_almacen`=1";
		$res1=mysql_db_query($sql_db,$sql_alm1);
		while ($row1=mysql_fetch_array($res1))
		{ 	?>
			<tr bgcolor="<?=$color;?>">
				<td align="center" height="20"><?=$id_almacen; ?> </td>
				<td align="left"> <?=$almacen; ?></td>	
				<td align="right"><?=$row1[$campo_existencias]?></td>
				<td align="right"><?=$row1[$campo_transferencias]?></td>
			</tr>
			<?php
	 		$totale=$totale+$row1[$campo_existencias];
		 	$totalt=$totalt+$row1[$campo_transferencias];
			($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
		}
	} ?>
<tr style="font-weight:bold;">
	<td colspan="2" align="right" height="20">Subtotal&nbsp;&nbsp;</td>
	<td align="right" bgcolor="#CCCCCC"><?=$totale;?></td>
	<td align="right" bgcolor="#CCCCCC"><?=$totalt;?>&nbsp;</td>
</tr>
<tr style="font-weight:bold;">
	<td colspan="2" align="right" height="20">Total&nbsp;&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right" bgcolor="#FFFF00"><?=$totale+$totalt;?>&nbsp;</td>
</tr>
</table>
<?php } ?>
<br /><table align="center" cellspacing="0" cellpadding="0" style="width:560px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="2" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF; padding:1px;">Proveedores Asociados  </td>
</tr>
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold; text-align:center; color:#000000; padding:1px;">
	<td>#  </td>
	<td>Proveedor</td>
</tr>
<?php 
	$sql2="SELECT id_prod,id_prov FROM prodxprov WHERE id_prod='$id_prod' ";
	//echo $sql;
	$result2=mysql_db_query($sql_db,$sql2);
	while ($row2=mysql_fetch_array($result2)) {
		//print_r($row2);
$id_prov_bd_actual=$row2['id_prov'];
//print_r($row2);
//echo "<br>Id Proveedor: ($id_prov_bd_actual)";	
	
	$sql3="SELECT id_prov,nr FROM catprovee WHERE id_prov='$id_prov_bd_actual' ";
	//echo $sql;
	$result3=mysql_db_query($dbcompras,$sql3);
	$row3=mysql_fetch_array($result3);
		$ip=$row3["id_prov"];
		$nr=$row3["nr"];	
	
	?>
<tr align="center" bgcolor="<?=$color;?>" >
	<td width="23" align="center"><?=$ip;?></td>
	<td width="324" align="left">********************************<? //$nr?>  </td>	
</tr>
<?php
if ($color=="#D9FFB3") 
		$color="#FFFFFF";
	else 
		$color="#D9FFB3";
  } ?>
</table>

<br />
</body>
</html>
