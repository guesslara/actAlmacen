<?php
	
class cc{
	var $bd_2011='2013_iqe_inv';
	function cuenta_cc_insertar($cue,$a,$b,$c,$d,$des,$obs){
		//echo "<br>cuenta_cc_insertar($cue,$a,$b,$c,$d,$des,$obs)";
		include ("../conf/conectarbase.php");
			// Averiguar que el producto NO este asociado.
			$sql="SELECT * FROM cat_cuentas WHERE cuenta='$cue' OR (a='$a' AND b='$b' AND c='$c' AND d='$d') OR descripcion='$des'; ";
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				(mysql_num_rows($res)>0)?$cc_existe=true:$cc_existe=false;
			}else die("<br>Error SQL : <br>".mysql_error($link));			
			
			if(!$cc_existe){
				$sql1="INSERT INTO cat_cuentas(id_cuenta,activo,tipo_cuenta,cuenta,a,b,c,d,descripcion,obs) VALUES 
				(NULL,'1','0','$cue','$a','$b','$c','$d','$des','$obs'); ";
				//echo "<br>* $id_productoX -> $sql";
				if(mysql_db_query($this->bd_2011,$sql1,$link)){
					++$items_insertados;
				}else die("<br>Error SQL : <br>".mysql_error($link));
			}else{
				//die ("<br> &nbsp; &rarr; La Cuenta : $cue - $des,  YA existe. ");
				?>
				<p align="center">
					<h3 align="center"><br> &nbsp; &rarr; La Cuenta : <br /><br /><?=$cue?> - <?=$des?> <br /><br /> YA existe.<br /></h3>
					<p align="center"><br /><br /><a href="#" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide();">cerrar</a></p>
				</p>
				<?php
				exit;				
			}	
		//echo "<br>no_items : $no_elementos <br> Insertados : $items_insertados";
		if($items_insertados==1){
			?>
			<p align="center">
				<script language="javascript">
					ajax('div_cc_C','ac=listar_CC');
				</script>
				<h3 align="center">La Cuenta (<?=$cue?>) fue insertada correctamente.</h3>
				<p align="center"><a href="#" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide();">cerrar</a></p>
			</p>
			<?php
		}else{
			?>
			<p align="center">
				<script language="javascript">
					ajax('div_cc_C','ac=listar_CC');
				</script>
				<h3 align="center">Se encontraron errores durante el proceso.</h3>
				<p align="center"><a href="#" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide();">cerrar</a></p>
			</p>
			<?php		
		}		
	}
	function listar(){
		//echo "<br>listar()";
		?>
		<h3 align="center" onClick="ajax('div_cdnds_mainB1','ac=listar_CC')">Catalogo de Cuentas </h3>
		<?php		
		include ("../conf/conectarbase.php");
		//echo "<hr><br>".
		$sql="SELECT * FROM cat_cuentas ORDER BY a,b,c,d; ";
		if($res=mysql_db_query($this->bd_2011,$sql,$link)){
			//echo "<br>NDR=".
			$ndr=mysql_num_rows($res);
			if($ndr>0){
				?>
				<table align="center" width="98%" cellpadding="2" cellspacing="0">
				<tr>
					<!--<th>id</th>//-->
					<th>cuenta <a href="#" id="hip_ncc" title="Agregar Cuenta Contable" onClick="nuevo_cc()">+</a></th>
					<th>A</th>
					<th>B</th>
					<th>C</th>
					<th>D</th>
					<th>descripcion</th>
					<th>obs</th>
				</tr>
				<tr id="tr_cc_nueva">
					  <!--<td>#</td>//-->
					  <td><input type="text" id="txt_cc" disabled="disabled"></td>
					  <td><input type="text" id="txt_ccA" maxlength="4" onKeyUp="tecla_X(1,event)"></td>
					  <td><input type="text" id="txt_ccB" maxlength="3" onKeyUp="tecla_X(2,event)"></td>
					  <td><input type="text" id="txt_ccC" maxlength="3" onKeyUp="tecla_X(3,event)"></td>
					  <td><input type="text" id="txt_ccD" maxlength="3" onKeyUp="tecla_X(4,event)"></td>
					  <td align="left"><input type="text" id="txt_ccDES" onKeyUp="tecla_X(5,event)"></td>
					  <td align="left">
					  	<input type="text" id="txt_ccOBS" onKeyUp="tecla_X(6,event)"> 
						<a href="#" title="Cancelar" onClick="nuevo_cc_cancelar()">&times;</a>
						<a href="#" title="Guardar" onClick="nuevo_cc_guardar()">&radic;</a>
						
					  </td>
				</tr>				
				<?php
				while($reg=mysql_fetch_array($res)){
					//echo "<br>";	print_r($reg);
					//cuenta_cuenta 	cuenta_subcta 	cuenta_auxcta
					/*
					$cuenta=$reg["cuenta"];
						$cuenta_tipo=substr($cuenta,0,4);
						$cuenta_cuenta=substr($cuenta,5,3);
						$cuenta_subcta=substr($cuenta,9,3);
						$cuenta_auxcta=substr($cuenta,13,3);
					$sql2="UPDATE cat_cuentas SET cuenta_tipo='$cuenta_tipo' WHERE id_cuenta='".$reg["id_cuenta"]."';  ";
					$sql3="UPDATE cat_cuentas SET cuenta_cuenta='$cuenta_cuenta' WHERE id_cuenta='".$reg["id_cuenta"]."';  ";
					$sql4="UPDATE cat_cuentas SET cuenta_subcta='$cuenta_subcta' WHERE id_cuenta='".$reg["id_cuenta"]."';  ";
					$sql5="UPDATE cat_cuentas SET cuenta_auxcta='$cuenta_auxcta' WHERE id_cuenta='".$reg["id_cuenta"]."';  ";	
					mysql_db_query($this->bd_2011,$sql5,$link) or die("<br>Error SQL : <br>".mysql_error($link));
					*/
					($reg["c"]=='000')?$style='font-weight:bold; color:#0000FF;':$style='font-weight:normal; color:#000;';
					?>
					<tr style=" text-align:center; <?=$style?>">
					  <!--<td>&nbsp;<?=$reg["id_cuenta"]?></td>//-->
					  <td>&nbsp;<?=$reg["cuenta"]?></td>
					  <td>&nbsp;<?=$reg["a"]?></td>
					  <td>&nbsp;<?=$reg["b"]?></td>
					  <td>&nbsp;<?=$reg["c"]?></td>
					  <td>&nbsp;<?=$reg["d"]?></td>
					  <td align="left">&nbsp;<?=$reg["descripcion"]?></td>
					  <td align="left">&nbsp;<?=$reg["obs"]?></td>
					</tr>					
					<?php
				}
				?></table>
<?php				
			}else{ die("<br>Sin resultados"); }
		}else{ die("<br>Error SQL : <br>".mysql_error($link)); }					
	}
		function listar_cc_asociar(){
			?>
			<h3 align="center">Catalogo de Cuentas </h3>
			<?php		
			include ("../conf/conectarbase.php");
			//echo "<hr><br>".
			$sql="SELECT * FROM cat_cuentas ORDER BY id_cuenta; ";
			if($res=mysql_db_query($sql_db,$sql,$link)){
				//echo "<br>NDR=".
				$ndr=mysql_num_rows($res);
				if($ndr>0){
					?>
					<table align="center" width="98%" cellpadding="2" cellspacing="0">
					<tr>
					  <th>&nbsp;</th>
						<th>id</th>
						<th>cuenta</th>
						<th>descripcion</th>
					</tr>
					<?php
					while($reg=mysql_fetch_array($res)){
						($reg["c"]=='000')?$style='font-weight:bold; color:#0000FF;':$style='font-weight:normal; color:#000;';
						?>
						<tr style=" text-align:center; <?=$style?>">
						  <td align="center"><input type="radio" name="rad_cc" value="<?=$reg["id_cuenta"]?>" /></td>
						  <td>&nbsp;<?=$reg["id_cuenta"]?></td>
						  <td>&nbsp;<?=$reg["cuenta"]?></td>
						  <td align="left">&nbsp;<?=$reg["descripcion"]?></td>
						</tr>					
						<?php
					}
					?></table>
	<?php				
				}else{ die("<br>Sin resultados"); }
			}else{ die("<br>Error SQL : <br>".mysql_error($link)); }		
		}
	
	function listar_productos_lineas(){
		?>
		<style type="text/css">
		#div_asociacion_p_cc{ position:relative; width:100%; height:100%; background-color:#999999; margin:0px;}
			#div_asociacion_p_cc1{ position:relative; width:50%; height:100%; float:left; clear:left; background-color:#fff; margin:0px; overflow:auto; }
			#div_asociacion_p_cc2{ position:relative; width:50%; height:100%; float:left; clear:right; background-color:#fff; margin:0px; overflow:auto;}
			
		</style>
		<div id="div_asociacion_p_cc">
			<div id="div_asociacion_p_cc1">
				<?php $this->listar_lineas(); ?>
			</div>
			<div id="div_asociacion_p_cc2">
				<?php $this->listar_cc_asociar(); ?>
			</div>
		</div>
		
		
		
		
		<?php		
		exit;
	}
		function listar_lineas(){
			?><h3 align="center" onClick="ajax('div_cc_C','ac=listar_productos_x_linea')">Catalogo de Lineas de productos </h3><?php
			include ("../conf/conectarbase.php");
			//echo "<hr><br>".
			$sql="SELECT * FROM lineas ORDER BY id_linea; ";
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				//echo "<br>NDR=".
				$ndr=mysql_num_rows($res);
				if($ndr>0){	
					?>
					<table align="center" cellpadding="2" cellspacing="0" width="99%">
					<tr>
						<th>id_linea</th>
						<th>prefijo</th>
						<th>descripci&oacute;n</th>
					</tr>
					<?php
					while($reg=mysql_fetch_array($res)){
						//echo "<br>";	print_r($reg);
						?>
						<tr onclick="linea_productos('<?=$reg["linea"]?>')" onmouseover="this.style.background='#efefef'" onmouseout="this.style.background='#ffffff'" style="cursor:pointer;">
							<td align="center"><?=$reg["id_linea"]?></td>
							<td align="center"><?=$reg["linea"]?></td>
							<td><?=$reg["descripcion"]?></td>
						</tr>
						<?php	
					}
					?>
					</table>
					<h4 align="center">Seleccione una linea &uarr;</h4>
					<?php	
				}else{ die("<br>Sin resultados"); }
			}else{ die("<br>Error SQL : <br>".mysql_error($link)); }			
		}
		function listar_productos_x_lineaX($linea,$criterio){
			//echo "<br>listar_productos_x_lineaX($linea)";
			?>
			<h3 align="center" onClick="linea_productos('<?=$linea?>')">Cat&aacute;logo de productos</h3>
			
			<?php
			
			include ("../conf/conectarbase.php");
			/*
			//echo "<hr><br>".
			
			$sql="SELECT id, id AS idpX, id_prod,descripgral,especificacion,linea FROM catprod 
			WHERE linea='$linea' AND activo=1 AND descripgral LIKE '%$criterio%'
				AND id NOT IN (SELECT rel_cc_vs_productos.id FROM rel_cc_vs_productos,catprod WHERE rel_cc_vs_productos.id=idpX )
			; ";
			
			
			$sql="SELECT id, id AS idpX, id_prod,descripgral,especificacion,linea FROM catprod 
			WHERE linea='$linea' AND activo=1 AND descripgral LIKE '%$criterio%'
				AND id NOT IN (SELECT rel_cc_vs_productos.id FROM rel_cc_vs_productos,catprod  )			
			; ";
			*/
			//echo "<br>SQL=".
			$sql="SELECT 
				catprod.id, catprod.id_prod, catprod.descripgral, catprod.especificacion, catprod.linea,
				rel_cc_vs_productos.id_producto, COUNT(rel_cc_vs_productos.id_producto) AS no_coincidencias 
			FROM catprod
				LEFT JOIN rel_cc_vs_productos ON catprod.id=rel_cc_vs_productos.id_producto 
			WHERE 
				catprod.linea='$linea' 
				AND catprod.activo=1 
				AND catprod.descripgral LIKE '%$criterio%'
			GROUP BY catprod.id
			HAVING no_coincidencias=0				
			; ";			
			
			//	AND id NOT IN (SELECT rel_cc_vs_productos.id FROM rel_cc_vs_productos,catprod  )	HAVING no_veces_encontrados<1	
			/*
			HAVING rel_cc_vs_productos.id_producto<1
			HAVING rel_cc_vs_productos.id_producto=NULL	
			
			HAVING rel_cc_vs_productos.id_producto<>catprod.id	
			AND (rel_cc_vs_productos.id_producto=NULL OR rel_cc_vs_productos.id_producto='')
			*/
			
					
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				//echo "<br>NDR=".
				$ndr=mysql_num_rows($res);
				if($ndr>0){	
					
					?>
					<div align="center" style="text-align:center; font-weight:bold; ">L&iacute;nea : <?=$linea?> ( <?=$ndr?> resultados) </div>
					<form name="frm_productos_x_linea">
					<p align="center">
						<input type="button" id="btn_sel_all" value="Seleccionar Todo" onclick="seleccionar_todos_los_productos(); " />
						<input type="reset" id="btn_lim_all" value="Limpiar Todo" style="display:none;" onclick="$('#btn_sel_all').show();
		$('#btn_lim_all').hide();" />
						<input type="button" value="Asociar a Cuenta" onclick="fn_asociar_productos_a_cc()" />
					</p>
					<div id="div_asociacion_resultados">...</div>					
					<table align="center" cellpadding="2" cellspacing="0" width="99%">
					<tr>
						<th>&nbsp;</th>
						<th>id</th>
						<th>clave</th>
						<th>descripcion</th>
						<th>especificacion</th>
						<th>linea</th>
					</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td align="center"><input type="text" id="txt_criterio_descripcion" onkeyup="tecla_X('<?=$linea?>',event)" /> <a href="#" onclick="buscar_en_catalogo('<?=$linea?>')">buscar</a></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>					
					<?php
					
					while($reg=mysql_fetch_array($res)){
						//echo "<br><hr>";	print_r($reg);
						
						?>
						<tr>
							<td><input type="checkbox" value="<?=$reg["id"]?>" /></td>
							<td>&nbsp;<?=$reg["id"]?></td>
							<td><?=$reg["id_prod"]?></td>
							<td><?=$reg["descripgral"]?></td>
							<td>&nbsp;<?=$reg["especificacion"]?></td>
							<td align="center"><?=$reg["linea"]?></td>
						</tr>
						<?php
						
					}
					
					
					?></table>
					</form><?php					
					
				}else{ die("<br><h4>&nbsp; &rarr; Sin resultados</h4>"); }
			}else{ die("<br>Error SQL : <br>".mysql_error($link)); }							
		}
	function asociar_prods_a_cc($id_cc,$prods){
		//echo "<br>asociar_prods_a_cc($id_cc,$prods)";
		include ("../conf/conectarbase.php");
		$m_productos=explode(',',$prods);
		$no_elementos=count($m_productos);
		//print_r($m_productos);
		foreach($m_productos as $id_producto){
			$id_productoX=trim($id_producto);
			// Averiguar que el producto NO este asociado.
			$sql="SELECT * FROM rel_cc_vs_productos WHERE id_producto='$id_productoX'; ";
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				(mysql_num_rows($res)>0)?$producto_existe=true:$producto_existe=false;
			}else die("<br>Error SQL : <br>".mysql_error($link));			
			
			if(!$producto_existe){
				$sql1="INSERT INTO rel_cc_vs_productos(id,id_cc,id_producto) VALUES (NULL,'$id_cc','$id_productoX'); ";
				//echo "<br>* $id_productoX -> $sql";
				if(mysql_db_query($this->bd_2011,$sql1,$link)){
					++$items_insertados;
				}else die("<br>Error SQL : <br>".mysql_error($link));
			}else{
				echo "<br> &nbsp; &rarr; El producto : $id_productoX ya esta asociado a una Cuenta Contable. ";
			}	
		}
		//echo "<br>no_items : $no_elementos <br> Insertados : $items_insertados";
		if($no_elementos==$items_insertados){
			?>
			<p align="center">
				<script language="javascript">
					ajax('div_cc_C','ac=listar_productos_x_linea');
				</script>
				<h3 align="center"><?=$items_insertados?> producto(s) fueron asociados correctamente.</h3>
				<p align="center"><a href="#" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide();">cerrar</a></p>
			</p>
			<?php
		}else{
			?>
			<p align="center">
				<script language="javascript">
					ajax('div_cc_C','ac=listar_productos_x_linea');
				</script>
				<h3 align="center">Se encontraron errores.</h3>
				<p align="center"><a href="#" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide();">cerrar</a></p>
			</p>
			<?php		
		}
	}
	function listar_asociados(){
		?>
		<style type="text/css">
		#div_asociadosA{ position:relative; width:40%; height:100%; background-color:#fff; float:left; clear:left; overflow:auto; }
		#div_asociadosB{ position:relative; width:60%; height:100%; background-color:#fff; float:left; clear:rigth; overflow:auto; }
		</style>
		<div id="div_asociadosA"><?php $this->listar_cc_asociados(); ?></div>
		<div id="div_asociadosB"></div>
		<?php
		exit;
		echo "<br>listar_asociados()";
		
	}
		function listar_cc_asociados(){
			?>
			<h3 align="center">Cuentas Contables Asociadas</h3>
			<?php
			include ("../conf/conectarbase.php");
			$sql="SELECT 
					rel_cc_vs_productos.id_cc, count(rel_cc_vs_productos.id_producto) AS no_productos,
					cat_cuentas.id_cuenta, cat_cuentas.cuenta, cat_cuentas.descripcion 
				FROM rel_cc_vs_productos,cat_cuentas 
				WHERE 
					rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
					AND cat_cuentas.activo=1
				GROUP BY rel_cc_vs_productos.id_cc 
				ORDER BY rel_cc_vs_productos.id_cc; ";
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				$ndr=mysql_num_rows($res);
				if($ndr>0){
					?>
					<table align="center" width="98%" cellpadding="2" cellspacing="0">
					<tr>
						<th>cuenta</th>
						<th>descripci&oacute;n</th>
						<th>no_productos</th>
					</tr>
					<?php
					while($reg=mysql_fetch_array($res)){
						//echo "<br>";	print_r($reg);
						$total_productos+=$reg["no_productos"];
						?>
						<tr onclick="ajax('div_asociadosB','ac=ver_productos_asociados&id_cuenta=<?=$reg["id_cuenta"]?>&cuenta=<?=$reg["cuenta"]?>')" onmouseover="this.style.background='#efefef'" onmouseout="this.style.background='#ffffff'" style="cursor:pointer;">
							<td align="center"><?=$reg["cuenta"]?></td>
							<td><?=$reg["descripcion"]?></td>
							<td align="center"><?=$reg["no_productos"]?></td>
						</tr>
						<?php
					}
					?>
					<tr style="font-weight:bold; background-color:#efefef;" >
						<td colspan="2" align="right">Total  &rarr; </td>
						<td align="center"><?=$total_productos?> de <?=$this->dame_no_resultados("SELECT count(id) FROM catprod WHERE activo='1' ")?></td>
					</tr>
					</table><?php	
				}else{
					echo "<br> &nbsp;&rarr; Sin resultados.";
				}
			}else die("<br>Error SQL : <br>".mysql_error($link));		
		}
		function ver_productos_asociados($id_cuenta,$cuenta){
			//echo "<br>ver_productos_asociados($id_cuenta)";
			?>
			<h3 align="center">Productos Asociados a la Cuenta Contable : <?=$cuenta?> </h3>
			<?php
			include ("../conf/conectarbase.php");
			$sql="SELECT 
					rel_cc_vs_productos.id_producto,
					catprod.id, catprod.id_prod, catprod.descripgral, catprod.especificacion
				FROM rel_cc_vs_productos,catprod 
				WHERE 
					rel_cc_vs_productos.id_producto=catprod.id
					AND catprod.activo='1'
					AND rel_cc_vs_productos.id_cc='$id_cuenta'
				ORDER BY catprod.id; ";
			if($res=mysql_db_query($this->bd_2011,$sql,$link)){
				$ndr=mysql_num_rows($res);
				if($ndr>0){
					?>
					<table align="center" width="98%" cellpadding="2" cellspacing="0">
					<tr>
						<th>id_producto</th>
						<th>clave</th>
						<th>descripci&oacute;n</th>
						<th>especificaci&oacute;n</th>
					</tr>
					<?php
					while($reg=mysql_fetch_array($res)){
						//echo "<br>";	print_r($reg);
						?>
						<tr onmouseover="this.style.background='#efefef'" onmouseout="this.style.background='#ffffff'">
							<td align="center"><?=$reg["id_producto"]?></td>
							<td align="center"><?=$reg["id_prod"]?></td>
							<td><?=$reg["descripgral"]?></td>
							<td><?=$reg["especificacion"]?></td>
						</tr>
						<?php
					}
					?></table><?php	
				}else{
					echo "<br> &nbsp;&rarr; Sin resultados.";
				}
			}else die("<br>Error SQL : <br>".mysql_error($link));			
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
