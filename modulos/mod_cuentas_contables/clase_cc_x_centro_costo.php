<?php
class cc_vs_cc{
	function cc_x_cdc_menu(){
		include("../conf/conectarbase.php");
		//echo "<br>OK";
		
			//echo "<hr><br>".
			$sql="SELECT * FROM tipoalmacen WHERE activo='1' ORDER BY id_almacen; ";
			if($res=mysql_db_query($sql_db,$sql,$link)){
				//echo "<br>NDR=".
				$ndr=mysql_num_rows($res);
				if($ndr>0){
					?>
					<table align="center" width="60%" cellpadding="2" cellspacing="0">
					<tr>
						<th>id</th>
						<th>centro de costo</th>
						<th>&nbsp;</th>
					</tr>
					<?php
					while($reg=mysql_fetch_array($res)){
						//($reg["c"]=='000')?$style='font-weight:bold; color:#0000FF;':$style='font-weight:normal; color:#000;';
						/*
						 style=" text-align:center; <?=$style?>"
						 
						 
						 
						*/
						?>
						<tr>
						  <td align="center"><?=$reg["id_almacen"]?></td>
						  <td><?=$reg["almacen"]?></td>
						  <td align="left">&nbsp;</td>
						</tr>					
						<?php
					}
					?></table>
	<?php				
				}else{ die("<br><h3 align='center'>Sin resultados</h3>"); }
			}else{ die("<br><h3 align='center'>Error SQL : <br>".mysql_error($link))."</h3>"; }		
	}
	function listar_consumo_detalle_CC_del_CdC($id_centro_costo){		
		//echo "<br>listar_consumo_detalle_CC_del_CdC($id_centro_costo)";
		include ("../conf/conectarbase.php");
		?>
		<hr />
		<h3 align="center">Desglose de Consumo Abril. (<?=date("Y")?>)</h3>
		<h4 align="center" onclick="ajax('div_cc_C','ac=listar_consumo_detalle_CC_del_CdC&id_centro_costo=<?=$id_centro_costo?>')" style="color:#0000FF; cursor:pointer; ">
			<?=$id_centro_costo?> &rarr;  
			<?=$this->dame_no_resultados("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$id_centro_costo."' LIMIT 1; ")?>
		</h4>
		<table cellspacing="0" align="center" cellpadding="3">
		<tr>
			<th>fecha</th>
			<!--<th>id_mov</th>//-->
			<th>almac&eacute;n</th>
			<th>fecha</th>
			<!--//--><th>asociado</th>
			<th>cuenta_contable</th>
			<!--<th>concepto</th>//-->
			<th>id</th>
			<th>clave producto</th>
			<th>descripci&oacute;n</th>
			<th>especificacion</th>
			<th><a href="#" title="Este campo evalua si el producto ya esta asociado a una Cuenta Contable">esta en CC</a> </th>
			<th>cantidad</th>
			<th>c.u($).</th>
			<th>subtotal($)</th>
		</tr>
		<?php
			//echo "<br>".
			/*
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

				AND mov_almacen.almacen=1
				AND mov_almacen.tipo_mov=9

				 
			ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";			
			*/
			//echo "<br>".
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
				AND mov_almacen.asociado='$id_centro_costo'
				
				AND mov_almacen.fecha BETWEEN '2012-08-01' AND '2012-08-31'		

			ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";				
			if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
				//echo "<br>NDR=".
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
							<!--//--><td align="center"><?=$reg_1["asociado"]?></td>
							<td align="center">&nbsp;<?php
								
								// cat_cuentas.descripcion cat_cuentas.cuenta
								$sql_cc="SELECT 
									CONCAT(cat_cuentas.cuenta,' ',cat_cuentas.descripcion)
								FROM 
									rel_cc_vs_productos, cat_cuentas 
								WHERE 
									rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
									AND rel_cc_vs_productos.id_producto='".$reg_1["id_prod"]."'
								LIMIT 1;";
								$cuenta_contableX=$this->dame_no_resultados($sql_cc);
								//echo substr(,0,16);
								
							?><a href="#" title="<?=$cuenta_contableX?>"><?=substr($cuenta_contableX,0,16)?></a></td>
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
	
	
	function listar_equipos_no_asociados(){
		include ("../conf/conectarbase.php");
		?>
		<h3 align="center" onClick="ajax('div_cc_C','ac=listar_equipos_no_asociados')">Productos no asociados</h3>
		
		<?php
		echo "<br>".$sql="SELECT DISTINCT (prodxmov.id_prod) FROM prodxmov,catprod WHERE prodxmov.id_prod=catprod.id AND catprod.activo='1' ORDER BY prodxmov.id_prod ; ";
		$prods_no_encontrados=array();
		if($res=mysql_db_query($sql_db,$sql,$link)){
			//echo "<br>NDR=".
			
			$ndr=mysql_num_rows($res);
			if($ndr>0){
				while($reg=mysql_fetch_array($res)){
					//echo "<br>";	print_r($reg);
					$esta_asociado=$this->dame_no_resultados("SELECT COUNT(id) FROM rel_cc_vs_productos WHERE id_producto='".$reg["id_prod"]."' LIMIT 1; ");
					if(!$esta_asociado){
						array_push($prods_no_encontrados,$reg["id_prod"]);
					}					
				}				
			}else{ die("<br>Sin resultados"); }
		}else{ die("<br>Error SQL : <br>".mysql_error($link)); }						
		//echo "<hr><br>NDR (".count($prods_no_encontrados).") <br>";	print_r($prods_no_encontrados);
		$sql_cadena_IN='';
		foreach ($prods_no_encontrados as $id_productoX){
			($sql_cadena_IN=='')?$sql_cadena_IN=$id_productoX:$sql_cadena_IN.=','.$id_productoX;
		} 
		//echo "<hr>$sql_cadena_IN";
		echo "<br>".$sql_catalogo="SELECT id, id_prod, descripgral, especificacion, linea
		FROM catprod
		WHERE  id IN ($sql_cadena_IN)
		ORDER BY id; ";	
		//activo=1 AND
		if($res=mysql_db_query($sql_db,$sql_catalogo,$link)){
			//echo "<br>NDR=".
			$ndr=mysql_num_rows($res);
			if($ndr>0){
				
				?>
				<table align="center" cellpadding="2" cellspacing="0">
				<tr>
					<th>id</th>
					<th>clave</th>
					<th>descripci&oacute;n</th>
					<th>especificaci&oacute;n</th>
					<th>l&iacute;nea</th>
				</tr>
				<?php 				
				while($reg=mysql_fetch_array($res)){
					//echo "<br>";	print_r($reg);
					?>
					<tr>
						<td align="center"><?=$reg["id"]?></td>
						<td><?=$reg["id_prod"]?></td>
						<td><?=$reg["descripgral"]?></td>
						<td>&nbsp;<?=$reg["especificacion"]?></td>
						<td align="center"><?=$reg["linea"]?></td>
					</tr>					
					<?php
				}
				?>
				<tr>
					<th colspan="5" align="center">&nbsp;<?=$ndr?> resultados</th>
				</tr>				
				</table>
				<br />
				<?php				
			}else{ die("<br>Sin resultados"); }
		}else{ die("<br>Error SQL : <br>".mysql_error($link)); }		
		exit;
		$prods_no_encontrados=array();
		
		//echo "<br>SQL=".
		$sql="SELECT id, id_prod, descripgral, especificacion, linea
		FROM catprod
		WHERE activo=1
		ORDER BY id
		
		; ";
		//LIMIT 10
		if($res=mysql_db_query($sql_db,$sql,$link)){
			//echo "<br>NDR=".
			$ndr=mysql_num_rows($res);
			if($ndr>0){			
				?>
				
				<table align="center" cellpadding="2" cellspacing="0">
				<tr>
					<th>id</th>
					<th>clave</th>
					<th>descripci&oacute;n</th>
					<th>especificaci&oacute;n</th>
					<th>l&iacute;nea</th>
				</tr>	
				<?php			
				$contador=0;
				while($reg=mysql_fetch_array($res)){
					//echo "<br>";	print_r($reg);
					$esta_asociado=$this->dame_no_resultados("SELECT COUNT(id) FROM rel_cc_vs_productos WHERE id_producto='".$reg["id"]."' LIMIT 1; ");
					if(!$esta_asociado){ 
						//echo "<br>";	print_r($reg);
						//echo "<br>".$reg["id"]." asociado ($esta_asociado)";
						//array_push($prods_no_encontrados,$reg["id"]);
						++$contador;
						?>
						<tr>
							<td align="center"><?=$reg["id"]?></td>
							<td><?=$reg["id_prod"]?></td>
							<td><?=$reg["descripgral"]?></td>
							<td>&nbsp;<?=$reg["especificacion"]?></td>
							<td align="center"><?=$reg["linea"]?></td>
						</tr>						
						<?php
					}	
				}
				?>
				<tr>
					<td colspan="5" align="center">&nbsp;<?=$contador?> resultados</td>
				</tr>				
				</table>
				<?php
			}else{ die("<br>Sin resultados"); }
		}else{ die("<br>Error SQL : <br>".mysql_error($link)); }
	}
	function listar_consumo_resumen_CC_del_CdC($id_centro_costo){
		include ("../conf/conectarbase.php");
		$total_consumo=0;
		$sql_1="SELECT 
			DISTINCT (cat_cuentas.cuenta), cat_cuentas.descripcion, SUM(prodxmov.cantidad*prodxmov.cu) AS subtotal 
		FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			AND rel_cc_vs_productos.id_producto=prodxmov.id_prod
			AND cat_cuentas.id_cuenta=rel_cc_vs_productos.id_cc
			AND mov_almacen.almacen IN (1,48,77)
			AND  (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			AND mov_almacen.asociado='$id_centro_costo'
			
			AND mov_almacen.fecha BETWEEN '2011-08-01' AND '2011-08-31'	
			
		GROUP BY  cat_cuentas.cuenta	
		ORDER BY cat_cuentas.a ASC, cat_cuentas.b ASC, cat_cuentas.c ASC, cat_cuentas.d ASC
		";	
		if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
			//echo "<br>NDR=".
			$ndr1=mysql_num_rows($res_1);
			if ($ndr1>0){
				$color="#FFFFFF";
				/*
				while ($reg_1=mysql_fetch_array($res_1)){
					echo "<br><br>";	print_r($reg_1);
					$total_consumo+=$reg_1["subtotal"];
				}
				*/
			}else{ die("<br>Sin resultados"); }
		}else{ die("<br>Error SQL : <br>".mysql_error($link)); }								
		
		// EMPIEZA EL GRAFICO ...
		$datos_grafica_swf="";
			$datos_grafica_swf.="<chart palette='2' showBorder='0' formatNumberScale='0'  numberPrefix='$' >";			
	
		
		?>
		<h3 align="center">Desglose de Consumo Abril. (<?=date("Y")?>)</h3>
		<h4 align="center" onclick="ajax('div_cc_C','ac=listar_consumo_resumen_CC_del_CdC&id_centro_costo=<?=$id_centro_costo?>')" style="color:#0000FF; cursor:pointer; ">
			<?=$id_centro_costo?> &rarr;  
			&quot; <?=$this->dame_no_resultados("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$id_centro_costo."' LIMIT 1; ")?> &quot; 
		</h4>
		<div id="div_graficaX" align="center">&nbsp;</div> 
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
			<th align="right" colspan="2">Total $ &rarr;</th>
			<th align="right"><?=number_format($total_consumo,2,".",",")?></th>
		</tr>
		</table><br />
		<div align="center">
			<a href="vistas_impresion/consumo_x_cc_cc1.php?id_cc=<?=$id_centro_costo?>" target="_blank">vista de impresi&oacute;n</a> | 
			<a href="xls/consumo_anual_x_centro_costo.php?id_cc=<?=$id_centro_costo?>">exportar a M. Excel</a> | 
			<a href="#" onclick="ajax('div_detalle_x_productoX','ac=listar_consumo_detalle_CC_del_CdC&id_centro_costo=<?=$id_centro_costo?>')">ver detalle &darr; </a>
		</div>
		<?php
		$datos_grafica_swf.="</chart>";
		?>
		<script type="text/javascript">
			  //var myChart = new FusionCharts("swf/Doughnut3D.swf", "myChartId", "800", "270", "0", "0");
			  var myChart = new FusionCharts("swf/Pie3D.swf", "myChartId", "800", "400", "0", "0");
			  myChart.setDataXML("<?=$datos_grafica_swf?>");		   
			  myChart.render("div_graficaX");
		</script>		
		<div id="div_detalle_x_productoX">&nbsp;</div> 
		
		
		<?php			
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