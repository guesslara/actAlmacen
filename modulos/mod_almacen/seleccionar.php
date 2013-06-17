<?php 
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include("../php/conectarbase.php");
	
	// ===================================================================
	//print_r($_POST); //echo "<hr>zzzzzzzzzzz";		
	$act=$_POST['action'];
	$n1=$_POST['n1'];
	$color=="#D9FFB3";
	echo "&nbsp;";
	//exit();
	// ===================================================================
	if ($act=="ver_movimientos"){
	$sql="SELECT * FROM concepmov";
	$result=mysql_db_query($sql_db,$sql);

?>
  <table width="97%" border="0" cellspacing="1" cellpadding="0" align="center">
    <tr style="background-color: #333333; text-align:center; font-weight:bold; color:#FFFFFF;">
      <td colspan="5" height="20">Conceptos de Movimientos </td>
    </tr>
    <tr style="background-color: #cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="101">ID</td>
      <td width="447">Concepto</td>
      <td width="174">Cuenta</td>
      <td width="149">Asociado</td>
      <td width="119">Tipo</td>
    </tr>
    <?
	
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
    <td align="center" bgcolor="<? echo $color; ?>"><?= $row["id_concep"]; ?></td>
      <td bgcolor="<? echo $color; ?>">
	  	<a style="text-decoration:none;" href="javascript:coloca_datos3('<?= $row["id_concep"]; ?>','<?= $row["asociado"]; ?>','<?= $row["concepto"]; ?>','<?= $row["tipo"]; ?>')">
			 <?= $row["concepto"]; ?>
		</a></td>
      <td bgcolor="<? echo $color; ?>"><?= $row["cuenta"]; ?></td>
      <td bgcolor="<? echo $color; ?>"><?= $row["asociado"]; ?></td>
      <td bgcolor="<? echo $color; ?>"><?= $row["tipo"]; ?></td>
    </tr>
    <?
	if ($color=="#D9FFB3") 
		$color="#FFFFFF";
	else 
		$color="#D9FFB3";
	}
?>
  </table>
  
  <?php } 
  
  if($act=="ver_almacenes"){
  //echo "<br>Almacenes:";
	$sql="SELECT * FROM tipoalmacen";
	$result=mysql_db_query($sql_db,$sql);
?>
  <table width="97%" border="0" align="center" cellspacing="1">
    <tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
      <td colspan="2" height="20">Movimiento al Almac&eacute;n </td>
    </tr>
    <tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="93">ID</td>
      <td width="820">Almac&eacute;n</td>
    </tr>
    <?
	$color=="#D9FFB3";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
    <td bgcolor="<? echo $color; ?>" align="center"><?= $row["id_almacen"]; ?></td>
      <td bgcolor="<? echo $color; ?>"><a href="#" onclick="javascript:coloca_datos4('<?= $row["id_almacen"]; ?>','<?= $row["almacen"]; ?>');"> <?= $row["almacen"]; ?></a></td>
    </tr>
    <?
		($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
	}
?>
  </table>
  
  
  
  <?php
  } 
 
 
 
   	if ($n1=="Proveedor")
	{
		//echo "<br><br>Lista de proveedores. ...";
		$sql="SELECT id_prov,nr  FROM catprovee";
		$result=mysql_db_query($dbcompras,$sql);
		?>
		<br /><table align="center" width="95%" cellspacing="0">
		<tr>
			<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Proveedores</td>
		  </tr>		
		<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
			<td width="10%">ID</td>
			<td width="90%">Proveedor</td>
		</tr>
		<?php while($row=mysql_fetch_array($result)){ ?>
		<tr bgcolor="<?=$color;?>">
			<td align="center">&nbsp;<?=$row["id_prov"];?></td>
			<td>&nbsp;<a href="javascript:coloca_datos5('<?=$row["id_prov"];?>','<?=$row["nr"];?>');"><?=$row["nr"];?></a></td>
		</tr>
		<?php 
			($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
		} ?>		
		</table>
		<?php
	}

 
 
  
if($act=="ver_asociado")
{
  	//echo "&nbsp;";
	
	if ($n1=="Almacenes"){
		//echo "<br><br>Lista de Almacenes. ...";
		
			/*$sql="SELECT * FROM tipoalmacen where  id_almacen<>'$alm_operado' ";
			if ($_GET['id_tipomov']==7)
			{*/
			$sql="SELECT * FROM tipoalmacen ORDER BY id_almacen ";
			//}		
		$result=mysql_db_query($sql_db,$sql);
		?>
		<table align="center" width="97%">
		<tr>
			<td colspan="2" height="20" style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">Almac&eacute;nes</td>
		  </tr>		
		<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
			<td width="10%">ID</td>
			<td width="90%">Almac&eacute;n</td>
		</tr>
		<?php while($row=mysql_fetch_array($result)){ ?>
		<tr bgcolor="<?=$color;?>">
			<td align="center">&nbsp;<?=$row["id_almacen"];?></td>
			<td>&nbsp;<a href="javascript:coloca_datos5('<?=$row["id_almacen"];?>','<?=$row["almacen"];?>');"><?=$row["almacen"];?></td>
		</tr>
		<?php 
			($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
		} ?>		
		</table>
		<?php
	} 
	
	if ($n1=="Ninguno"){
		echo "<br /><br /><br /><div align=center><a href=\"#\" style=\"text-decoration:none; font-size:15px; text-align:center; margin-top:30px;\" onclick=\"javascript:coloca_datos5('0','Ninguno');\">El movimiento seleccionado no va asociado a ningun elemento. Por favor de clic aqui para colocar el valor y Cerrar Ventana</a></div>";
	} 
	
	if ($n1=="Cliente"){
		echo "<br /><br /><div align=center>No es posible realizar movimientos relacionados con Clientes. <br>Seleccione otro movimiento.</div> ";
	}

	
	

  } 
    
  ?>
  