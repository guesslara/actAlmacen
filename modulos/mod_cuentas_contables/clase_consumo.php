<?php
class consumo{
	var $bd_2011='2013_iqe_inv';
	var $finicio='2013-05-01';
	var $ffin='2013-06-05';
	//$this->finicio;
	//$this->ffin;
	function listar_consumos(){
		//echo $this->finicio;
		$this->listar_consumos_detalle($this->finicio,$this->ffin);
		//$this->listar_consumos_x_cc_resumen();
		exit;
		
		echo "<br>listar_consumos()";
		include ("../conf/conectarbase.php");
		//$id_cc=29;
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
				//echo "<br>$nmes->$mes";	AND mov_almacen.asociado=$id_cc
				echo "<br>".$sql_1="SELECT SUM(prodxmov.cantidad*prodxmov.cu) AS suma_subtotal_mensual FROM mov_almacen, prodxmov 
				WHERE mov_almacen.id_mov=prodxmov.nummov
					AND mov_almacen.almacen=1
					AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
					
					AND mov_almacen.fecha BETWEEN '".date("Y")."-$nmes-01' AND '".date("Y")."-$nmes-31' 
				ORDER BY mov_almacen.fecha, mov_almacen.id_mov, mov_almacen.fecha,prodxmov.id";
				
				
				
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
		<div class="acotaciones">La tabla presenta la <u>suma mensual en <b>$</b></u> de los movimientos de Salida por Traspaso (Concepto 9)<br />
	      de los almacenes : 1,48,77 al Centro de Costo 
	      <?=$id_cc?> (Asociado), realizados en el <?=date("Y")?>.</div>		
			<script language="javascript">
				graficar(<?=$id_cc?>);
			</script>
		</div>
		<?php
		
	}
//=============================================================
	function listar_consumo_resumen($finicio,$ffin){
		$fechaInicial=$this->finicio;
		$fechaFinal=$this->ffin;
	//$this->ffin;
		include ("../conf/conectarbase.php");
		$year='2013';
		// EMPIEZA EL GRAFICO ...
		$datos_grafica_swf="";
			$datos_grafica_swf.="<chart palette='2' showBorder='0' formatNumberScale='0'  numberPrefix='$' >";			
		
		
		?>
		<h3 align="center">Consumo Mensual ---( <?=$year?>) por  Centro de Costo.</h3>
		<?php
		//incluir alert solicitando fecha inicial y fecha final  <-------------
		//"<br>".==========================================================  cambio fecha para reporte en esta consulta===========
		echo 
		$sql_total="SELECT 
				sum(prodxmov.cantidad*prodxmov.cu) AS subtotal
		FROM mov_almacen, prodxmov, tipoalmacen 
		WHERE 
			mov_almacen.asociado=tipoalmacen.id_almacen
			AND mov_almacen.id_mov=prodxmov.nummov

			AND mov_almacen.almacen IN (1,48,77)
			AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			
			AND mov_almacen.asociado>1
			
			 AND mov_almacen.fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' ORDER BY subtotal DESC;";	
		//echo "TOT=".
		$totalX=$this->dame_no_resultados($sql_total);
		?>
		<div id="div_graficaX" align="center">&nbsp;</div> 
		<br>
		<div align="center">
			<a href="index_consumo_mensual.php" target="_blank">Reporte Personalizado</a> |
			<a href="#" onClick="ajax('div_cc_C','ac=listar_consumo_detalle')"> ver detalle &rarr;</a>
		</div>
		<br>
		<table cellspacing="0" align="center" cellpadding="2" width="600">
		<tr>
			<th>id_cc</th>
			<th>centro de costo.</th>
			<th>$ subtotal &darr;</th>
			<th>%</th>
			<th>&raquo;</th>
		</tr>
		<?php
			echo "<br>".
			$sql_1="SELECT 
				mov_almacen.*,
				prodxmov.*,
					sum(prodxmov.cantidad*prodxmov.cu) AS subtotal,
				tipoalmacen.almacen AS almacen_nombre 
			FROM mov_almacen, prodxmov, tipoalmacen 
			WHERE 
				mov_almacen.asociado=tipoalmacen.id_almacen
				AND mov_almacen.id_mov=prodxmov.nummov

				AND mov_almacen.almacen IN (1,48,77)
				AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
				AND mov_almacen.asociado>1
				
				AND mov_almacen.fecha BETWEEN  '".$fechaInicial."' AND '".$fechaFinal."'
				
			GROUP BY mov_almacen.asociado	 
			ORDER BY mov_almacen.asociado";		
			
			// AND mov_almacen.fecha BETWEEN '".date("Y")."-$nmes-01' AND '".date("Y")."-$nmes-31'
			
			
			
			//if ($res_1=mysql_db_query('iqe_inv_2010',$sql_1,$link)){	// 2010
			if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){	// 2011
				$ndr1=mysql_num_rows($res_1);
				if ($ndr1>0){
					$color="#FFFFFF";
					while ($reg_1=mysql_fetch_array($res_1)){
						//echo "<br><br>";	print_r($reg_1);
						$suma_subtotal+=$reg_1["subtotal"];
						$datos_grafica_swf.="<set label='".$reg_1["almacen_nombre"]."' value='".round($reg_1["subtotal"],2)."'  />";
							// isSliced='1' 
						?>
						<tr bgcolor="<?=$color?>">
							<td align="center"><?=$reg_1["asociado"]?></td>
							<td><?=$reg_1["almacen_nombre"]?></td>
							<td align="right"><?=number_format($reg_1["subtotal"],2,".",",");?></td>
							<td align="right"><?=round(($reg_1["subtotal"]/$totalX*100),2)?> %</td>
							<td align="center">
							<a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_resumen_CC_del_CdC&id_centro_costo=<?=$reg_1["asociado"]?>')" title="Ver desglose de los productos relacionados a la Cuenta Contable">desglose por CC</a>
							</td>							
						</tr>					
						<?php
						($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF";
						
					}
				} else {
					//echo "<br>NO se encontraron resultados en $mes del ".date("Y").".";
				}
			}else{ echo mysql_error($link); }
		?>
		<tr style="text-align:right; font-weight:bold;">
		  <td colspan="2">Total $ &rarr; </td>
		  <td><?=number_format($suma_subtotal,2,".",",");?></td>
		  <td align="right">100 %</td>
		  <td align="center">&nbsp;</td>
		</tr>	
		</table>
		<div style="font-size:small; text-align:center; color:#0000FF; margin:5px;">La tabla presenta los movimientos de Salida por Traspaso (Concepto 9)  y Salida por Asignacion (Concepto 17)<br> 
		de los almacenes : 1,48,77  al Centro de Costo <?=$id_cc?> (Asociado), realizados en Abril <?=$year?>.</div>
		<?php
		$datos_grafica_swf.="</chart>";	
		?>
		<script type="text/javascript">
			  //var myChart = new FusionCharts("swf/Doughnut3D.swf", "myChartId", "800", "270", "0", "0");
			  var myChart = new FusionCharts("swf/Pie3D.swf", "myChartId", "800", "500", "0", "0");
			  myChart.setDataXML("<?=$datos_grafica_swf?>");		   
			  myChart.render("div_graficaX");
		</script>		
		<?php		
	}		



	function listar_consumo_detalle($finicio,$ffin){
		include ("../conf/conectarbase.php");
		$fechaInicial=$this->finicio;
		$fechaFinal=$this->ffin;
		$year='2013';
		?>
		<h3 align="center">Consumo Mensual (Mayo. <?=$year?>) por  Centro de Costo (desglose por producto)</h3>
		<table cellspacing="0" align="center" cellpadding="3">
		<tr>
			<th>fecha</th>
			<!--<th>id_mov</th>//-->
			<th>almac&eacute;n</th>
			<th>fecha</th>
			<th>asociado</th>
			<th>cuenta_contable</th>
			<!--<th>concepto</th>//-->
			<th>id</th>
			<th>clave producto</th>
			<th>descripci&oacute;n</th>
			<th>especificacion</th>
			<th><a href="#" title="Este campo evalua si el producto ya esta asociado a una Cuenta Contable">esta en CC</a></th>
			<th>cantidad</th>
			<th>c.u($).</th>
			<th>subtotal($)</th>
		</tr>
		<?php
			//echo "<br>".=======================================================  cambio fecha para reporte en esta consulta===========
			echo
			$sql_1="SELECT 
				mov_almacen.*,
				prodxmov.*,
					prodxmov.cantidad*prodxmov.cu AS subtotal,
				catprod.descripgral,
				catprod.especificacion,
				tipoalmacen.almacen AS almacen_nombre 
			FROM mov_almacen, prodxmov, catprod, tipoalmacen 
			WHERE 
				mov_almacen.asociado=tipoalmacen.id_almacen
				AND mov_almacen.id_mov=prodxmov.nummov
				AND catprod.id=prodxmov.id_prod

				AND mov_almacen.almacen IN (1,48,77)
				AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )

				 AND mov_almacen.fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'
				 
				 
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
							<td><?=$reg_1["fecha"]?></td>
							<!--<td align="center"><?=$reg_1["id_mov"]?></td>//-->
							<td align="center"><?=$reg_1["almacen"]?></td>
							<td align="center"><?=$reg_1["fecha"]?></td>
							<td align="center"><?=$reg_1["asociado"]?></td>
							<td align="center"><?php
							
								$sql_cc="SELECT 
									CONCAT(cat_cuentas.cuenta,' ',cat_cuentas.descripcion)
								FROM 
									rel_cc_vs_productos, cat_cuentas 
								WHERE 
									rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
									AND rel_cc_vs_productos.id_producto='".$reg_1["id_prod"]."'
								LIMIT 1;";
								$cuenta_contableX=$this->dame_no_resultados($sql_cc);							
							
							?>
							<a href="#" title="<?=$cuenta_contableX?>"><?=substr($cuenta_contableX,0,16)?></a>							</td>
							<!--<td align="center"><?=$reg_1["tipo_mov"]?></td>//-->
							<td align="center"><?=$reg_1["id_prod"]?></td>
							<td><?=$reg_1["clave"]?></td>
							<td><?=$reg_1["descripgral"]?></td>
							<td><?=$reg_1["especificacion"]?></td>
							<td align="center" style="background-color:#ccc;">&nbsp;<?php
								//echo $this->dame_no_resultados("SELECT count(id_producto) FROM rel_cc_vs_productos WHERE id_producto='".$reg_1["id_prod"]."' LIMIT 1;");
								if($this->dame_no_resultados("SELECT count(id_producto) FROM rel_cc_vs_productos WHERE id_producto='".$reg_1["id_prod"]."' LIMIT 1;"))
									echo "SI";
								else echo "NO";
							
							?></td>
							<td class="campo_d" align="right"><?=$reg_1["cantidad"]?></td>
							<td align="right"><?=number_format($reg_1["cu"],2,".",",");?></td>
							<td class="campo_Z" align="right"><?=number_format($reg_1["subtotal"],2,".",",");?></td>
						</tr>					
						<?php
						($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF";
					}
				} else {
					//echo "<br>NO se encontraron resultados en $mes del ".date("Y").".";
				}
			}else{ echo mysql_error($link); }
		//}
		?>
		<tr style="text-align:right; font-weight:bold;">
		  <td colspan="11">Total &rarr; </td>
		  <td>$<?=number_format($suma_subtotal,2,".",",");?></td>
		</tr>	
		</table>
		<div style="font-size:small; text-align:center; color:#0000FF; margin:5px;">La tabla presenta los movimientos de Salida por Traspaso (Concepto 9) y Salida por Asignacion (Concepto 17) de los almacenes : 1,48,77  al Centro de Costo (Asociado), realizados en el <?=date("Y")?>.</div>
		<?php
	
	}	
	
	
	function listar_consumo_resumen_cuentacontable(){
		//echo "<br>listar_consumo_resumen_cuentacontable()";
		include ("../conf/conectarbase.php");
		$year='2012';
		
		// EMPIEZA EL GRAFICO ...
		$datos_grafica_swf="";
			$datos_grafica_swf.="<chart palette='2' showBorder='0' formatNumberScale='0'  numberPrefix='$' >";			
	
		?>
		<h3 align="center">Consumo Anual (<?=$year?>) por  Cuenta Contable</h3>
		<?php
		//echo "<br>[$sql_db]->".
		$sql_total="SELECT 
			cat_cuentas.id_cuenta, cat_cuentas.descripcion,
			sum(prodxmov.cantidad*prodxmov.cu) AS subtotal	
		FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			
			AND prodxmov.id_prod=rel_cc_vs_productos.id_producto
			AND rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
			
			AND mov_almacen.almacen IN (1,48,77)
			AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			AND mov_almacen.asociado>1
		GROUP BY cat_cuentas.id_cuenta
		ORDER BY subtotal DESC
		;
		";		
		$sql_total_total="SELECT 
			sum(prodxmov.cantidad*prodxmov.cu) AS subtotal	
		FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			
			AND prodxmov.id_prod=rel_cc_vs_productos.id_producto
			AND rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
			
			
			AND mov_almacen.almacen IN (1,48,77)
			AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			AND mov_almacen.asociado>1
		";
		$total_total_x=$this->dame_no_resultados($sql_total_total);
		//exit;
		if($res=mysql_db_query($sql_db,$sql_total,$link)){
			$ndr=mysql_num_rows($res);
			if ($ndr>0){
				?>
				<div id="div_graficaX" align="center">&nbsp;</div> 
				<br><div align="center"><a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_detalle_cuenta_contable')">ver detalle</a></div>				
				<br /><table align="center" cellpadding="2" cellspacing="0" width="800">
				<tr>
					<th>id_cuenta</th>
					<th>cuenta</th>
					<th>$ subtotal &darr;</th>
					<th>%</th>
				</tr>
				
				<?php
				while($reg=mysql_fetch_array($res)){
					//echo "<br><br>";	print_r($reg);	
					$datos_grafica_swf.="<set label='".$reg["descripcion"]."' value='".round($reg["subtotal"],2)."'  />";
					?>
					<tr>
						<td align="center"><?=$reg["id_cuenta"]?></td>
						<td><?=$reg["descripcion"]?></td>
						<td align="right"><?=number_format($reg["subtotal"],2,'.',',')?></td>
						<td align="right"><?=number_format(($reg["subtotal"]/$total_total_x*100),2,'.',',')?></td>
					</tr>
					<?php	
				}
				?>
				<tr>
					<th colspan="2" align="right">Total $ &rarr;</th>
					<th align="right"><?=number_format($total_total_x,2,'.',',')?></th>
					<th align="right">100 %</th>
				</tr>
				</table><?php
			}else{ die("<h3 align='center'>Sin resultados</h3>"); }
		}else{ die("<h3 align='center'>Error SQL : ".mysql_error($link)."</h3>"); }				
		$datos_grafica_swf.="</chart>";	
		?>
		<script type="text/javascript">
			  //var myChart = new FusionCharts("swf/Doughnut3D.swf", "myChartId", "800", "270", "0", "0");
			  var myChart = new FusionCharts("swf/Pie3D.swf", "myChartId", "800", "300", "0", "0");
			  myChart.setDataXML("<?=$datos_grafica_swf?>");		   
			  myChart.render("div_graficaX");
		</script>		
		<?php		
	}
	



	function listar_consumo_detalle_cuenta_contable(){
		//echo "<br>listar_consumo_detalle_cuenta_contable()";

		include ("../conf/conectarbase.php");
		$year='2011';
		
		?>
		<h3 align="center" onclick="ajax('div_cc_C','ac=listar_consumo_detalle_cuenta_contable')">Consumo Anual (<?=$year?>) por  Cuenta Contable (detalle)</h3>
		<?php
		//echo "<br>[$sql_db]->".
		$sql_total="SELECT 
			
			cat_cuentas.cuenta, cat_cuentas.descripcion,
			mov_almacen.id_mov,
			prodxmov.id_prod, prodxmov.cantidad, prodxmov.cu,
			catprod.id AS id_productoX, catprod.id_prod AS claveX, catprod.descripgral, catprod.especificacion  	
		FROM catprod, mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			AND prodxmov.id_prod=catprod.id
			
			AND prodxmov.id_prod=rel_cc_vs_productos.id_producto
			AND rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
			
			AND mov_almacen.almacen IN (1,48,77)
			AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			AND mov_almacen.asociado>1
		
		ORDER BY cat_cuentas.a ASC, cat_cuentas.b ASC, cat_cuentas.c ASC, cat_cuentas.d ASC
		
		;
		";
		/*
		GROUP BY cat_cuentas.id_cuenta
		ORDER BY subtotal DESC
		sum(prodxmov.cantidad*prodxmov.cu) AS subtotal
		
		*/
		$sql_total_total="SELECT 
			sum(prodxmov.cantidad*prodxmov.cu) AS subtotal	
		FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			
			AND prodxmov.id_prod=rel_cc_vs_productos.id_producto
			AND rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
			
			AND mov_almacen.almacen IN (1,48,77)
			AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			AND mov_almacen.asociado>1
		ORDER BY subtotal DESC
		;
		";
		$total_total_x=$this->dame_no_resultados($sql_total_total);	
		//echo "<hr>TOT=$total_total_x<hr>";	
				
		if($res=mysql_db_query($sql_db,$sql_total,$link)){
			//echo "<br>NDR=".
			$ndr=mysql_num_rows($res);
			if ($ndr>0){
				
				?>
				<h4 align="center"><?=$ndr?> resultados</h4>
				<table align="center" cellpadding="3" cellspacing="0" width="98%">
				<tr>
					<th>id_cuenta &darr;</th>
					<th>cuenta</th>
					<th>id_mov</th>
					<th>id_producto</th>
					<th>clave</th>
					<th>descripcion</th>
					<th>especificacion</th>
					<th>cantidad</th>
					<th>cu</th>
					<th>$ subtotal</th>
				</tr>
				
				<?php
				$colorX='#ffffff';
				while($reg=mysql_fetch_array($res)){
					//echo "<br><br>";	print_r($reg);	especificacion
					$subtotalX=$reg["cantidad"]*$reg["cu"];
					$totalX+=$subtotalX;
					?>
					<tr bgcolor="<?=$colorX?>">
						<td align="center"><?=$reg["cuenta"]?></td>
						<td><?=$reg["descripcion"]?></td>
						<td align="center"><?=$reg["id_mov"]?></td>
						<td><?=$reg["id_prod"]?></td>
						
						<td><?=$reg["claveX"]?></td>
						<td><?=$reg["descripgral"]?></td>
						<td><?=$reg["especificacion"]?></td>
						
						<td align="right"><?=$reg["cantidad"]?></td>
						<td align="right"><?=number_format($reg["cu"],2,'.',',')?></td>
						
						<td align="right"><?=number_format($subtotalX,2,'.',',')?></td>
					</tr>
					<?php
					($colorX=='#ffffff')?$colorX='#efefef':$colorX='#ffffff';	
				}
				
				?>
				<tr>
					<th align="right" colspan="9">Total $ &rarr;</th>
					<th align="right"><?=number_format($totalX,2,'.',',')?><br /><?=$total_total_x?></th>
				</tr>
				</table><br /><?php		
			}else{ die("<h3 align='center'>Sin resultados</h3>"); }
		}else{ die("<h3 align='center'>Error SQL : ".mysql_error($link)."</h3>"); }				
		
		
	}		
		
	
	// =======================================
	function dame_no_resultados($sql){
		include ("../conf/conectarbase.php");
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
}
?>
