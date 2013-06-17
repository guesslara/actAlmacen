<?php include ("../conf/conectarbase.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("pagma: no-cache");
header("Content-Type: text/xml; charset=ISO-8859-1");
$lista_campos=" `id`,`id_prod`,`descripgral`,`especificacion`,`linea`,`marca`,`control_alm`,`ubicacion`,`uni_entrada`,`uni_salida`,`stock_min`,`stock_max`,`observa`,`unidad`,`tipo`,`kit`,`cpromedio`,`$calm0`,`$cexi0`,`$ctra0` ";
?>

<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.gris{ background-color:#CCCCCC; font-weight:bold; text-align:right; padding-right:2px;}
	.valor1{ background-color:#ffffff; font-weight:normal; font-size:16px; text-align:left; padding-left:2px;
	border-bottom:#CCCCCC 1px solid; }
 .td1{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ border-right:#cccccc 1px solid;}
 .td2{ padding:1px; font-size:12px; /*border-top:#333333 1px solid;*/ } 
</style>
<?php 
//print_r($_GET);
$id=$_GET['id'];
$desc=$_GET['desc'];
$esp=$_GET['esp'];
	$sql_cpy="SELECT $lista_campos FROM catprod WHERE `id`='$id' ";
	$r_cpy=mysql_db_query($sql_db,$sql_cpy);
	//echo "<br>NDR: ".mysql_num_rows($r_cpy);
		while($r1_cpy=mysql_fetch_array($r_cpy))
		{
			$id=$r1_cpy["id"];
			$de=$r1_cpy["descripgral"];
	  		$id_prod2=$r1_cpy['id_prod'];
		}

$sql_cardex="SELECT 
mov_almacen.id_mov, mov_almacen.oc, concepmov.id_concep, concepmov.concepto,concepmov.tipo,concepmov.asociado as asociado0,mov_almacen.asociado,mov_almacen.almacen, mov_almacen.fecha, prodxmov.id as id_item, prodxmov.cantidad, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion, catprod.id_prod, catprod.descripgral
FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov = concepmov.id_concep) INNER JOIN (catprod INNER JOIN prodxmov ON catprod.id_prod = prodxmov.clave) ON mov_almacen.id_mov = prodxmov.nummov
WHERE (((catprod.id)='$id')) 
ORDER BY mov_almacen.fecha ASC,prodxmov.id ASC";

$result2=mysql_db_query($sql_db,$sql_cardex);
$ndrr=mysql_num_rows($result2);
if ($ndrr<=0)
{
	?>
	<div style="font-size:15px; font-weight:bold; text-align:center; margin-top:5px; color:#000000;">El producto <?=$id?> no presenta Movimientos.</div>
	<?php
	exit();
}
?>
<br />
	<table width="95%" align="center" style="font-size:12px; border:#333333 2px solid;" cellpadding="0" cellspacing="0">
      <tr style="background-color:#333333; text-align:center; font-weight:bold; padding:2px; color:#FFFFFF;">
        <td colspan="10" height="20" valign="middle"><?=mysql_num_rows($result2);?>
          Movimiento(s) del Producto:
          <?=$id_prod2;?></td>
      </tr>
      <tr style="background-color:#cccccc; text-align:center; font-weight:bold; padding:2px; color:#000000;">
        <td width="20">#</td>
        <td width="47" height="auto"> MOV </td>
        <td width="236">TIPO DE MOVIMIENTO</td>
        <td width="90">ALMAC&Eacute;N</td>
        <td width="251">ASOCIADO</td>
        <td width="113">FECHA</td>
        <td width="71"><p>CANTIDAD<br />
        </p></td>
        <td width="68">EXISTEN</td>
        <td width="68"><a href="#" title="Ubicacion">UBIC.</a></td>
        <td width="68">COSTO_$ </td>
      </tr>
      <?php 
	  $color="#FFFFFF";
	  while ($row2=mysql_fetch_array($result2)) 
	  {
/*
	  print_r($row2); 
	  echo "<hr>";
*/
	  $id_concep=$row2['id_concep'];
	  $concep=$row2['concepto'];
	  $asociado=$row2['asociado0'];
	  $id_asociado=$row2['asociado'];
	  $aso2="";
	  $oc="";
	  if ($asociado=="Proveedor") // Compras o Dev / compras... Cat de proveedores ...
	  {
		$sql3="SELECT id_prov,nr FROM catprovee WHERE id_prov='$id_asociado' ";
		$result3=mysql_db_query($dbcompras,$sql3);
		$row3=mysql_fetch_array($result3);
		//$aso2_0=$row3["nr"];
		$aso2_0="";
		$aso2x="<a href='#' title='".$row3["nr"]."'>No. $id_asociado </a>";	
		$oc=$row2['oc'];	  	
	  } elseif ($asociado=="Almacenes") // Almacenes ...
	  {
			$sql_aso2="SELECT id_almacen,almacen FROM `tipoalmacen` WHERE `id_almacen`='$id_asociado'";
			$result_aso2=mysql_db_query($sql_db,$sql_aso2);	
			while($row_aso2=mysql_fetch_array($result_aso2)){	
				$aso2a=$row_aso2["id_almacen"];
				$aso2b=$row_aso2["almacen"];
				$aso2x="<a href='#' title='$aso2b'>No. $id_asociado </a>";	
			}	  	
	  }else{
	  	$aso2x="<a href='#' title='$id_asociado'>No. $id_asociado </a>";
	  
	  }
	  
	  //echo "<br>ID CONC ($id_concep - $concep) ASOCIADO ($asociado - $aso2)";
	  ?>
      <tr style="background-color:<?=$color;?>;">
        <td height="20" style="text-align:center; border-right:#CCCCCC 1px solid;"><?=$row2["id_item"];?></td>
        <td align="center" class="td1"><?=$row2["id_mov"];?></td>
        <td class="td1" align="left">&nbsp;
            <?php if ($row2["concepto"]=="Compras"){ echo $row2["concepto"]." (OC:$oc)"; } else { echo $row2["concepto"]; }?></td>
        <td align="left" class="td1">&nbsp;
            <?php
		$sql_alm0="SELECT id_almacen,almacen FROM tipoalmacen WHERE id_almacen=".$row2["almacen"]." ORDER BY id_almacen";
		$result_alm0=mysql_db_query($sql_db,$sql_alm0);
		while ($row_alm0=mysql_fetch_array($result_alm0))
		{ 
			$id_almacenx=$row_alm0["id_almacen"];
			$almacenx=$row_alm0["almacen"];
		}			
		//$row2["almacen"];
		?>
            <a href="#" title="<?=$almacenx?>">No.
              <?=$id_almacenx?>
            </a> </td>
        <td align="left" class="td1">&nbsp;
            <?php
			echo $asociado." (".$aso2x.")";
			$asociado="";
			$aso2x="";
			
		
		?></td>
        <td align="right" class="td1"><?=$row2["fecha"];?></td>
        <td align="right" class="td1" ><?php 
		if ($row2["tipo"]=="Ent")
		{
			echo "+".$row2["cantidad"];
			$total_entrada+=$row2["cantidad"];
		} elseif ($row2["tipo"]=="Sal") {
			echo "-".$row2["cantidad"];
			$total_salida+=$row2["cantidad"];
		} else {
			echo $row2["cantidad"];
		}	
	?></td>
        <td align="right" class="td1">&nbsp;<?php
		if ($row2["tipo"]=="Ent"){
			echo $row2["existen"];
		} 	
		?></td>
        <td align="right" class="td1">&nbsp;<?=$row2["ubicacion"]?></td>
        <td align="right" class="td1"><?=number_format($row2["cu"],2,'.',',')?></td>
      </tr>
      <?php 
	  ($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
	  } ?>
      <tr style="background-color: #333333; color:#FFFFFF; font-weight:bold;">
        <td>&nbsp;</td>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right" class="">TOTAL&nbsp;&nbsp;</td>
        <td align="right" class="" ><?=$total_entrada-$total_salida;?></td>
        <td align="right" class="">&nbsp;</td>
        <td align="right" class="">&nbsp;</td>
        <td align="right" class="">&nbsp;</td>
      </tr>
    </table>
	