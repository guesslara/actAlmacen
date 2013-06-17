<?php include ("../php/conectarbase.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");

$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`control_alm`,`$cexi0`,`$ctra0` ";
$actual=$_SERVER['PHP_SELF'];
$color="#D9FFB3";
			
if ($_GET)
{
	//print_r($_GET);
// ==========================================================================

	(isset($_GET['campo']))? $campo=$_GET["campo"] : $campo='descripgral';
	(isset($_GET['cri']))? $cri=$_GET['cri'] : $cri='';
	(isset($_GET['orden']))? $orden=$_GET["orden"] : $orden='id_prod';		
	(isset($_GET['ascdes']))? $ascdes=$_GET["ascdes"] : $ascdes='ASC';
	(isset($_GET['op']))? $op=$_GET["op"] : $op='LIKE';
	if ($op=='LIKE'){
		$where=" WHERE $campo LIKE '%" . $cri . "%' "; 
	} else {
		$where=" WHERE $campo $op '" . $cri . "' ";
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
$sql="SELECT $lista_campos FROM catprod ".$where." ORDER BY ".$orden." ".$ascdes." LIMIT ".$limitInf.",".$tamPag; 
$result=mysql_db_query($sql_db,$sql);
?>
<div class="buscador">
	<div class="form_buscador" style=" width:500px;float:right; margin-bottom:2px; font-size:12px;">
		<input type="hidden" name="ndr1" id="ndr1" value="<?=$numeroRegistros;?>" />
		<input type="hidden" name="where1" id="where1" value="<?=str_replace("%","iqesisco",$where);?>" />
		
		<input type="hidden" name="txt_campo" id="txt_campo" value="descripgral" />		
		<input type="hidden" name="txt_op" id="txt_op" value="LIKE" />				
		<input type="hidden" name="txt_orden" id="txt_orden" value="<?=$orden;?>" />
		<input type="hidden" name="txt_ascdes" id="txt_ascdes" value="<?=$ascdes;?>" />		
		<input type="text" name="cri" id="txt_buscar" value="<?=$cri;?>" size="30" style="font-size:12px; text-align:center;  margin-top:0px;" />&nbsp;
		<input type="button" value="Buscar" onClick="javascript:buscar();" style=" font-size:12px;" />
	</div>





	<?php if ($numeroRegistros>$tamPag) {?>
	<div class="paginas" style="clear:both; margin-bottom:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	
	($ascdes=='ASC')? $ascdes2='Ascendente' : $ascdes2='Descendente';
	?>	
  	</div>
	</div>
	<?php } ?>	
	
	
	
	<br><table align="center" style="border:#000000 1px solid; font-size:12px" width="100%" cellspacing="0">

	<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
		<td height="20" colspan="6"><?=$numeroRegistros;?> Productos en el Almac&eacute;n <?=$nalm0?> </td>
      </tr>
	<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
		<td width="12%" height="20">
			<a alt="Ordenar por Id" title="Ordenar por Clave del producto (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','id_prod','<?=$ascdes?>','<?=$pagina?>');">Clave del Producto </a>		</td>
		<td width="34%">
		<a alt="Ordenar por Descripci&oacute;n" title="Ordenar por Descripci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','descripgral','<?=$ascdes?>','<?=$pagina?>');">Descripci&oacute;n</a></td>
		<td width="27%">
		<a alt="Ordenar por Especificaci&oacute;n" title="Ordenar por Especificaci&oacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','especificacion','<?=$ascdes?>','<?=$pagina?>');">Especificaci&oacute;n</a></td>
		<td width="13%">
		<a alt="Ordenar por Control de Almac&eacute;n" title="Ordenar por Control de Almac&eacute;n (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','control_alm','<?=$ascdes?>','<?=$pagina?>');">
		Control de Almac&eacute;n</a></td>
		<td width="6%">
		<a alt="Ordenar por Control de Existencias" title="Ordenar por Existencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','<?=$cexi0?>','<?=$ascdes?>','<?=$pagina?>');">
		Existencias</a></td>
		<td width="8%">
		<a alt="Ordenar por Control de Transferencias" title="Ordenar por Transferencias (<?=$ascdes2?>)" href="#" onclick="javascript:paginar('<?=$campo?>','<?=$op?>','<?=$cri?>','<?=$ctra0?>','<?=$ascdes?>','<?=$pagina?>');">
		Transferencias</a></td>
	  </tr>
<?php 
	while($row=mysql_fetch_array($result)){
?>	
	<tr bgcolor="<? echo $color; ?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:ver_producto('<?=$row["id"];?>');" style="cursor:pointer;">
		<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
		<td class="td1" align="left">&nbsp;<?=$row["control_alm"]?></td>
		<td class="td1" align="right"><?=$row[$cexi0]?>&nbsp;</td>
		<td class="td1" align="right"><?=$row[$ctra0]?>&nbsp;</td>
	  </tr>
<?php 
	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
?>	
	</table><br />

	<?php if ($numeroRegistros>$tamPag) {?>
	<div class="paginador"> 
	<?php 
	if($pagina>1) 
		echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina-1)."');\"> <<&nbsp;</a> "; 		    	
    for($i=$inicio;$i<=$final;$i++) 
    { 
		if ($i<10) $i2='0'.$i; else $i2=$i;
		if($i==$pagina) 
       		echo "<a href='#'  class='pagact'>".$i2."</a>"; 
       	else 
        	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".$i."');\"> ".$i2."&nbsp;</a> "; 
	} 
    if($pagina<$numPags) 
       	echo "<a class='paginador1' href=\"#\" onclick=\"javascript:paginar('".$campo."','".$op."','".$cri."','".$orden."','".$ascdes."','".($pagina+1)."');\"> >>&nbsp;</a> "; 		
	?>	
  	</div>
	<div class="paginas" style="clear:both; margin-top:4px; font-weight:normal;">P&aacute;ginas ( <?=$pagina."/".$numPags;?> )</div>
	</div>
	<?php } ?>	



	
	<?php
	exit();
}
?>