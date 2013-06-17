<?php 
session_start();
include ("../conf/conectarbase.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
//print_r($_POST);

$actual=$_SERVER['PHP_SELF'];
$color="#D9FFB3";
	if ($_POST["action"]=="guardar_dei") { 
		//print_r($_POST);
		//echo "<br>".
		$sql_1="UPDATE catprod SET observa='".$_POST['dei']."' WHERE id=".$_POST['idp']." LIMIT 1";
		if (mysql_db_query($sql_db,$sql_1)){
			echo "&nbsp;La descripci&oacute;n guard&oacute; correctamente.";
			?><script language="javascript">$("#div_dei").hide();</script><?php
		} else {
			echo "&nbsp;Error: La descripci&oacute;n NO guard&oacute;.";
		}		
		exit();
	}

	if ($_POST["action"]=="modificar_status") { 
		$i=$_POST["idp"];
		$s=$_POST["nsp"];
		$sql_status="UPDATE catprod SET status1=$s WHERE id=$i LIMIT 1";
		if (mysql_db_query($sql_db,$sql_status)){
			echo "El status del producto se modifico correctamente.";
		} else {
			echo "Error del Sistema: El status del producto NO se modifico.";
		}
		exit();		
	}
	
	if ($_POST["action"]=="guardar_ubi") { 
		$i=$_POST["idp"];
		$u=$_POST["u"];
		//echo "<br>".
		$sql_ubi="UPDATE catprod SET ubicacion='$u' WHERE id=$i LIMIT 1";
		if (mysql_db_query($sql_db,$sql_ubi)){
			echo "Modificacion correcta.";
		} else {
			echo "Error del Sistema.";
		}
		exit();		
	}

	if ($_POST["accion_modificar"]) { 
		//print_r($_POST);
		
		$i=$_POST["idp"];
		$u=$_POST["u"];
		//echo "<br>".
		$sql_ubi="UPDATE catprod SET ".$_POST["campo"]."='".$_POST["Nuevo_Valor"]."' WHERE id=".$_POST["Producto"]." LIMIT 1";
		
		if (mysql_db_query($sql_db,$sql_ubi)){
			echo "<h4 align=center>Modificacion correcta.</h4>";
		} else {
			echo "Error del Sistema.";
		}
		
		exit();		
	}

if ($_GET["action"]=="ver_inventario_nextel") { 
	$modelo_nextel=$_GET["m"];
	$almacenes_asociados=$_GET["almacenes_asociados"];
	$m_almacenes=explode(',',$almacenes_asociados);
	foreach($m_almacenes as $id_almacen){
		$campo_existenciasX="exist_$id_almacen";
		$campo_transferenciasX="trans_$id_almacen";
		$sql_select_alm_asociados.=",`$campo_existenciasX`,`$campo_transferenciasX`";
	}
	if ($modelo_nextel=="*") {	$sql_modelo_nextel=""; } else {	$sql_modelo_nextel=" AND especificacion='$modelo_nextel' "; }
	//echo "<br>Modelo Nextel [$modelo_nextel] <br>";
	//a_1_General=1 AND a_43_Almacenentransito=1 AND a_44_Material_no_conforme=1
	//,`exist_1`,`trans_1` ,`exist_43`,`trans_43`,`exist_44`,`trans_44`,
	$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`ubicacion`,`cpromedio`,`status1`,`activo` $sql_select_alm_asociados ";	
	//echo "<br>".
	$sql_nextel="SELECT $lista_campos FROM catprod WHERE activo=1 AND linea='NX' AND length(control_alm)<4 $sql_modelo_nextel ORDER BY especificacion,id";
	$result0=mysql_db_query($sql_db,$sql_nextel);
	$numeroRegistros=mysql_num_rows($result0);
	
	
	$sql_nextel2=addslashes(str_replace('%','iqesiscojgrs',$sql_nextel));
	?>
	<br><table align="center" style="border:#000000 1px solid; font-size:12px" width="98%" cellspacing="0">

	<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
		<td height="20" colspan="<?=count($m_almacenes)*2+6?>"><?=$numeroRegistros;?> Productos activos en Inventario Nextel 
			&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
			[ <a href="../reportes/inventario_nextel_xls.php?sql=<?=$sql_nextel2?>&almacenes_asociados=<?=$almacenes_asociados?>" style="color:#FFFF00;">Exportar a Excel </a> ]		</td>
      </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	  <td height="20">&nbsp;</td>
	  <td width="9%" rowspan="2" valign="bottom">Clave del Producto</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td width="6%" rowspan="2" valign="bottom">Control Almac&eacute;n</td>
	  <td width="6%" rowspan="2" valign="bottom">Status</td>
	  <?php for($i=0;$i<count($m_almacenes);$i++) { 
			$sql_nombre_almacenes="SELECT * FROM tipoalmacen where activo=1 AND id_almacen=".$m_almacenes[$i];
			$result_nombre_almacenes=mysql_db_query($sql_db,$sql_nombre_almacenes,$link);
			while($row_nombre_almacenes=mysql_fetch_array($result_nombre_almacenes)){
				//echo "<option value='".$row_nombre_almacenes["id_"]."'>".$row_nombre_almacenes["especificacion"]."</option>";
				echo "<td colspan='2'>&nbsp;".$row_nombre_almacenes["almacen"]."</td>";
			
			}						  
		  ?>
		  <!--
		  <td colspan="2">General </td>
		  <td colspan="2">M. no Conforme </td>
		  //-->
	  <?php } ?>
	  </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	  <td width="2%" height="20">Id</td>
		<td width="41%">Descripci&oacute;n</td>
		<td width="19%">Especificaci&oacute;n</td>
	  <?php for($i=0;$i<count($m_almacenes);$i++) { 
			$sql_nombre_almacenes="SELECT * FROM tipoalmacen where activo=1 AND id_almacen=".$m_almacenes[$i];
			$result_nombre_almacenes=mysql_db_query($sql_db,$sql_nombre_almacenes,$link);
			while($row_nombre_almacenes=mysql_fetch_array($result_nombre_almacenes)){
				echo "<td width='3%'><a href='#' title='Existencias en el Almacen ".$row_nombre_almacenes["almacen"].".'>E</a></td>";
				echo "<td width='3%'><a href='#' title='Transferencias en el Almacen ".$row_nombre_almacenes["almacen"].".'>T</a></td>";
			}						  
	  } ?>		
	  </tr>
<?php 
	while($row=mysql_fetch_array($result0)){
?>	
	<tr bgcolor="<? echo $color; ?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:ver_producto(<?=$row["id"];?>);" style="cursor:pointer;">
	  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
		<td class="td1" align="right"><?=$row["control_alm"]?></td>
		<td class="td1" align="right"><?php 
	if ($row["status1"]==0) echo "&nbsp;USO.CONSTANTE";
	if ($row["status1"]==1) echo "&nbsp;LENTO.MOVIMIENTO";
	if ($row["status1"]==2) echo "&nbsp;OBSOLETO";
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
		<td class="td1" align="right"><?=$row["exist_1"]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row["trans_1"]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row["exist_44"]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row["trans_44"]?>&nbsp;</td>
		//-->
	  </tr>
<?php 
	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
?>	
	</table>
	<br />
	
	<?php
	exit();
}



























if ($_GET)
{
	//print_r($_GET);
// ==========================================================================
	(isset($_GET['almacen']))? $ialm=$_GET["almacen"] : $ialm=$idalm;
	(isset($_GET['campo']))? $campo=$_GET["campo"] : $campo='descripgral';
	(isset($_GET['cri']))? $cri=$_GET['cri'] : $cri='';
	(isset($_GET['orden']))? $orden=$_GET["orden"] : $orden='id';		
	(isset($_GET['ascdes']))? $ascdes=$_GET["ascdes"] : $ascdes='ASC';
	(isset($_GET['op']))? $op=$_GET["op"] : $op='LIKE';
	
	if($campo=="activo"){ 
		$condicion_activo="";
		($cri=="0")? $activo_titulo="NO" : $activo_titulo="";
	} else {	 
		$condicion_activo=" activo=1 AND ";
	}	
	
	
	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen WHERE id_almacen='$ialm'";
	$result0=mysql_db_query($sql_db,$sql_alm);
	while ($row0=mysql_fetch_array($result0))
	{ 
		$id_almacen=$row0["id_almacen"];
		$almacen=$row0["almacen"];
	}	
	$campo_almacen="a_".$ialm."_".$almacen;
	$campo_existencias="exist_".$ialm;	
	$campo_transferencias="trans_".$ialm;
	$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`status1`,`cpromedio`,`activo`,`$campo_existencias`,`$campo_transferencias` ";	
	if ($op=='LIKE'){
		$where=" WHERE $condicion_activo $campo LIKE '%" . $cri . "%' AND ".$campo_almacen."=1 "; 
	} else {
		$where=" WHERE $condicion_activo AND $campo $op '" . $cri . "' AND ".$campo_almacen."=1 "; 
	}
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	
	$sql_criterio="SELECT count(id) as total_registros FROM catprod ".$where;
	$result0=mysql_db_query($sql_db,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];
	$tamPag=25; 
    //pagina actual si no esta definida y limites 
    	if(!isset($_GET["pagina"])) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	} else { 	
			(isset($_GET["pagina"]))? $pagina = $_GET["pagina"] : $pagina=1; 
		} 
    $limitInf=($pagina-1)*$tamPag; 
    $numPags=ceil($numeroRegistros/$tamPag); 
    
		if(!isset($pagina)) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	}else{ 
       		$seccionActual=intval(($pagina-1)/$tamPag); 
       		$inicio=($seccionActual*$tamPag)+1; 
			if($pagina<$numPags) 
       			$final=$inicio+$tamPag-1; 
       		else 
          		$final=$numPags; 
       		
			if ($final>$numPags) $final=$numPags; 
	    }	
//echo "<br>[$sql_db]".
$sql="SELECT $lista_campos FROM catprod ".$where." ORDER BY ".$orden." ".$ascdes." LIMIT ".$limitInf.",".$tamPag; 
$result=mysql_db_query($sql_db,$sql);
?>
<div class="buscador">
	<div class="form_buscador" style=" width:500px;float:right; margin-bottom:2px; font-size:12px;">
		<input type="hidden" name="ndr1" id="ndr1" value="<?=$numeroRegistros;?>" />
		<input type="hidden" name="where1" id="where1" value="<?=str_replace("%","iqesisco",$where);?>" />
        <input type="hidden" name="txt_id_almacen1" id="txt_id_almacen1" value="<?=$ialm?>" />
        
		
		<input type="hidden" name="txt_almacen" id="txt_almacen" value="<?=$ialm?>" />	
		<input type="hidden" name="txt_campo" id="txt_campo" value="descripgral" />		
		<input type="hidden" name="txt_op" id="txt_op" value="LIKE" />				
		<input type="hidden" name="txt_orden" id="txt_orden" value="<?=$orden;?>" />
		<input type="hidden" name="txt_ascdes" id="txt_ascdes" value="<?=$ascdes;?>" />		
		<input type="text" name="cri" id="txt_buscar" value="<?=$cri;?>" size="30" style="font-size:12px; text-align:center;  margin-top:0px;"  onkeyup="busca_tecla_enter(1985,event,this.value)" title="Escriba su busqueda y presione 'Enter'" />&nbsp;
		<input type="button" value="Buscar" onClick="javascript:buscar();" style=" font-size:12px;" />
	</div>

	<?php 
	/*
	if ($numeroRegistros>$tamPag) {?>
	<div class="paginas" style="clear:both; margin-bottom:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\">&nbsp;&laquo;&nbsp;</a>"; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#' class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a>"; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> &nbsp;&raquo;&nbsp;</a>"; 		
	
	($ascdes=='ASC')? $ascdes2='Ascendente' : $ascdes2='Descendente';
	?>	
  	</div>
</div>
	<?php }
	*/
	 ?>	
	
	
	
	<br><br><table align="center" style="border:#000000 1px solid; font-size:12px" width="98%" cellspacing="0">

	<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
		<td height="20" colspan="8"><?=$numeroRegistros;?> Productos <u><?=$activo_titulo?> activos</u> en el Almac&eacute;n <?=$almacen?> </td>
      </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	  <td width="2%">
	  		<a alt="Ordenar por Id" title="Ordenar por Id (<?=$ascdes2?>)" href="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','id','<?=$ascdes?>','<?=$pagina?>');">Id </a>	  </td>
		<td width="13%" height="20">
			<a alt="Ordenar por Id" title="Ordenar por Clave del producto (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','id_prod','<?=$ascdes?>','<?=$pagina?>');">Clave del Producto </a>		</td>
		<td width="27%">
		<a alt="Ordenar por Descripci&oacute;n" title="Ordenar por Descripci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','descripgral','<?=$ascdes?>','<?=$pagina?>');">Descripci&oacute;n</a></td>
		<td width="20%">
		<a alt="Ordenar por Especificaci&oacute;n" title="Ordenar por Especificaci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','especificacion','<?=$ascdes?>','<?=$pagina?>');">Especificaci&oacute;n</a></td>
		<td width="12%">
		<a alt="Ordenar por Control de Almac&eacute;n" title="Ordenar por Control de Almac&eacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','control_alm','<?=$ascdes?>','<?=$pagina?>');">
		Control de Almac&eacute;n</a></td>
		<td width="15%">
		<a alt="Ordenar por Status" title="Ordenar por Status (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','status1','<?=$ascdes?>','<?=$pagina?>');">
		Status</a></td>
		<td width="5%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?=$campo_existencias?>','<?=$ascdes?>','<?=$pagina?>');">
		Exist.</a></td>
		<td width="6%">
		<a alt="Ordenar por Control de Transferencias" title="Ordenar por Transferencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$ialm?>','<?=$campo?>','<?=$op?>','<?=$cri?>','<?=$campo_transferencias?>','<?=$ascdes?>','<?=$pagina?>');">
		Transf.</a></td>
	  </tr>
<?php 
	while($row=mysql_fetch_array($result)){
?>	
	<tr id="<?=$row["id"]?>" class="m2" bgcolor="<? echo $color; ?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:ver_producto('<?=$row["id"];?>');" style="cursor:pointer;">
	  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["control_alm"]?></td>
		<td class="td1" align="left">
		<?php
			if ($row["status1"]==2)
			{
				echo "Obsoleto";	
			} else if($row["status1"]==1) {
				echo "Lento Movimiento";
			} else {
				echo "Uso Constante";
			}
			?></td>
		<td class="td1" align="right"><?=$row[$campo_existencias]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row[$campo_transferencias]?>&nbsp;</td>
	  </tr>
<?php 
	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
?>	
	</table>
	<br />

	<?php if ($numeroRegistros>$tamPag) {?>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\">&nbsp;&laquo;&nbsp;</a> "; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$ialm."','".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> &nbsp;&raquo;&nbsp;</a> "; 		
	?>	
  	</div>
	<div class="paginas" style="clear:both; margin-top:4px; font-weight:normal; font-size:10px;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	</div>
	<?php } ?>	



	
	<?php
	exit();
}

?>