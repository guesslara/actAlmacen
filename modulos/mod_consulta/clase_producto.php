<?php
class producto{
	var $lista_campos;
		var $status1;
	
	function __construct(){
		$this->m_status=array('<span style="color:#006600; ">Uso Constante</span>','<span style="color:#0033FF; ">Lento Movimiento</span>','<span style="color:#ff0000; ">Obsoleto</span>');
		$this->lista_campos="`id`,`id_prod`,`familia`,`subfamilia`,`especificaciones`,`no_parte_modelo`,`descripgral`, `especificacion`, `control_alm`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `activo`, `unidad`, `stock_min`, `linea`, `marca`, `observa`, `status1`, `tipo`, `kit` ";	
	
		//$this->ver_propiedades($id_producto);
	}
	function ver_propiedades($id_producto){
		//echo "<br>ver_propiedades($id_producto)";
		//echo "<br>".
		$sql="SELECT ".$this->lista_campos." FROM catprod WHERE id='".$id_producto."' LIMIT 1; ";
		include ("../../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				$reg=mysql_fetch_array($res);
					//echo "<br><br>"; 	print_r($reg);
			}else{ die("<h3>Sin resultados.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }		
		
		// Centros de Costos Asociado ...
		$m_cdc_asociados_ids=array();
		$m_cdc_asociados_des=array();
		$sql_c_costo="SELECT id_almacen,almacen FROM tipoalmacen WHERE activo='1' AND es_centro_costo='1' ORDER BY id_almacen";
		if ($res_c_costo=mysql_db_query($sql_db,$sql_c_costo,$link)){ 
			$ndr_c_costo=mysql_num_rows($res_c_costo);
			if($ndr_c_costo>0){	
				
				while ($reg_c_costo=mysql_fetch_array($res_c_costo)){
					//echo "<br>"; 	print_r($reg_c_costo);
					$id_almacen=$reg_c_costo["id_almacen"];
					$almacen=$reg_c_costo["almacen"];
					
					$campo_almacen="a_".$id_almacen."_".$almacen;
					$sql_existencias="SELECT $campo_almacen FROM catprod WHERE id='$id_producto' LIMIT 1; ";
					
					if ($res2=mysql_db_query($sql_db,$sql_existencias,$link)){ 
						$ndr2=mysql_num_rows($res2);
						if($ndr2>0){	
							
							while ($reg2=mysql_fetch_array($res2)){
								//echo "<br>"; 	print_r($reg2);
								$esta_asociado=$reg2["$campo_almacen"];
								if($esta_asociado){
									array_push($m_cdc_asociados_ids,$id_almacen);
									array_push($m_cdc_asociados_des,$almacen);
								}	
							}
								
						}else{ die("<h3>Sin resultados.</h3>"); }
					} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }						
					
				}
					
			}else{ die("<h3>Sin resultados.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }		
		
		
		
		?>
		<div id="div_caracteristicas">
		<div style="font-size:13pt; text-align:center; padding:3px; font-weight:bold;">Caracter&iacute;sticas </div>
		<table width="98%" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td width="20%" class="campo_vertical">id</td>
			<td width="30%"><input type="text" id="txt_id"  value="<?=$reg['id']?>" readonly="1" /></td>
			<td width="20%" class="campo_vertical">clave</td>
			<td width="30%"><input type="text" id="txt_clave"  value="<?=$reg['id_prod']?>" readonly="1" /></td>
		</tr>
		<tr>
		  <td class="campo_vertical">descripci&oacute;n</td>
		  <td><input type="text" id="txt_descripgral"  value="<?=$reg['descripgral']?>" readonly="1" /></td>
		  <td class="campo_vertical">especificaci&oacute;n</td>
		  <td><input type="text" id="txt_especificacion"  value="<?=$reg['especificacion']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">control_alm</td>
		  <td><input type="text" id="txt_control_alm"  value="<?=$reg['control_alm']?>" readonly="1" /></td>
		  <td class="campo_vertical">l&iacute;nea</td>
		  <td><input type="text" id="txt_linea"  value="<?=$reg['linea']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">marca</td>
		  <td><input type="text" id="txt_marca"  value="<?=$reg['marca']?>" readonly="1" /></td>
		  <td class="campo_vertical">unidad</td>
		  <td><input type="text" id="txt_unidad"  value="<?=$reg['unidad']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">uni_entrada</td>
		  <td><input type="text" id="txt_uni_entrada"  value="<?=$reg['uni_entrada']?>" readonly="1" /></td>
		  <td class="campo_vertical">uni_salida</td>
		  <td><input type="text" id="txt_uni_salida"  value="<?=$reg['uni_salida']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">stock_m&iacute;nimo</td>
		  <td><input type="text" id="txt_stock_min"  value="<?=$reg['stock_min']?>" readonly="1" /></td>
		  <td class="campo_vertical">stock_m&aacute;ximo</td>
		  <td><input type="text" id="txt_stock_max"  value="<?=$reg['stock_max']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">ubicaci&oacute;n</td>
		  <td><input type="text" id="txt_ubicacion"  value="<?=$reg['ubicacion']?>" readonly="1" class="txt_editar" /></td>
		  <td class="campo_vertical">status rotaci&oacute;n</td>
		  <td><?=$this->m_status[$reg['status1']]?></td>
		  </tr>
		<tr>
		  <td class="campo_vertical">observaciones</td>
		  <td colspan="3"><input type="text" id="txt_observa"  value="<?=$reg['observa']?>" readonly="1" /></td>
		  </tr>
		<tr>
		  <td class="campo_vertical" title="Centros de costos asociados al Producto">centro de costos</td>
		  <td colspan="3"><?php
		  		//echo "<br>";	print_r($m_cdc_asociados_ids);
				//echo "<br>";	print_r($m_cdc_asociados_des);
				for($i=0;$i<count($m_cdc_asociados_ids);$i++){
					?>
					<div class="cdc_asociado" onMouseOver="this.style.background='#D9FFB3'" onMouseOut="this.style.background='#ffffff'">
						<input type="text" style="width:200px; font-size:small; padding:1px; margin:0px;" value="<?=$m_cdc_asociados_ids[$i].". ".$m_cdc_asociados_des[$i]?>" readonly="1" />
					</div>
					<?php
				}
		  ?></td>
		  </tr>		  
		</table>
		<div style="text-align:center;">
			<script language="javascript">
			function fn_editar(){
				//alert("editar");
				$(".txt_editar").attr("readonly","");
				$(".txt_editar").css("border","green 1px solid");
				
				$("#btn_editar").hide();
				$("#btn_guardar").show();
			}
			function fn_editar_guardar(){
				var id=$("#txt_id").val();
				var ubicacion=$("#txt_ubicacion").val();
				var sql="UPDATE catprod SET ubicacion='"+ubicacion+"' WHERE id='"+id+"' LIMIT 1;";
				//alert("SQL="+sql);
				if(confirm(" Desea guardar los cambios realizados ?")){
					$("#div_editar_botones").hide();
					ajax('div_editar_resultados','ac=editar_guardar_sql&sql='+sql);
				}	
			}
			</script>
			<?php if($_SESSION["usuario_id"]==1||$_SESSION["usuario_id"]==2){ ?>
				<div align="center" id="div_editar_botones">
					<a href="#" onclick="fn_editar()" id="btn_editar">editar</a> | 
					<a href="#" onclick="fn_editar_guardar()" id="btn_guardar" style="display:none;">guardar</a>
				</div>
				<div align="center" id="div_editar_resultados" style="text-align:center; padding:2px; font-weight:bold; color:#009900;"></div>
			<?php } ?>
		</div>
		<br>
		</div>
		<!--
		<div align="center" class="botones_links_0">
			<a href="#" id="hip_existencias1" onClick="$('#div_existencias').show(); $('#div_proveedores').hide(); $('#div_caracteristicas').hide(); $('.botones_links_0').hide(); ">ver existencias </a> | 
			<a href="#" id="hip_existencias2" onClick="$('#div_existencias').hide(); $('#div_proveedores').show(); $('#div_caracteristicas').hide(); $('.botones_links_0').hide(); ">ver proveedores </a>
		</div>
		//-->
		
		<?php
		/*
		$sql_proveedores="SELECT * FROM prodxprov WHERE id_prod='$clave_producto' ORDER BY id_prod";
		if ($res3=mysql_db_query($sql_db,$sql_proveedores,$link)){ 
			$ndr3=mysql_num_rows($res3);
			if($ndr3>0){	
				
				while ($reg=mysql_fetch_array($res)){
					echo "<br>"; 	print_r($reg);
				}
					
			}else{ die("<h3>Sin resultados.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }
		*/		
		?>
		<!--
		<div id="div_proveedores" style="display:block;">
		<h3>Proveedores Asociados </h3>
		<table width="98%" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th width="8%">id</th>
			<th width="92%">proveedor</th>
		</tr>
		<?php 
		/*
		while ($reg3=mysql_fetch_array($res3)){ ?>
		<tr>
			<td align="center"><?=$reg3["id_prov"]?></td>
			<td>**********************************************</td>
		</tr>	
		<?php } */ ?>
		</table>
		</div>		
		//-->
		<br>				
		<?php
	}
	function existencias($id_producto){
		//echo "<br>existencias($id_producto)";
		include ("../../conf/conectarbase.php");
		
		$sql_almacen="SELECT id_almacen,almacen FROM tipoalmacen WHERE activo='1' AND es_almacen='1' ORDER BY id_almacen";
		if ($res_c_costo=mysql_db_query($sql_db,$sql_almacen,$link)){ 
			$ndr_c_costo=mysql_num_rows($res_c_costo);
			if($ndr_c_costo>0){	
				?>
				<h3>existencias</h3>
				<table align="center" width="95%" cellpadding="3" cellspacing="0">
				<tr>
					<th width="6%">id</th>
					<th width="67%">almac&eacute;n</th>
					<th width="13%">existencias</th>
					<th width="14%">transferencias</th>
				</tr>
				<?php
				while ($reg_c_costo=mysql_fetch_array($res_c_costo)){
					//echo "<br>"; 	print_r($reg_c_costo);
					
					
					
					
					$id_almacen=$reg_c_costo["id_almacen"];
					$almacen=$reg_c_costo["almacen"];
					$campo_existencias="exist_".$reg_c_costo["id_almacen"];
					$campo_transferencias="trans_".$reg_c_costo["id_almacen"];
					
					
					$campo_almacen="a_".$id_almacen."_".$almacen;
					//echo "<br>".
					$sql_existencias="SELECT $campo_existencias,$campo_transferencias FROM catprod WHERE id='$id_producto' LIMIT 1; ";
					
					if ($res2=mysql_db_query($sql_db,$sql_existencias,$link)){ 
						$ndr2=mysql_num_rows($res2);
						if($ndr2>0){	
							
							while ($reg2=mysql_fetch_array($res2)){
								//echo "<br>"; 	print_r($reg2);
								?>
								<tr onMouseOver="this.style.background='#D9FFB3'" onMouseOut="this.style.background='#ffffff'">
									<td align="center"><?=$id_almacen?></td>
									<td><?=$almacen?></td>
									<td align="right"><?=$reg2["$campo_existencias"]?></td>
									<td align="right"><?=$reg2["$campo_transferencias"]?></td>
								</tr>
								<?php
								/*
								$esta_asociado=$reg2["$campo_almacen"];
								if($esta_asociado){
									array_push($m_cdc_asociados_ids,$id_almacen);
									array_push($m_cdc_asociados_des,$almacen);
								}
								*/	
							}
								
						}else{ die("<h3>Sin resultados.</h3>"); }
					} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }						
					
				}
				?>
				</table>
				<?php					
			}else{ die("<h3>Sin resultados.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>"); }			
		
	}
	function editar_guardar_sql($sql){
		//echo "<br>editar_guardar_sql($sql)";
		include ("../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,stripslashes($sql),$link)){ 
			?>
			<script language="javascript"></script>
			Datos guardados correctamente.
			<?php
		} else{ die("<br>Error SQL (".mysql_error($link).").");	}		
		
		
	}
	
	// =======================================
	function dame_no_resultados($sql){
		include ("../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql,$link)){ 
			return mysql_num_rows($res);
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}
	function dame_primer_campo($sql){
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