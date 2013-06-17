<?php 
	include ("../conf/conectarbase.php");
	//print_r($_GET);
	$sql_recibida=str_replace('\\','',stripslashes($_GET["sql"]));
	$almacenes_asociados=$_GET["almacenes_asociados"];
	$m_almacenes=explode(',',$almacenes_asociados);
	if ($result0=mysql_db_query($sql_db,$sql_recibida)){
		$numeroRegistros=mysql_num_rows($result0);
		if ($numeroRegistros==0){
			exit();
		} else {
			
			$fecha = date('Y-m-d H:i:s');
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=INVENTARIO_NEXTEL_$fecha.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			
		}
	?>
		<br><table align="center" style="font-size:12px" width="100%" cellspacing="0">
		<tr style="background-color:#FFFFFF; color:#000000; text-align:left; font-weight:bold; text-align:center;">
			<td height="20" colspan="<?=count($m_almacenes)*2+10?>"><?=$numeroRegistros;?> Productos en Inventario Nextel			</td>
		  </tr>
		<tr style="text-align:center; font-weight:bold;">
		  <td width="2%" rowspan="2">Id</td>
		  <td width="9%" rowspan="2" valign="bottom">Clave del Producto</td>
		  <td width="41%" rowspan="2">Descripci&oacute;n</td>
		  <td width="19%" rowspan="2">Especificaci&oacute;n</td>
		  <td width="6%" rowspan="2" valign="bottom">Control Almac&eacute;n</td>
		  <td width="6%" rowspan="2" valign="bottom">Ubicaci&oacute;n</td>
		  <td height="20" colspan="3" valign="bottom">Informaci&oacute;n para Analista del Almac&eacute;n </td>
		  <td width="6%" rowspan="2" valign="bottom">Status</td>
	  <?php for($i=0;$i<count($m_almacenes);$i++) { 
			$sql_nombre_almacenes="SELECT * FROM tipoalmacen where activo=1 AND id_almacen=".$m_almacenes[$i];
			$result_nombre_almacenes=mysql_db_query($sql_db,$sql_nombre_almacenes,$link);
			while($row_nombre_almacenes=mysql_fetch_array($result_nombre_almacenes)){
				echo "<td colspan='2'>&nbsp;".$row_nombre_almacenes["almacen"]."</td>";
			}						  

	  } ?>
		  </tr>
		<tr style="text-align:center; font-weight:bold;">
		  <td width="6%" height="20" valign="bottom">Costo Promedio</td>
			<td width="6%" valign="bottom">Entradas Totales </td>
			<td width="6%" valign="bottom">Salidas Totales </td>
			  <?php for($i=0;$i<count($m_almacenes);$i++) { 
					$sql_nombre_almacenes="SELECT * FROM tipoalmacen where activo=1 AND id_almacen=".$m_almacenes[$i];
					$result_nombre_almacenes=mysql_db_query($sql_db,$sql_nombre_almacenes,$link);
					while($row_nombre_almacenes=mysql_fetch_array($result_nombre_almacenes)){
						echo "<td width='3%'><a href='#' title='Existencias en el Almacen ".$row_nombre_almacenes["almacen"].".'>E</a></td>";
						echo "<td width='3%'><a href='#' title='Transferencias en el Almacen ".$row_nombre_almacenes["almacen"].".'>T</a></td>";
					}						  
			  } ?>			
			<!--
			<td width="3%"><a href="#" title="Existencias en el Almacen General.">E</a></td>
			<td width="4%"><a href="#" title="Transferencias en el Almacen General.">T</a></td>
			<td width="3%"><a href="#" title="Existencias en el Almacen de Material no Conforme.">E</a></td>
			<td width="5%"><a href="#" title="Transferencias en el Almacen de Material no Conforme.">T</a></td>
			//-->
		  </tr>
		<?php 
			while($row=mysql_fetch_array($result0)){
				$idp=$row["id"];
				// ENTRADAS POR MES ...
				$sql1="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_e
				FROM mov_almacen, prodxmov, concepmov
				WHERE mov_almacen.id_mov = prodxmov.nummov
				AND prodxmov.id_prod =$idp
				AND mov_almacen.tipo_mov = concepmov.id_concep
				AND concepmov.tipo = 'Ent'
				ORDER BY mov_almacen.id_mov";
				$result1=mysql_db_query($sql_db,$sql1);	
				$ndrx=mysql_num_rows($result1);
				while ($registro1=mysql_fetch_array($result1))
				{
					$sumaE=$registro1["suma_total_mensual_e"];
					if ($sumaE=="") $sumaE=0; 
				}
				// SALIDAS POR MES ...
				$sql2="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_e
				FROM mov_almacen, prodxmov, concepmov
				WHERE mov_almacen.id_mov = prodxmov.nummov
				AND prodxmov.id_prod =$idp
				AND mov_almacen.tipo_mov = concepmov.id_concep
				AND concepmov.tipo = 'Sal'
				ORDER BY mov_almacen.id_mov";
				$result2=mysql_db_query($sql_db,$sql2);	
				$ndrx2=mysql_num_rows($result2);
				while ($registro2=mysql_fetch_array($result2))
				{
					$sumaS=$registro2["suma_total_mensual_e"];
					if ($sumaS=="") $sumaS=0; 
				}				
			
			
		?>	
			<tr>
			  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
				<td class="td1" align="right"><?=$row["control_alm"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["ubicacion"]?></td>
				<td class="td1" align="right"><?=$row["cpromedio"]?></td>
				<td class="td1" align="right"><?=$sumaE?></td>
				<td class="td1" align="right"><?=$sumaS?></td>
				<td class="td1" align="right"><?php 
	if ($row["status1"]==0) echo "USO CONSTANTE";
	if ($row["status1"]==1) echo "LENTO MOVIMIENTO";
	if ($row["status1"]==2) echo "OBSOLETO";
?></td>
				<?php for($i=0;$i<count($m_almacenes);$i++) { 
					$sql_nombre_almacenes="SELECT * FROM tipoalmacen where activo=1 AND id_almacen=".$m_almacenes[$i];
					$result_nombre_almacenes=mysql_db_query($sql_db,$sql_nombre_almacenes,$link);
					while($row_nombre_almacenes=mysql_fetch_array($result_nombre_almacenes)){
						echo "<td class='td1' align='right'>".$row["exist_".$row_nombre_almacenes["id_almacen"]]."</td>";
						echo "<td class='td1' align='right'>".$row["trans_".$row_nombre_almacenes["id_almacen"]]."</td>";
					}						  
				} ?>				
				<!--
				<td class="td1" align="right"><?=$row["exist_1"]?></td>
				<td class="td1" align="right"><?=$row["trans_1"]?></td>
				<td class="td1" align="right"><?=$row["exist_44"]?></td>
				<td class="td1" align="right"><?=$row["trans_44"]?></td>
				//-->
			  </tr>
		<?php 
			//($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
			}
		?>	
		</table>
		<br />
		
	<?php			
	} else {
		echo "<br>Error: el Sistema ha fallado, consulte el Administrador del Sistema.";
	}	
?>
