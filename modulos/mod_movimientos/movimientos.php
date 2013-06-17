<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../conf/conectarbase.php");
	include ("clase_movimientos.php");
	include ("catalogo_errores.php");

	$actual=$_SERVER['PHP_SELF'];
	$color="#D9FFB3";
	//print_r($_POST);
	$ac=$_POST["accion"];
	
	if ($ac=="buscar_productos"){
		//print_r($_POST);
		$n_valor=$_POST["n_valor"];		
		$valores=split(',',$n_valor);
		foreach ($valores as $v){
			$valores2=explode('?',$v);
			
			//echo "<br>[".$valores2[0]."] [".$valores2[1]."]";
			if (!is_numeric($valores2[1])){
				echo "Error: El valor (".$valores2[1].") no es un numero.";
				exit;
			}
			$sql_datos="SELECT id, id_prod, descripgral, especificacion, cpromedio FROM catprod WHERE id=".$valores2[1];
			if ($resultado_datos=mysql_db_query($sql_db,$sql_datos)){
				while($registro_datos=mysql_fetch_array($resultado_datos)){
					//echo "<br>";	print_r($registro_datos);	
					echo "<script language='javascript'> coloca_producto1(".$registro_datos["id"].",'".$registro_datos["id_prod"]."','".$registro_datos["descripgral"]."','".$registro_datos["especificacion"]."','0',".$valores2[0]."); </script>";
				}
			} else {
				echo "Error SQL (sql_datos).";
				exit;			
			}
		}
	}
	if ($ac=="ver_asociados"){
		//echo "Asociado: ".
		$asociadoX=$_POST["a"];
		?>
		<div id="div_asociados2">
			<div class="tit1">
				<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASOCIADOS&nbsp;</span>
				<span class="cer_mov"><a href="javascript:cerrar('div_asociados2');">CERRAR</a>&nbsp;</span>
			</div>
			<br />			
			<?php
			$color="#D9FFB3";
			if ($asociadoX=="Proveedor")
			{
				$sql="SELECT id_prov,nr  FROM catprovee";
				$result=mysql_db_query($dbcompras,$sql);
				?>
<script language="javascript">
function numero_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas = tabla.rows.length;
	var numFilas2=parseInt(numFilas)-1;
	return(numFilas2);
}
function muestra_buscador(id_campo){
	mostrar_todas_filas('tbl_1');
	var no_campos=5;
	for(var i=0;i<no_campos;i++){	$("#txt_buscador"+i).hide();	}
	var valor_celda_input=$("#campo"+id_campo).html();
	if(valor_celda_input.indexOf("input")!=-1){ $("#txt_buscador"+id_campo).show(); }else{ $("#campo"+id_campo).append("<br><input type='text' id='txt_buscador"+id_campo+"' style='width:100px;' onkeyup='buscar("+id_campo+")'>"); }
	$("#txt_buscador"+id_campo).focus();	
}
function buscar(id_campo){
	//alert("buscar en el campo"+id_campo);
	var tabla = document.getElementById("tbl_1");
	var numFilas2=numero_filas('tbl_1');
	var criterio=$("#txt_buscador"+id_campo).attr("value");
	var crit_minusculas=criterio.toLowerCase();
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		var valor_celda=tabla.tBodies[0].rows[i].cells[id_campo].innerHTML;
		var valor_celda_minusculas=valor_celda.toLowerCase();			
		if (valor_celda_minusculas.indexOf(crit_minusculas)!=-1) { $("#tr_"+id).show(); }else{ $("#tr_"+id).hide(); }
	}
}
function mostrar_todas_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas2=numero_filas('tbl_1');
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		$("#tr_"+id).show();
	}
}
</script>				
				<br /><table id="tbl_1" align="center" width="98%" cellspacing="0">
				<tr>
					<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Proveedores</td>
				  </tr>		
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
					<td id="campo0" width="10%"><a href='#' onclick='muestra_buscador(0)'>ID</a></td>
					<td id="campo1" width="90%"><a href='#' onclick='muestra_buscador(1)'>Proveedor</a></td>
				</tr>
				<?php while($row=mysql_fetch_array($result)){ ?>
				<tr id="tr_<?=$row["id_prov"]?>" bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?=$row["id_prov"];?>','<?=$row["nr"];?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20"><?=$row["id_prov"]?></td>
					<td><?=$row["nr"]?></td>
				</tr>
				<?php 
					($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
				} ?>		
				</table><br />
				  <?php 
		  	} elseif ($asociadoX=="Ninguno") {
				?>
				<script language="javascript">
					coloca_proveedor1(0,0);
					$("#div_asociados2").hide();
				</script>
				<?php
				//exit();
			} elseif($asociadoX=="Cliente"){
				$sql="SELECT id_cliente,r_social  FROM cat_clientes";
				$result=mysql_db_query($sql_db,$sql);
				?>
				<br /><table align="center" width="98%" cellspacing="0" style="border:#333333 1px solid;">
				<tr>
					<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Cat&aacute;logo de Clientes.</td>
				  </tr>		
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
					<td width="10%" height="20">ID</td>
					<td width="90%">Cliente</td>
				</tr>
				<?php while($row=mysql_fetch_array($result)){ ?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?=$row["id_cliente"];?>','<?=$row["r_social"];?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20">&nbsp;<?=$row["id_cliente"];?></td>
					<td>&nbsp;<?=$row["r_social"];?></td>
				</tr>
				<?php 
					($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
				} ?>		
				</table><br />
				  <?php 
			} elseif($asociadoX=="proceso"){
				$sql="SELECT id,descripcion  FROM cat_procesos";
				$result=mysql_db_query($sql_db,$sql);
				?>
				<br /><table align="center" width="98%" cellspacing="0" style="border:#333333 1px solid;">
				<tr>
					<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Cat&aacute;logo de Procesos.</td>
				  </tr>		
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
					<td width="10%" height="20">ID</td>
					<td width="90%">Proceso</td>
				</tr>
				<?php while($row=mysql_fetch_array($result)){ ?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?=$row["id"];?>','<?=$row["descripcion"];?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20">&nbsp;<?=$row["id"];?></td>
					<td>&nbsp;<?=$row["descripcion"];?></td>
				</tr>
				<?php 
					($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
				} ?>		
				</table><br />
				  <?php 				  
				  
			} elseif($asociadoX=="centro_costo"){
			
				$sql_centro_costo="SELECT * FROM tipoalmacen WHERE activo='1' AND es_centro_costo='1'";
				$result_centro_costo=mysql_db_query($sql_db,$sql_centro_costo,$link) or die("<h3>Error SQL (".mysql_error($link).").</h3>");			
				?>
			  <table id="tbl_1" width="100%" border="0" align="center" cellspacing="0">
				<tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
				  <td colspan="2" height="23">Cat&aacute;logo de  Centros de Costo </td>
				</tr>
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
				  <td id="campo0" width="93"><a href='#' onclick='muestra_buscador(0)'>Id</a></td>
				  <td id="campo1" width="820"><a href='#' onclick='muestra_buscador(1)'>Centro de Costo</a></td>
				</tr>				
				<?php
				while($reg_centro_costo=mysql_fetch_array($result_centro_costo)){
					//echo "<br>";	print_r($reg_centro_costo);
					?>
					<tr id="tr_<?=$reg_centro_costo["id_almacen"]?>" bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?= $reg_centro_costo["id_almacen"]; ?>','<?= $reg_centro_costo["almacen"]; ?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20"><?=$reg_centro_costo["id_almacen"]?></td>
					<td>&nbsp;<?=$reg_centro_costo["almacen"]?></td>
					</tr>
					
					<?php
					($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
				}
				?>
				</table>
				<?php
			
			} elseif($asociadoX=="Almacenes"){
			$conceptoX=$_POST["conceptoX"];
			if ($conceptoX=="Entrada x Traspaso"||$conceptoX=="Merma")
			{
				?>
				<script language="javascript">
					//coloca_proveedor1(0,0);
					//$("#div_asociados2").hide();
					//cerrar('div_asociados2');
				</script>
				<?php			
				//exit();
			}
			
			$color="#D9FFB3";
			$sql="SELECT * FROM tipoalmacen WHERE activo='1' AND es_almacen='1'";
			$result=mysql_db_query($sql_db,$sql);
			?>
<script language="javascript">
function numero_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas = tabla.rows.length;
	var numFilas2=parseInt(numFilas)-1;
	return(numFilas2);
}
function muestra_buscador(id_campo){
	mostrar_todas_filas('tbl_1');
	var no_campos=5;
	for(var i=0;i<no_campos;i++){	$("#txt_buscador"+i).hide();	}
	var valor_celda_input=$("#campo"+id_campo).html();
	if(valor_celda_input.indexOf("input")!=-1){ $("#txt_buscador"+id_campo).show(); }else{ $("#campo"+id_campo).append("<br><input type='text' id='txt_buscador"+id_campo+"' style='width:100px;' onkeyup='buscar("+id_campo+")'>"); }
	$("#txt_buscador"+id_campo).focus();	
}
function buscar(id_campo){
	var tabla = document.getElementById("tbl_1");
	var numFilas2=numero_filas('tbl_1');
	var criterio=$("#txt_buscador"+id_campo).attr("value");
	var crit_minusculas=criterio.toLowerCase();
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		var valor_celda=tabla.tBodies[0].rows[i].cells[id_campo].innerHTML;
		var valor_celda_minusculas=valor_celda.toLowerCase();			
		if (valor_celda_minusculas.indexOf(crit_minusculas)!=-1) { $("#tr_"+id).show(); }else{ $("#tr_"+id).hide(); }
	}
}
function mostrar_todas_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas2=numero_filas('tbl_1');
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		$("#tr_"+id).show();
	}
}
</script>			  
			  <table id="tbl_1" width="100%" border="0" align="center" cellspacing="0">
				<tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
				  <td colspan="2" height="23">Cat&aacute;logo de  Almacenes </td>
				</tr>
				<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
				  <td id="campo0" width="93"><a href='#' onclick='muestra_buscador(0)'>Id</a></td>
				  <td id="campo1" width="820"><a href='#' onclick='muestra_buscador(1)'>Almac&eacute;n</a></td>
				</tr>
				<? while($row=mysql_fetch_array($result)) { ?>
					<tr id="tr_<?=$row["id_almacen"]?>" bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_proveedor1('<?= $row["id_almacen"]; ?>','<?= $row["almacen"]; ?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20"><?=$row["id_almacen"]?></td>
					<td>&nbsp;<?=$row["almacen"]?></td>
					</tr>
					<?
				($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
				}
				?>
			  </table>
			  <?php
		
			}
		  ?>
		</div>		
		<?php
	}	
	if ($ac=="crear_movimiento")
	{
		$t=$_POST["t"];		$f=$_POST["f"];		$al=$_POST["al"];		$as=$_POST["as"];		$r=$_POST["r"];		$oc=$_POST["oc"];		$o=$_POST["o"];		$fr=date("Y-m-d H:i:s");
		$usuario_id=$_SESSION["usuario_id"];
		$usuario_nombre=$_SESSION["nombre"];		
		
		
		$sql_nuevo_mov="INSERT INTO mov_almacen (id_mov,fecha,fecha_real,tipo_mov,almacen,referencia,asociado,oc,observ,seriesGen) VALUES (NULL,'$f','$fr','$t','$al','$r','$as','$oc','$o (Usuario : $usuario_id. $usuario_nombre)','No Generado')";
		if (mysql_db_query($sql_db,$sql_nuevo_mov,$link))
		{
			$u_id=mysql_insert_id($link);
			//echo "<div align='center'>Se ha creado el Movimiento: $u_id.</div>";
			?>
			<br><br><div id="div_items_movs1">
				<div class="tit1">
					<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOVIMIENTO <?=$u_id?> <input type="hidden" name="hdn_ndm1" id="hdn_ndm1" value="<?=$u_id?>" />.&nbsp;</span>
					<!--<span class="cer_mov"><a href="javascript:cerrar('div_items_movs1');">CERRAR</a>&nbsp;</span>//-->
				</div>
				<br>
				<form id="frm1" name="frm1" method="post" action="">
				  <table width="99%" align="center" cellspacing="0"  style=" font-family:Arial, Helvetica, sans-serif; border:#000000 1px solid;font-weight:normal; font-size:small; ">
					<tr style="text-align:center; font-weight:bold; background-color:#333333; color:#FFFFFF;">
					  <td width="25">&nbsp;</td>
					  <td width="67" height="25">Cantidad</td>
					  <td width="46">ID</td>
					  <td width="256">Clave Producto </td>
					  <td width="263">Descripci&oacute;n</td>
					  <td width="175">Especificaci&oacute;n</td>
					  <td width="175">C.U.</td>
					  <td width="55">Posici&oacute;n</td>
				    </tr>
					<?php 
					$color="#EFEFEF";
					if ($t==1)
					{
						$no_de_productos_en_dolares=array();
						//echo "<br>".
						$sql_oc1="SELECT oc.id_prov,items.* FROM oc,items WHERE oc.id_oc=items.id_oc AND oc.id_prov=$as AND oc.id_oc=$oc ORDER BY items.id_item";
						if ($result_oc1=mysql_db_query($dbcompras,$sql_oc1,$link))
						{
							//echo "<br><hr>OK <hr>";
							if (mysql_num_rows($result_oc1)>0)
							{
								$a=11;
								while($row_oc1=mysql_fetch_array($result_oc1))
								{
									//echo "<br><br>"; 	print_r($row_oc1);
									$moneda=$row_oc1["moneda"];
									if ($moneda=="USD"){
										array_push($no_de_productos_en_dolares,$id_item);
									}
									//echo "<br>ID ITEM: ".
									$id_item=$row_oc1["id_item"];
									//echo "<br>ID OC: ".
									$id_oc=$row_oc1["id_oc"];
									//echo "<br>ID PROD: ".
									$id_prod=$row_oc1["id_producto"];
									//echo "<br>CANTIDAD ORIGINAL: ".
									$cantidad_original=$row_oc1["cantidad"];
									
									$cdp1=$row_oc1["id_producto"];
									//echo "<br>".
									$sql_2="SELECT id,especificacion FROM catprod WHERE id_prod='$cdp1'";
									if ($result_2=mysql_db_query($sql_db,$sql_2,$link)){
										//echo "<br><hr>OK 2 <hr>";
										while($row_2=mysql_fetch_array($result_2))
										{
											//echo "<br><br>"; 	print_r($row_2);
											$idp2=$row_2["id"];
											$esp2=$row_2["especificacion"];
										}
									} else {
										echo "<div align='center'>Error del Sistema: Se ha producido un error en la sentencia SQL (sql_2).</div>";
										exit();
									}
									
									//echo "<br>".
									$sql_entrega_parcial="SELECT * FROM `entregaparcial` WHERE `id_oc` =$id_oc AND id_item=$id_item";
									if ($result_entrega_parcial=mysql_db_query($dbcompras,$sql_entrega_parcial,$link))
									{ 									
										$ndr_entrega_parcial=mysql_num_rows($result_entrega_parcial);
										//echo "<br><hr>OK 3 [$ndr_entrega_parcial] Resultados <hr>";
										if ($ndr_entrega_parcial>0){
											while($row_entrega_parcial=mysql_fetch_array($result_entrega_parcial))
											{
												//echo "<br><br>"; 	print_r($row_entrega_parcial);
												//echo "<br>CANTIDAD ORIGINAL: ".
												$cantidad_recibida=$row_entrega_parcial["cantrec"];
												
												//echo "<br><hr>OC [$id_oc] ITEM [$id_item] PRODUCTO [$id_prod] CANTIDAD SOLICITADA [$cantidad_original] CANTIDAD ENTREGADA [$cantidad_recibida]<hr><br>";
												?>
										<tr style="background-color:<?=$color?>; text-align:center;" class="troc1">
										  <td><input type="checkbox" name="chk_<?=$a?>" id="chk_<?=$a?>" value="<?=$a?>" checked="checked" /></td>
										  <td class="td1"><input name="ca<?=$a?>" type="text" id="ca<?=$a?>" size="5" class="txtNC" value="<?=$cantidad_recibida?>" readonly="readonly" style="background-color:#FFFFFF; border:#999999 1px solid; text-align:right;" /></td>
										  <td ><input name="idp<?=$a?>" type="text" id="idp<?=$a?>" size="5" value="<?=$idp2?>" readonly="1" style="background-color:#FFFFFF; border:#999999 1px solid; text-align:center;" /></td>
										  <td align="left" ><input name="clave<?=$a?>" type="text" size="15" id="clave<?=$a?>" value="<?=$row_oc1["id_producto"]?>" style="cursor:hand; background-color:#FFFFFF; border: #999999 1px solid;" readonly="1" />&nbsp;<a href="#" title="Este producto pertenece a la OC <?=$oc?> realizada al Proveedor <?=$as?> por una cantidad solicitada de (<?=$cantidad_original?>) y la cantidad entregada es de (<?=$cantidad_recibida?>). ">***</a></td>
										  <td ><input name="ds<?=$a?>" type="text" id="ds<?=$a?>" value="<?=$row_oc1["descripcion"]?>" readonly="1" style="background-color:#FFFFFF; border:#999999 1px solid;" />						  </td>
										  <td ><input name="es<?=$a?>" type="text" id="es<?=$a?>" value="<?=$esp2?>" readonly="1" style="background-color:#FFFFFF; border:#999999 1px solid;" /></td>
										  <td align="left" ><input name="cu<?=$a?>" type="text" id="cu<?=$a?>" size="5" value="<?=$row_oc1["costoUnitario"]?>" style="background-color:#FFFFFF; border:#999999 1px solid; text-align:right;" /><?=$moneda?></td>
										  <td align="left" ><input name="ubi<?=$a?>" type="text" id="ubi<?=$a?>" size="5" value="" style="background-color:#FFFFFF; border:#999999 1px solid; " /></td>
										</tr>												
												<?php
												++$a;
											}
										} else {
											//echo "<br>Error: No se encontraron resultados a la consulta a la tabla ENTREGAS PARCIALES (El sistema no puede continuar, realice primero el recibo de Productos).";
											?>
											<tr style="background-color:#CCCCCC; text-align:center;">
												<td colspan="8" height="20" style=" font-size:10px; color:#FF0000; font-weight:normal;">No se encontraron resultados a la consulta a la tabla ENTREGAS PARCIALES del producto [<?=$cdp1?>]<br />(realice primero el recibo de Productos).												</td>
											</tr>
											<!--</table>	//-->							
											<?php
											//exit;
											
										}
									} else {
										echo "<div align='center'>Error del Sistema: Se ha producido un error en la sentencia SQL (sql_entrega_parcial) [".mysql_error($link)."].</div>";
										exit();
									}									
									
									
									
									
									
									
									
									?>
									<!--
									<tr style="background-color:#CCCCCC; text-align:center;">
						  				<td colspan="7"><?php 
											//echo "<br><br>"; print_r($row_oc1);
										?></td>
				       				</tr>
									//-->
					
							
									
									<?php
									
									($color=="#EFEFEF")? $color="#FFFFFF": $color="#EFEFEF";	
								}
							} else { 
								//echo "<br>Error SQL [".mysql_error($link)."]";
								?>
								<tr style="background-color:#CCCCCC; text-align:center;">
									<td colspan="8" height="20" style=" font-size:10px; color:#FF0000;">La OC <?=$oc?> realizada al Proveedor <?=$as?> no presenta resultados. Verifique si los datos introducidos son correctos.</td>
								</tr>							
								<?php							
							}
							if (count($no_de_productos_en_dolares)>0){
							?>
							<script language="javascript">
								alert("Importante: \n\nParece que algunos productos fueron comprados en dolares. \nEl sistema de Inventario, solo permite una sola moneda (pesos). \nPara registrar el producto, se requiere hacer la conversion. ");
							</script>
							<?php
							}							
						} else {
							?>
							<tr style="background-color:#CCCCCC; text-align:center;">
								<td colspan="8" height="20">Error del Sistema: Imposible mostrar items de la OC <?=$oc?>.</td>
							</tr>							
							<?php
						}	
					} else {					
						for ($a=1;$a<=10;$a++) {
						?>
						    
					    <tr style="background-color:<?=$color?>; text-align:center;">
						  <td><input type="checkbox" name="chk_<?=$a?>" id="chk_<?=$a?>" value="<?=$a?>" /></td>
						  <td class="td1"><input name="ca<?=$a?>" type="text" id="ca<?=$a?>" size="5" class="txtNC" /></td>
						  <td ><input name="idp<?=$a?>" type="text" id="idp<?=$a?>" size="5" /></td>
						  <td align="left" >
							<input name="clave<?=$a?>" type="text" size="15" id="clave<?=$a?>" style="cursor:pointer;" onclick="elegir_producto1('<?=$a?>')" />
							<!--<input name="btn_tipo<?=$a?>" id="btn_tipo<?=$a?>" type="button" value=".." class="btn2" onclick="javascript:elegir_producto1('<?=$a?>');" />//-->					  </td>
						  <td ><input name="ds<?=$a?>" type="text" id="ds<?=$a?>" />					  </td>
						  <td ><input name="es<?=$a?>" type="text" id="es<?=$a?>" /></td>
						  <td align="left" ><input name="cu<?=$a?>" type="text" id="cu<?=$a?>" size="5" /></td>
						  <td align="left" ><input name="ubi<?=$a?>" type="text" id="ubi<?=$a?>" size="5" value="" /></td>
						</tr>
						<?
						($color=="#EFEFEF")? $color="#FFFFFF": $color="#EFEFEF";
						}
					}
					?>
					<tr>
					  <td colspan="8" style="text-align:right; padding:2px; border-top:#000000 2px solid0; background-color:#CCCCCC;">
							<input type="reset" name="reset2" value="Limpiar" class="Estilo60" />&nbsp;
							<input type="button" name="obtener_datos" value="Obtener Datos" onclick="obtener_datos_ids()" /><a href="#" title="Introduzca el Id de (el/los) producto(s), seleccione la casilla de verificacion y presione &quot;Obtener Datos&quot;." style="font-size:10px;"><sup>*</sup></a>&nbsp;
							<input type="button" name="Submit8" class="Estilo60" value="Guardar Producto" onclick="guarda_producto()" />					  </td>
					</tr>
				  </table>
				</form>
				
									
			</div>
			
			<?php
			exit();
		} else {
			echo "<div align='center'>Error del Sistema: El movimiento no se genero.</div>";
			exit();
		}
	}		
	if ($ac=="mostrar_productos")
	{
		$cdm=$_POST["cdm"];
		$tdm=$_POST["tdm"];		$alm=$_POST["alm"];		$aso=$_POST["aso"];		$ias=$_POST["ias"];		$n=$_POST["n"];
		$ceX="exist_$alm";		$desceX="Existencias del Almacen $alm";
		$ctX="trans_$alm";		$desctX="Transferencias del Almacen $alm";
		//$ias=5000000;	
		
		// OBTENER EL NOMBRE DEL CAMPO ASOCIADO ...
		$sql2="SELECT `almacen` FROM `tipoalmacen` WHERE id_almacen=$alm ";
		$r2=mysql_db_query($sql_db,$sql2);
		while ($ro2=mysql_fetch_array($r2))
		{
			$nalm=$ro2["almacen"];
			$ncalm="a_".$alm."_$nalm";
			//echo "<br>NCA=($ncalm)<BR>";
		}	

		if ($aso=="Proveedor")
		{
			$sql0="SELECT * FROM  `prodxprov` WHERE `id_prov`=$ias order by id_prod ";
			$r0=mysql_db_query($sql_db,$sql0);
			$ndrp=mysql_num_rows($r0);
			if (!$ndrp>0)
			{
				mensaje(0);
			}
			?>
<script language="javascript">
function numero_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas = tabla.rows.length;
	var numFilas2=parseInt(numFilas)-1;
	return(numFilas2);
}
function muestra_buscador(id_campo){
	mostrar_todas_filas('tbl_1');
	var no_campos=5;
	for(var i=0;i<no_campos;i++){	$("#txt_buscador"+i).hide();	}
	var valor_celda_input=$("#campo"+id_campo).html();
	if(valor_celda_input.indexOf("input")!=-1){ $("#txt_buscador"+id_campo).show(); }else{ $("#campo"+id_campo).append("<br><input type='text' id='txt_buscador"+id_campo+"' style='width:100px;' onkeyup='buscar("+id_campo+")'>"); }
	$("#txt_buscador"+id_campo).focus();	
}
function buscar(id_campo){
	var tabla = document.getElementById("tbl_1");
	var numFilas2=numero_filas('tbl_1');
	var criterio=$("#txt_buscador"+id_campo).attr("value");
	var crit_minusculas=criterio.toLowerCase();
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		var valor_celda=tabla.tBodies[0].rows[i].cells[id_campo].innerHTML;
		var valor_celda_minusculas=valor_celda.toLowerCase();			
		if (valor_celda_minusculas.indexOf(crit_minusculas)!=-1) { $("#tr_"+id).show(); }else{ $("#tr_"+id).hide(); }
	}
}
function mostrar_todas_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas2=numero_filas('tbl_1');
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		$("#tr_"+id).show();
	}
}
</script>			
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table id="tbl_1" width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				Productos asociados al Proveedor: <?=$ias;?> </td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td id='campo0' width="17" height="20"><a href='#' onclick='muestra_buscador(0)'>Id</a></td>
				<td id='campo1' width="176"><a href='#' onclick='muestra_buscador(1)'>Clave del Producto</a></td>
				<td id='campo2' width="481"><a href='#' onclick='muestra_buscador(2)'>Descripci&oacute;n</a></td>
				<td id='campo3' width="377"><a href='#' onclick='muestra_buscador(3)'>Especificaci&oacute;n</a></td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php
			while ($ro0=mysql_fetch_array($r0))
			{
				$id_prov=$ro0["id_prov"];
				$id_prod=$ro0["id_prod"];			
				//echo "<br>IPROV =$id_prov, IPROD=$id_prod";

				$sql1="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE `id_prod`='$id_prod' AND activo=1  ORDER BY `especificacion`";
				$r1=mysql_db_query($sql_db,$sql1);
				//echo '<br>NDR: '.mysql_num_rows($r1);
				while ($ro1=mysql_fetch_array($r1))
				{
					$id_prod2=$ro1["id_prod"];
					$esp=$ro1["especificacion"];
					$des=$ro1["descripgral"];
					$exi=$ro1["$ceX"];
					$tra=$ro1["$ctX"];
					if ($cdm=="Dev Compras"||$cdm=="Canc de Compra") { $cpr=$ro1["cpromedio"]; } else { $cpr=""; }
					
					$des2=str_replace("\""," PULGADAS ",$des);
					//echo "<br> $id_prod2    $des       $esp ";
					?>
					<tr id="tr_<?=$ro1["id"]?>" bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro1["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
					  <td height="20" align="center"><?=$ro1["id"]?></td>
						<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
						<td>&nbsp;<?=$des?></td>
						<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
						<td align="right"><?=$exi;?>&nbsp;</td>
						<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
					</tr>
					<?php
					($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
				}
			}
			?></table>
			<br>
			</div>
				<?php		
		
		} elseif ($aso=="Ninguno"||$aso=="proceso"){
			//echo "<BR>".
			$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1  AND activo=1 ORDER BY `id`";
			$r0=mysql_db_query($sql_db,$sql0);
			$ndrp=mysql_num_rows($r0);
			if (!$ndrp>0)
			{
				mensaje(0);
			}
			?>
			
<script language="javascript">
function numero_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas = tabla.rows.length;
	var numFilas2=parseInt(numFilas)-1;
	return(numFilas2);
}
function muestra_buscador(id_campo){
	if(numero_filas('tbl_1')>500) return; 
	mostrar_todas_filas('tbl_1');
	var no_campos=5;
	for(var i=0;i<no_campos;i++){	$("#txt_buscador"+i).hide();	}
	var valor_celda_input=$("#campo"+id_campo).html();
	if(valor_celda_input.indexOf("input")!=-1){ $("#txt_buscador"+id_campo).show(); }else{ $("#campo"+id_campo).append("<br><input type='text' id='txt_buscador"+id_campo+"' style='width:100px;' onkeyup='buscar("+id_campo+")'>"); }
	$("#txt_buscador"+id_campo).focus();	
}
function buscar(id_campo,elEvento){
	//alert("buscar en el campo"+id_campo);
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	var caracter = String.fromCharCode(codigo);
	alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
	if (codigo==13){ 	
		var tabla = document.getElementById("tbl_1");
		var numFilas2=numero_filas('tbl_1');
		var criterio=$("#txt_buscador"+id_campo).attr("value");
		var crit_minusculas=criterio.toLowerCase();
		for (var i=1;i<=numFilas2;i++){
			var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
			var valor_celda=tabla.tBodies[0].rows[i].cells[id_campo].innerHTML;
			var valor_celda_minusculas=valor_celda.toLowerCase();			
			if (valor_celda_minusculas.indexOf(crit_minusculas)!=-1) { $("#tr_"+id).show(); }else{ $("#tr_"+id).hide(); }
		}
	} else { return; }
}
function mostrar_todas_filas(id_tabla){
	var tabla = document.getElementById(id_tabla);
	var numFilas2=numero_filas('tbl_1');
	for (var i=1;i<=numFilas2;i++){
		var id=tabla.tBodies[0].rows[i].cells[0].innerHTML;
		$("#tr_"+id).show();
	}
}
</script>				  
			
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table id="tbl_1" width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				 Productos asociados al Almac&eacute;n <?=$alm?></td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td id='campo0' width="17" height="20"><a href='#' onclick='muestra_buscador(0)'>Id</a></td>
				<td id='campo1' width="176"><a href='#' onclick='muestra_buscador(1)'>Clave del Producto</a></td>
				<td id='campo2' width="481"><a href='#' onclick='muestra_buscador(2)'>Descripci&oacute;n</a></td>
				<td id='campo3' width="377"><a href='#' onclick='muestra_buscador(3)'>Especificaci&oacute;n</a></td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php
			while ($ro0=mysql_fetch_array($r0))
			{
				$id_prod2=$ro0["id_prod"];
				$esp=$ro0["especificacion"];
				$des=$ro0["descripgral"];
				$cpr=$ro0["cpromedio"];
				$exi=$ro0["$ceX"];
				$tra=$ro0["$ctX"];
				
				$des2=str_replace("\""," PULGADAS ",$des);
				//echo "<br> $id_prod2    $des       $esp ";
				
				
				
				?>
				<tr id="tr_<?=$ro0["id"]?>" bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
				    <td height="20" align="center"><?=$ro0["id"]?></td>
					<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
					<td>&nbsp;<?=$des?></td>
					<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
					<td align="right"><?=$exi;?>&nbsp;</td>
					<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
				</tr>
				<?php
				($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
			}
			?></table>
			<br>
			</div>
				<?php		
		} elseif ($aso=="Cliente") {
			$m_productos=array();
			//echo "<br>Cat de Clientes ($ias)";
			//echo "<BR>".
			$sql0="SELECT `id`,`id_clientes` FROM `catprod` WHERE $ncalm=1  AND activo=1 AND id_clientes LIKE '%$ias%' ORDER BY `id`";
			$r0=mysql_db_query($sql_db,$sql0);
			?>
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				 Productos asociados al Cliente <?=$ias?></td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td width="17" height="20">Id</td>
				<td width="176">Clave del Producto </td>
				<td width="481">Descripci&oacute;n</td>
				<td width="377">Especificaci&oacute;n</td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php			
			while ($ro0=mysql_fetch_array($r0))
			{
				$idx0=$ro0["id"];
				$idprooX0=trim($ro0["id_clientes"]);
				
				//echo "<br>COINCIDEN 1: [$idx0] [$idprooX0]";
				$idprooX0_split=split(',',$idprooX0);
				//print_r($idprooX0_split);
				foreach ($idprooX0_split as $idprooX0_splitX)
				{
					//echo "<br>COINCIDEN 1: [$idx0] [$idprooX0]";	
					if ($idprooX0_splitX==$ias) {	array_push($m_productos,$idx0); }
				}
			}				
			//echo "<BR>Productos asociados con el Cliente ($ias).<br>";
			//print_r($m_productos);
			if (count($m_productos)>0)
			{
				//echo "<br>Muestra tabla<br>";

						foreach($m_productos as $idp_matriz)
						{
							//echo "<br>&nbsp;".
							$sql_p_clientes="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `$ceX`, `$ctX`, `cpromedio` FROM catprod WHERE id=$idp_matriz AND $ncalm=1  AND activo=1 LIMIT 1";
							if ($r1=mysql_db_query($sql_db,$sql_p_clientes))
							{
								while ($ro1=mysql_fetch_array($r1))
								{
									if ($cdm=="Ventas")
									{
										$cpX=$ro1["cpromedio"];
									} else {
										$cpX="";
									}
									?>
									<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro1["id"]?>','<?=$ro1["id_prod"]?>','<?=$ro1["descripgral"]?>','<?=$ro1["especificacion"]?>','<?=$cpX?>','<?=$n?>');" style="cursor:pointer;">
									  <td height="20" align="center"><?=$ro1["id"]?></td>
										<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$ro1["id_prod"]?></td>
										<td>&nbsp;<?=$ro1["descripgral"]?></td>
										<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$ro1["especificacion"]?></td>
										<td align="right"><?=$ro1["$ceX"]?>&nbsp;</td>
										<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$ro1["$ctX"]?>&nbsp;</td>
									</tr>
									<?php
									($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
									//print_r($ro1);
								}	
							} else {
								errorX(1);
							}
						}
			} else {
				errorX(0);
			}
		?>
		</table>
		<br>
		</div>
		<?php		
		}elseif($aso=="Almacenes"){
			if ($cdm=="Entrada x Traspaso"){ 
				//echo "<br><hr>Entrada x Traspaso<hr><br>";
			
				//echo "<BR>".
				$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1 AND $ctX>0 AND activo=1 ORDER BY `id`";
				$r0=mysql_db_query($sql_db,$sql0);
				$ndrp=mysql_num_rows($r0);
				if (!$ndrp>0)
				{
					mensaje(0);
				}
				?>
				<br><br><div id="div_proveedores1">
				<span class="cer_mov"><a href="javascript:cerrar('div_proveedores1');">CERRAR</a>&nbsp;</span>
				<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
				  <tr>
					<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
					 Productos asociados al Almac&eacute;n <?=$alm?></td>
				  </tr>
				  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
					<td width="17" height="20">Id</td>
					<td width="176">Clave del Producto </td>
					<td width="481">Descripci&oacute;n</td>
					<td width="377">Especificaci&oacute;n</td>
					<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
					<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
				  </tr>
				<?php
				while ($ro0=mysql_fetch_array($r0))
				{
					$id_prod2=$ro0["id_prod"];
					$esp=$ro0["especificacion"];
					$des=$ro0["descripgral"];
						if ($cdm=="Merma"||$cdm=="Entrada x Traspaso") { 
							$cpr=$ro0["cpromedio"]; 
						} else { $cpr="";}
					$exi=$ro0["$ceX"];
					$tra=$ro0["$ctX"];
					
					$des2=str_replace("\""," PULGADAS ",$des);
					//echo "<br> $id_prod2    $des       $esp ";
					?>
					<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
					  <td height="20" align="center"><?=$ro0["id"]?></td>
						<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
						<td>&nbsp;<?=$des?></td>
						<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
						<td align="right"><?=$exi;?>&nbsp;</td>
						<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
					</tr>
					<?php
					($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
				}
				?></table>
				<br>
				</div>
				<?php		
				exit();
			} // TERMINA E X T ...

			
			if ($cdm=="Salida x Trasp"){ 
				//echo "<br><hr>Salida x Traspaso<hr><br>";
				
					// OBTENER EL NOMBRE DEL CAMPO DEL ALMACEN ASOCIADO...
					$sql9="SELECT `id_almacen`,`almacen` FROM `tipoalmacen` WHERE id_almacen=$ias ";
					$r9=mysql_db_query($sql_db,$sql9);
					while ($ro9=mysql_fetch_array($r9))
					{
						$ialm3=$ro9["id_almacen"];
						$nalm3=$ro9["almacen"];
						$ncalm3="a_".$ialm3."_$nalm3";
						//echo "<br>NCA DESTINO=($ncalm2)<BR>";
					}				
				//echo "<BR>".
				$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1 AND $ncalm3=1  AND activo=1 AND $ceX>0 ORDER BY `id`";
				$r0=mysql_db_query($sql_db,$sql0);
				$ndrp=mysql_num_rows($r0);
				if (!$ndrp>0)
				{
					mensaje(0);
				}
				?>
				<br><br><div id="div_proveedores1">
				<span class="cer_mov"><a href="javascript:cerrar2('div_proveedores1');">CERRAR</a>&nbsp;</span>
				<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
				  <tr>
					<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
					 Productos asociados al Almac&eacute;n <?=$alm?> y <?=$ias?></td>
				  </tr>
				  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
					<td width="17" height="20">Id</td>
					<td width="176">Clave del Producto </td>
					<td width="481">Descripci&oacute;n</td>
					<td width="377">Especificaci&oacute;n</td>
					<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
					<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
				  </tr>
				<?php
				while ($ro0=mysql_fetch_array($r0))
				{
					$id_prod2=$ro0["id_prod"];
					$esp=$ro0["especificacion"];
					$des=$ro0["descripgral"];
					$cpr=$ro0["cpromedio"];
					$exi=$ro0["$ceX"];
					$tra=$ro0["$ctX"];
					
					$des2=str_replace("\""," PULGADAS ",$des);
					//echo "<br> $id_prod2    $des       $esp ";
					?>
					<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
					  <td height="20" align="center"><?=$ro0["id"]?></td>
						<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
						<td>&nbsp;<?=$des?></td>
						<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
						<td align="right"><?=$exi;?>&nbsp;</td>
						<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
					</tr>
					<?php
					($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
				}
				?></table>
				<br>
				</div>
				<?php		
				exit();
			} // TERMINA S X T ...

			
			//echo "<BR>".
			$sql0="SELECT `id`,`id_prod`, `descripgral`, `especificacion`, `cpromedio`, `$ceX`, `$ctX` FROM `catprod` WHERE $ncalm=1  AND activo=1 ORDER BY `id`";
			$r0=mysql_db_query($sql_db,$sql0);
			$ndrp=mysql_num_rows($r0);
			if (!$ndrp>0)
			{
				mensaje(0);
			}
			?>
			<br><br><div id="div_proveedores1">
			<span class="cer_mov"><a href="javascript:cerrar('div_proveedores1');">CERRAR</a>&nbsp;</span>
			<br /><br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid; background-color:#FFFFFF;">
			  <tr>
				<td colspan="6" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				 Productos asociados al Almac&eacute;n <?=$alm?></td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
				<td width="17" height="20">Id</td>
				<td width="176">Clave del Producto </td>
				<td width="481">Descripci&oacute;n</td>
				<td width="377">Especificaci&oacute;n</td>
				<td width="65"><a href="#" title="<?=$desceX?>" style="color:#000000;">Exist.</a></td>
				<td width="64"><a href="#" title="<?=$desctX?>" style="color:#000000;">Trans.</a></td>
			  </tr>
			<?php
			while ($ro0=mysql_fetch_array($r0))
			{
				$id_prod2=$ro0["id_prod"];
				$esp=$ro0["especificacion"];
				$des=$ro0["descripgral"];
				$exi=$ro0["$ceX"];
				$tra=$ro0["$ctX"];
				$des2=str_replace("\""," PULGADAS ",$des);
				//echo "<br> $id_prod2    $des       $esp ";
				if ($cdm=="Merma") { $cpr=$ro0["cpromedio"]; } else { $cpr="";}				
				?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_producto1('<?=$ro0["id"]?>','<?=$id_prod2?>','<?=$des2?>','<?=$esp?>','<?=$cpr?>','<?=$n?>');" style="cursor:pointer;">
				  <td height="20" align="center"><?=$ro0["id"]?></td>
					<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$id_prod2;?></td>
					<td>&nbsp;<?=$des?></td>
					<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?=$esp;?></td>
					<td align="right"><?=$exi;?>&nbsp;</td>
					<td style="border-left:#CCCCCC 1px solid; " align="right"><?=$tra;?>&nbsp;</td>
				</tr>
				<?php
				($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
			}
			?></table>
			<br>
			</div>
				<?php		

		
		
		}
	}
	
	
	
	
	
	
	
	if ($ac=="insertar_productos"){
		$m=$_POST["idm"];		$v=$_POST["valores"];
		$productos=split(',',$v);
		
		echo "<br>";
		echo "<br><div id='acciones_proceso'>
				<div class='tit1'>
					<span class='cer_mov'><a href='javascript:cerrar(\"acciones_proceso\");'>CERRAR</a>&nbsp;</span>
				</div>
		&nbsp;&nbsp;&nbsp;<b>ACCIONES DEL PROCESO:</b><br>";
		?>
		<ul>
			
			<li><b>Obtener y Validar la Informaci&oacute;n.</b></li><br />
		<?php		
		
		foreach ($productos as $p)
		{
			
			if (!$p==''){
				//echo "<br>producto=$p";
				//$valores0=str_replace("?","','",$p);
				$valores=explode('?',$p);
				//echo " = "; print_r($valores);
				$sql_insertar="INSERT INTO prodxmov(nummov,id_prod,cantidad,existen,clave,cu,id,ubicacion) VALUES ('$m',";
				$sql_insertar.="'".$valores[0]."','".$valores[1]."','".$valores[2]."','".$valores[3]."','".$valores[4]."',NULL,'".$valores[5]."')";
				//echo "<br>$sql_insertar";
				//foreach ($valores as $valores2){	echo " [$valores2] ";	}

				
				if ($sistema_costeoX=="CP")
				{
					// VERIFICAR SI YA EXISTE EL PRODUCTO EN EL MOVIMENTO ...
					//echo "<br>".
					$sql_existe="SELECT id FROM prodxmov WHERE id_prod='".$valores[0]."' AND nummov='$m' "; 
					$r_existe=mysql_db_query($sql_db,$sql_existe);
					if (mysql_num_rows($r_existe)>0)
					{
						echo "<br><br><div class='mensajeX'><font color='#ff0000'>ERROR:</font> El producto ".$valores[0]." ya esta en el movimiento $m.<br> Evite colocar productos duplicados en un solo Movimiento. El proceso en el sistema se detuvo.";
						exit();
					}
				}
				
					$nuevo_movimiento=new movimientos($m,$valores[0],$valores[1],$valores[3],$valores[4]);
					$nuevo_movimiento->mueve_producto($sql_insertar);
					//$nuevo_movimiento->mueve_producto();
					unset($nuevo_movimiento);
					
					
				/*
				if (mysql_db_query($sql_db,$sql_insertar))
				{
					echo "<li>El producto (".$valores[0].") se agrego al movimiento ($m) correctamente.</li>";
					?>
					<script language="javascript">
						//document.frm1.reset();
					</script>
					<?php
				} else {
					echo "<br><div align='center'>Error del sistema: El registro  NO se inserto.</div>";
					exit;
				}
				*/
				
			}
		}
		?>
		</ul>
		<?php
		
		ver_movimiento($m);
		echo "</div>";
	}		



	function ver_movimiento($idm)
	{
		include ("../conf/conectarbase.php");
		//echo "<br>Ver Movimiento ($idm)<br>";
		$sql_prod_m="SELECT * FROM prodxmov WHERE nummov='$idm' ORDER BY id";
		$r1=mysql_db_query($sql_db,$sql_prod_m);

		$ndr_pem=mysql_num_rows($r1);
		if (!$ndr_pem>0)
		{
			mensaje(0);
		}
		?>
			<div id="div_pem1">
			<br /><table width="98%" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; border:#000000 1px solid; background-color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;">
			  <tr>
				<td colspan="5" height="23" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;"><?=$ndrp;?>
				Productos en el Movimiento : <?=$idm?> </td>
			  </tr>
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
			    <td width="85">#</td>
				<td width="145" height="20">Id Mov </td>
				<td width="478">Clave del Producto </td>
				<td width="267">Cantidad</td>
				<td width="205">C.U.</td>
			  </tr>
			<?php
			while ($ro1=mysql_fetch_array($r1))
			{
				?>
				<tr bgcolor="<?=$color;?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" >
				  <td style="border-right:#CCCCCC 1px solid; text-align:center;"><?=$ro1["id"]?></td>
				  <td height="20" align="center"><?=$ro1["id_prod"]?></td>
					<td style="border-right:#CCCCCC 1px solid;border-left: #CCCCCC 1px solid;">&nbsp;<?=$ro1["clave"]?></td>
					<td align="right"><?=$ro1["cantidad"]?>&nbsp;</td>
					<td style="border-left:#CCCCCC 1px solid; text-align:right">$<?=number_format($ro1["cu"],2,'.',',')?>&nbsp;</td>
				</tr>
				<?php
				($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
			}
			?></table>
			<br>
			</div>
		<?php
	}
?>