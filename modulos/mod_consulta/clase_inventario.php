<?php
class inventario{
	var $lista_campos1;
	var $status1;
	var $campo_clave;
	var $sql_where1;
	
	var $m_status;
	var $m_colores;	
	
	function __construct(){
		$this->campo_clave='`id`';
		$this->lista_campos1=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`ubicacion`,`linea`,`status1`,`activo`";
		$status1=array('Uso Constante','Lento Movimiento','Obsoleto');
		$this->m_status=array('<span style="color:#006600; ">Uso Constante</span>','<span style="color:#0033FF; ">Lento Movimiento</span>','<span style="color:#ff0000; ">Obsoleto</span>');
		$this->m_colores=array('006600','0033FF','ff0000','00cc00','efefef');		
	}
	
	function obtener_lineas(){
		include ("../../conf/conectarbase.php");
		$sql="SELECT id_linea, linea, descripcion FROM lineas ORDER BY id_linea; ";
		if ($res=mysql_query($sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				while($reg=mysql_fetch_array($res)){
					//echo "<br>"; 	print_r($reg);
					//return $reg[0];
					?>
					<script language="javascript">
					m_lineas_0.push('<?=$reg["linea"]?>');
					m_lineas_1.push('<?=substr($reg["descripcion"],0,25)?>');
					</script>
					<?php
				}
			}else{ die ("<h3 align='center'> Sin resultados </h3>"); }
		} else{ die ("<h3 align='center'> Error SQL (".mysql_error($link)."). </h3>");	}	
		
		$sql="SELECT DISTINCT(especificacion) as modeloX FROM catprod WHERE linea='NX' AND length(control_alm)<4 ORDER BY especificacion; ";
		if ($res=mysql_query($sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				while($reg=mysql_fetch_array($res)){
					//echo "<br>"; 	print_r($reg);
					//return $reg[0];
					
					?>
					<script language="javascript">
					m_nextel_modelos.push('<?=trim($reg["modeloX"])?>');
					</script>
					<?php
					
				}
			}else{ die ("<h3 align='center'> Sin resultados </h3>"); }
		} else{ die ("<h3 align='center'> Error SQL (".mysql_error($link)."). </h3>");	}				
	}	
	
	
	
	function listar_productos($linea,$campo,$operador,$criterio,$orden,$ascdes,$no_pagina){
		//echo "<hr>listar_productos($linea,$campo,$operador,$criterio,$orden,$ascdes,$no_pagina)";
		include ("../../conf/conectarbase.php");
		// ALMACENES ...
		$m_almacenes_ids=array();
		$m_almacenes_des=array();
		$m_almacenes_cex=array();
		$m_almacenes_cex_texto='';
		$sql_c_costo="SELECT id_almacen,almacen FROM tipoalmacen WHERE activo='1' AND es_almacen='1' ORDER BY id_almacen";
		if ($res_c_costo=mysql_query($sql_c_costo,$link)){ 
			$ndr_c_costo=mysql_num_rows($res_c_costo);
			if($ndr_c_costo>0){	
				
				while ($reg_c_costo=mysql_fetch_array($res_c_costo)){
					//echo "<br>"; 	print_r($reg_c_costo);
					$id_almacenX=$reg_c_costo["id_almacen"];
					$almacen=$reg_c_costo["almacen"];
					array_push($m_almacenes_ids,$id_almacenX);
					array_push($m_almacenes_des,$almacen);
					array_push($m_almacenes_cex,'exist_'.$id_almacenX);
					($m_almacenes_cex_texto=='')?$m_almacenes_cex_texto='`exist_'.$id_almacenX.'`':$m_almacenes_cex_texto.=', `exist_'.$id_almacenX.'`';
				}
					
			}else{ die("<h3>Sin resultados.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error().").</h3>"); }					
		/*
		echo "<br>"; 	print_r($m_almacenes_cex);		
		echo "<br>".$m_almacenes_cex_texto;			
		*/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Armar la condicion ...
			// Operador ...
			($operador=='LIKE')?$campo_operador_criterio=" $campo $operador '%$criterio%' ":$campo_operador_criterio=" $campo $operador '$criterio' ";
			
			
			/*
			// Asociado al Almacen ...
			$almacen_descripcion=$this->dame_primer_campo("SELECT almacen FROM tipoalmacen WHERE id_almacen='$id_almacen' LIMIT 1; ");
			$campo_almacen="a_".$id_almacenX."_$almacen_descripcion";
			$campo_existencias="exist_".$id_almacenX;	
			$campo_transferencias="trans_".$id_almacenX;
			*/
			
			
			
			
			
			//$sql_where_almacen=" `$campo_almacen`='1' ";
				// Agregamos los campos ex y TR a la lista de campos ...
				//$this->lista_campos1.=" `$campo_existencias`,`$campo_transferencias` ";
		// AND $sql_where_almacen
		$this->sql_where1=" WHERE activo='1' AND linea LIKE '%$linea%'  AND $campo_operador_criterio";
		// Obtener el no_resultados (no_productos activos)...
		//echo "<br>".
		$sql="SELECT ".$this->campo_clave." FROM catprod ".$this->sql_where1." ; ";
		//echo "<br>NDR=".
		$no_productos1=$this->dame_no_resultados($sql);

		// Armar la Paginacion ...
		$tamano_pagina=20; 
		$limite_inferior=($no_pagina-1)*$tamano_pagina; 
		$numero_paginas=ceil($no_productos1/$tamano_pagina); 		
		
		if($no_pagina==1){
			$inicio=1; 
			$final=$tamano_pagina; 
		}else{
			$seccion_actual=intval(($no_pagina-1)/$tamano_pagina); 
			$inicio=($seccion_actual*$tamano_pagina)+1; 
			($numero_paginas<$numero_paginas)?$final=$inicio+$tamano_pagina-1:$final=$numero_paginas; 
			if ($final>$numero_paginas) $final=$numero_paginas; 
		}		

		//echo "<br><br>".
		$sql2="SELECT ".$this->lista_campos1.",$m_almacenes_cex_texto FROM catprod ".$this->sql_where1." ORDER BY `$orden` $ascdes LIMIT ".$limite_inferior.",".$tamano_pagina." ; ";
		//echo "<br>NDR2=".
		$no_productos2=$this->dame_no_resultados($sql2);
		
		// Mostrar los productos ...
			?><div id="div_inventario1"><?php			
			
				// Encabezado ...
				/*
				?>
				<h3>Inventario IQ.</h3>
				<?php
				*/
				// Tabla ...
				//numeroX,linea,operador,orden,asc_desc,mi_valor,elEvento
				?>
				<div id="div_tabla_resultados" style="font-size: 10px;">
					<!--<div id="div_tabla_resultados_buscador">
						Producto <input type="text" id="txt_buscador_criterio" onkeyup="busca_producto1(1985,'<?=$linea?>','<?=$operador?>','<?=$orden?>','<?=$ascdes?>')" />
						<!--<input type="text" id="txt_buscador_criterio" onkeyup="busca_producto1(1985,'<?=$linea?>','<?=$operador?>','<?=$orden?>','<?=$ascdes?>',this.value,event)" />-->
					<!--</div>-->
					
					<table align="center" cellpadding="3" cellspacing="0" width="99%" style="font-size:10px;">
					<!--
					<tr>
					  <th colspan="8" onclick="" style="background-color:#fff;">Almac&eacute;n : </th>
					  </tr>
					//-->
					<tr class="campos_titulo_001">
<th class="campo_tituloX" title="Ordenar por &laquo; id &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','id','<?=$ascdes?>',<?=$no_pagina?>)">id</th>
<!--<th class="campo_tituloX" title="Ordenar por &laquo; clave &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','id_prod','<?=$ascdes?>',<?=$no_pagina?>)">clave</th>//-->
<th class="campo_tituloX" title="Ordenar por &laquo; descripcion &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','descripgral','<?=$ascdes?>',<?=$no_pagina?>)">descripci&oacute;n</th>
<th class="campo_tituloX" title="Ordenar por &laquo; especificacion &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','especificacion','<?=$ascdes?>',<?=$no_pagina?>)">especificaci&oacute;n</th>
<th class="campo_tituloX" title="Ordenar por &laquo; control_alm &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','control_alm','<?=$ascdes?>',<?=$no_pagina?>)">control_alm</th>

<!--
<th class="campo_tituloX" title="Ordenar por &laquo; status &raquo; " onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','status1','<?=$ascdes?>',<?=$no_pagina?>)">status</th>
//-->
						
						<?php
						//$m_colores=array('#0066CC','#0099CC','#0033FF','#0066FF','#0099FF','#0000FF','#00CCFF','#00FFFF','#cccccc'); bgcolor="'.$m_colores[$i].'"
						for($i=0;$i<count($m_almacenes_ids);$i++){
							echo '<th class="campo_tituloX"  title="Ordenar por : existencias del almac&eacute;n &laquo; '.$m_almacenes_ids[$i].' '.$m_almacenes_des[$i].' &raquo; "  
							onClick="paginar(\''.$linea.'\',\''.$campo.'\',\''.$operador.'\',\''.$criterio.'\',\'exist_'.$m_almacenes_ids[$i].'\',\''.$ascdes.'\','.$no_pagina.')"> '.substr($m_almacenes_des[$i],0,5).'</th>';
						}
						/*
		$m_almacenes_ids=array();
		$m_almacenes_des=array();
		$m_almacenes_cex=array();
		$m_almacenes_cex_texto='';						
						*/
						?>
						<!--
						<th class="campo_tituloX" title="Ordenar por &laquo; exist &raquo; ">exist.</th>
						<th class="campo_tituloX" title="Ordenar por &laquo; trans &raquo; ">trans.</th>
						//-->
					</tr>
					<?php
					if ($res=mysql_query($sql2,$link)){ 
						$ndr=mysql_num_rows($res);
						if($ndr>0){	
							while($reg=mysql_fetch_array($res)){
								//echo "<br>"; 	print_r($reg);
								?>
								<tr onMouseOver="this.style.background='#D9FFB3'" onMouseOut="this.style.background='#ffffff'" style="cursor:pointer;font-size: 10px;" onClick="ver_detalle_producto(<?=$reg["id"]?>)">
									<td align="center"><?=$reg["id"]?></td>
									<!--<td><?=$reg["id_prod"]?></td>//-->
									<td><?=$reg["descripgral"]?></td>
									<td><?=$reg["especificacion"]?></td>
									<td><?=$reg["control_alm"]?></td>
									<!--
									<td><?=$this->m_status[$reg["status1"]]?></td>
									
									<td align="right"><?=$reg["$campo_existencias"]?></td>
									<td align="right"><?=$reg["$campo_transferencias"]?></td>
									//-->
									<?php			
									for($i=0;$i<count($m_almacenes_ids);$i++){
										echo '<td align="right">'.$reg['exist_'.$m_almacenes_ids[$i]].'</td>';
									}						
									?>
								</tr>
								<?php
							}
						}else{ return " "; }
					} else{ die ("<br>Error SQL (".mysql_error($link).").");	}						
					?>
					</table>
				</div>
				<?php
				
				// Paginador ...
				?>
				<div id="div_paginacion">
					<div id="div_paginacion1">
						l&iacute;nea (<span id="spa_lin"><?=$linea?></span>) 
						campo (<span id="spa_cam"><?=$campo?></span>) 
						operador (<span id="spa_ope"><?=$operador?></span>) 
						criterio (<span id="spa_cri"><?=$criterio?></span>) 
						orden (<span id="spa_ord"><?=$orden?></span>)(<span id="spa_aod"><?=$ascdes?></span>) 
						<?=$no_productos1?> resultado(s) 
						<span id="spa_camposX" style="display:none;"><?=$this->lista_campos1.",".$m_almacenes_cex_texto?></span>
					</div>
					
					<div id="div_paginacion3">
						<div class="paginacion_boton" id="btn_0" onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','<?=$orden?>','<?=$ascdes?>',1)"> |&lt; </div>
						<div class="paginacion_boton" id="btn_1" onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','<?=$orden?>','<?=$ascdes?>',<?=$no_pagina-1?>)"> &lt; </div>
							<div class="paginacion_boton">
								<input type="text" value="<?=$no_pagina?>" id="txt_no_pgina" maxlength="5" onKeyUp="ir_a_pagina('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','<?=$orden?>','<?=$ascdes?>',<?=$numero_paginas?>,0,this.value,<?=$numero_paginas?>,event)">
							</div>
						<div class="paginacion_boton" id="btn_2" onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','<?=$orden?>','<?=$ascdes?>',<?=$no_pagina+1?>)"> &gt; </div>
						<div class="paginacion_boton" id="btn_3" onClick="paginar('<?=$linea?>','<?=$campo?>','<?=$operador?>','<?=$criterio?>','<?=$orden?>','<?=$ascdes?>',<?=$numero_paginas?>)"> &gt|</div>
					</div>	
					<div id="div_paginacion2"><?=$no_pagina?> / <?=$numero_paginas?> p&aacute;gina(s)</div>
				</div>
				<?php
				// Deshabilitar botones de navegacion de cauerdo al numero de pagina ...
				if($no_pagina<=1){
					// Deshabilita boton 0 y 1 ...
					?><script language="javascript">
						$("#btn_0").attr("onClick","");
						$("#btn_1").attr("onClick","");
					</script><?php
				}
				if($no_pagina>=$numero_paginas){
					// Deshabilita boton 2 y 3 ...
					?><script language="javascript">
						$("#btn_2").attr("onClick","");
						$("#btn_3").attr("onClick","");
					</script><?php
				}				
			?><div><?php			
		if($numero_paginas<=1){
			?><script language="javascript">
				$("#div_paginacion2").hide();
				$("#div_paginacion3").hide();
			</script><?php
		}
	}
	function ver_producto_detalle($id_producto,$que){
		//echo "<br>ver_producto_detalle($id_producto,$que)";
		/*
		if($que=='propiedades'){
			include("clase_producto.php");
			$p1=new producto($id_producto);
		}
		*/
		if($que=='propiedades'){
			include("clase_producto.php");
			$p1=new producto();
			$p1->ver_propiedades($id_producto);
		}
		if($que=='existencias'){
			include("clase_producto.php");
			$p1=new producto();
			$p1->existencias($id_producto);
		}				
		
		if($que=='kardex'){
			include("clase_kardex.php");
			$k1=new kardex($id_producto);
		}
		if($que=='comportamiento'){
			include("clase_comportamiento.php");
			$c1=new comportamiento($id_producto);
		}
	}
	
	
	// =======================================
	function dame_no_resultados($sql){
		include ("../../conf/conectarbase.php");
		if ($res=mysql_query($sql,$link)){ 
			return mysql_num_rows($res);
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}
	function dame_primer_campo($sql){
		include ("../../conf/conectarbase.php");
		if ($res=mysql_query($sql,$link)){ 
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