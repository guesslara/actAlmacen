<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
include("../conf/conectarbase.php");

//print_r($_POST);
$ac=$_POST["action"];

if ($ac=="listar_cc"){
	$sql="SELECT * FROM tipoalmacen WHERE activo=1";
	$result=mysql_db_query($sql_db,$sql);
	$ndr=mysql_num_rows($result);
	$color="#FFFFFF";
	?>
	<br />
	<h3>Cat&aacute;logo de Centros de Costos (<?=$ndr?> resultados).</h3>
	<table align="center" cellspacing="0" class="tablax">
		<tr>
		  <td class="camposx">Id</td>
		  <td class="camposx">Centro de Costo</td>
		  
		  <td class="camposx">Obsevaciones</td>
		  <td class="camposx">Consumo en <?=date("Y")?>.</td>
		</tr>
		<? 	while($row=mysql_fetch_array($result)){ ?>
			<tr bgcolor="<?=$color?>">
			  <td class="campo_A"><?= $row["id_almacen"]?></td>
			  <td class="campo_d">&nbsp;<?= $row["almacen"]?></td>
			  <td>&nbsp;<?= $row["observ"]?></td>
			  <td class="campo_Z" align="center">&nbsp;<?php if ($row["id_almacen"]==1){ } else { ?>
			  	<a href="#" onClick="ajax('div_detalle','action=ver_consumo&id_cc=<?=$row["id_almacen"]?>','div_contenido');" title="Ver consumo mensual del Centro de Costo <?=$row["id_almacen"]?>">movimientos</a> | <a href="#" onClick="ajax('div_detalle','action=ver_consumo_resumen&id_cc=<?=$row["id_almacen"]?>','div_contenido');" title="Ver consumo mensual en resumen del Centro de Costo <?=$row["id_almacen"]?>">resumen</a><?php } ?>&nbsp;</td>
			</tr>
		<?	($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF";	}	?>
	  <tr>
			  <td colspan="4" class="campo_inferior">&nbsp;</td>
	  </tr>
	</table>
	<?php	
}
if ($ac=="ver_consumo"){
	$id_cc=$_POST["id_cc"];
	$meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
	?>
	<h3>Consumo mensual del Centro de Costo <?=$id_cc?>.</h3>
	<h5 align="center">Desglose por producto</h5>
	<table class="tablax" cellspacing="0" align="center" style="font-size:small; font-family:Arial, Helvetica, sans-serif; " cellpadding="2">
	<tr>
		<td class="camposx">Mes</td>
		<td class="camposx">fecha</td>
		<td class="camposx">id_mov</td>
		<td class="camposx">almacen</td>
		<td class="camposx">asociado</td>
		<td class="camposx">concepto</td>
		<td class="camposx">id_producto</td>
		<td class="camposx">clave producto</td>
		<td class="camposx">descripci&oacute;n</td>
		<td class="camposx">especificacion</td>
		<td class="camposx">cantidad</td>
		<td class="camposx">c.u($).</td>
		<td class="camposx">subtotal($)</td>
	</tr>
	<?php
	foreach ($meses as $nmes=>$mes){
		//echo "<br>$nmes->$mes";
		//echo "<br>".
		/*
		$sql_1="SELECT mov_almacen.*,prodxmov.*,prodxmov.cantidad*prodxmov.cu AS subtotal FROM mov_almacen, prodxmov 
		WHERE mov_almacen.id_mov=prodxmov.nummov
			AND mov_almacen.almacen=1
			AND mov_almacen.tipo_mov=9
			AND mov_almacen.asociado=$id_cc
			AND mov_almacen.fecha BETWEEN '".date("Y")."-$nmes-01' AND '".date("Y")."-$nmes-31' 
		ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";
		*/
		$sql_1="SELECT 
			mov_almacen.*,
			prodxmov.*,
				prodxmov.cantidad*prodxmov.cu AS subtotal,
			catprod.descripgral,
			catprod.especificacion
				 
		FROM mov_almacen, prodxmov, catprod 
		WHERE mov_almacen.id_mov=prodxmov.nummov
			AND mov_almacen.almacen=1
			AND mov_almacen.tipo_mov=9
			AND mov_almacen.asociado=$id_cc
			
			AND catprod.id=prodxmov.id_prod
			
			
			AND mov_almacen.fecha BETWEEN '".date("Y")."-$nmes-01' AND '".date("Y")."-$nmes-31' 
		ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";		
		
		if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
			$ndr1=mysql_num_rows($res_1);
			if ($ndr1>0){
				$color="#FFFFFF";
				while ($reg_1=mysql_fetch_array($res_1)){
					//echo "<br><br>";	print_r($reg_1);
					$suma_subtotal+=$reg_1["subtotal"];
					?>
					<tr bgcolor="<?=$color?>">
						<td class="campo_A"><?=$mes?></td>
						<td class="campo_d"><?=$reg_1["fecha"]?></td>
						<td class="campo_d" align="center"><?=$reg_1["id_mov"]?></td>
						<td class="campo_d" align="center"><?=$reg_1["almacen"]?></td>
						<td class="campo_d" align="center"><?=$reg_1["asociado"]?></td>
						<td class="campo_d" align="center"><?=$reg_1["tipo_mov"]?></td>
						<td class="campo_d" align="center"><?=$reg_1["id_prod"]?></td>
						<td class="campo_d"><?=$reg_1["clave"]?></td>
						<td class="campo_d"><?=$reg_1["descripgral"]?></td>
						<td class="campo_d"><?=$reg_1["especificacion"]?></td>
						<td class="campo_d" align="right"><?=$reg_1["cantidad"]?></td>
						<td align="right"><?=number_format($reg_1["cu"],4,".",",");?></td>
						<td class="campo_Z" align="right"><?=number_format($reg_1["subtotal"],4,".",",");?></td>
					</tr>					
					<?php
					($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF";
				}
			} else {
				//echo "<br>NO se encontraron resultados en $mes del ".date("Y").".";
			}
		}else{ echo mysql_error($link); }
	}
	?>
	<tr style="text-align:right; font-weight:bold;">
	  <td colspan="8" class="campo_inferior">Total</td>
	  <td class="campo_inferior">&nbsp;</td>
	  <td class="campo_inferior">&nbsp;</td>
	  <td class="campo_inferior">&nbsp;</td>
	  <td class="campo_inferior">&nbsp;</td>
	  <td class="campo_inferior"><?=number_format($suma_subtotal,4,".",",");?></td>
	</tr>	
	</table>
	<div class="acotaciones">La tabla presenta los movimientos de Salida por Traspaso (Concepto 9) del Centro de Costo 1 al Centro de Costo <?=$id_cc?> (Asociado), realizados en el <?=date("Y")?>.</div>
	<?php
}
if ($ac=="ver_consumo_resumen"){
	$id_cc=$_POST["id_cc"];
	$meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
	?>
	<div id="datos">
		<div id="grafica_titulo"><a href="javascript:ocultar('datos');" style=" width:25x; text-align:center; border:#EFEFEF 1px solid; background-color:#FFFFFF; color:#FF0000; font-weight:bold; padding:1px; margin-top:2px; margin-right:1px; float:right; text-decoration:none;">X</a></div>		
		<h3>Consumo mensual del Centro de Costo <?=$id_cc?>.</h3>
		<h5 align="center">Resumen</h5>	
		<table class="tablax" cellspacing="0" align="center" width="400">
		<tr>
			<td width="143" class="camposx">Mes</td>
			<td width="251" class="camposx">subtotal ($)</td>
		</tr>
		<?php
		$color="#FFFFFF";
		foreach ($meses as $nmes=>$mes){
			//echo "<br>$nmes->$mes";
			//echo "<br>".
			$sql_1="SELECT SUM(prodxmov.cantidad*prodxmov.cu) AS suma_subtotal_mensual FROM mov_almacen, prodxmov 
			WHERE mov_almacen.id_mov=prodxmov.nummov
				AND mov_almacen.almacen=1
				AND mov_almacen.tipo_mov=9
				AND mov_almacen.asociado=$id_cc
				AND mov_almacen.fecha BETWEEN '".date("Y")."-$nmes-01' AND '".date("Y")."-$nmes-31' 
			ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";
			if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
				$ndr1=mysql_num_rows($res_1);
				if ($ndr1>0){
					
					while ($reg_1=mysql_fetch_array($res_1)){
						//echo "<br><br>";	print_r($reg_1);
						$suma_subtotal+=$reg_1["suma_subtotal_mensual"];
						?>
						<tr bgcolor="<?=$color?>">
							<td class="campo_A">&nbsp;<?=$mes?></td>
							<td class="campo_Z" align="right"><input type="hidden" id="hdn_<?=$nmes?>" value="<?php if ($reg_1["suma_subtotal_mensual"]=="") { echo "0"; } else { echo $reg_1["suma_subtotal_mensual"]; } ?>" /><input type="text" id="txt_<?=$nmes?>" value="<?=number_format($reg_1["suma_subtotal_mensual"],4,".",",");?>" style="text-align:right;" readonly="1" /></td>
						</tr>					
						<?php
						
					}
				} else {
					//echo "<br>NO se encontraron resultados en $mes del ".date("Y").".";
				}
			}else{ echo mysql_error($link); }
			($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF";
		}
		?>
		<tr style="text-align:right; font-weight:bold;">
		  <td class="campo_inferior">Total</td>
		  <td class="campo_inferior"><input type="text" id="txt_total" value="<?=number_format($suma_subtotal,4,".",",");?>"  style="text-align:right; font-weight:bold;" readonly="1" /></td>
		</tr>	
		</table>
	<div class="acotaciones">La tabla presenta la <u>suma mensual en <b>$</b></u> de los movimientos de Salida por Traspaso (Concepto 9)<br /> del Centro de Costo 1 al Centro de Costo <?=$id_cc?> (Asociado), realizados en el <?=date("Y")?>.</div>		
		<script language="javascript">
			graficar(<?=$id_cc?>);
		</script>
	</div>
	<?php
}
?>