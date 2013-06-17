<?php 
exit();
include("../php/conectarbase.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Alta de un Producto o Servicio</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
</HEAD>
<BODY>
<?php 
	$color=="#D9FFB3";
$sql="SELECT id,id_prod,descripgral,exist_1,cpromedio FROM catprod  order by id"; 
$result=mysql_db_query($sql_db,$sql);
echo '<br>Resultados='.$ndr=mysql_num_rows($result);
?>
<br><table width="99%" border="0" align="center" cellspacing="0" style="border:#333333 1px solid;">
  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
    <td width="24">#</td>
    <td width="115">Clave del Producto</td>
    <td width="188">Descripci&oacute;n</td>
    <td width="385">SQL</td>
  </tr>
  <?

			while($row=mysql_fetch_array($result)){
$i=$row["id"];
$ip=$row["id_prod"];
$cp=$row["cpromedio"];
$ca=$row["exist_1"];
$insertar="INSERT INTO prodxmov (nummov,id_prod,cantidad,clave,cu,id) VALUES ('1','".$i."','".$ca."','".$ip."','".$cp."','NULL')";
if (!mysql_db_query($sql_db,$insertar))
	echo "<br>Error: ($i)";
?>
  <tr>
    <td height="20" align="center" bgcolor="<? echo $color; ?>" class="td1"><?= $i.'=='.$ca.'=='.$cp; ?></td>
    <td bgcolor="<? echo $color; ?>" class="td1">&nbsp;<?= $ip; ?></td>
    <td align="left" bgcolor="<? echo $color; ?>" class="td1">&nbsp;<?= $row["descripgral"]; ?></td>
    <td align="left" bgcolor="<? echo $color; ?>" class="td1">&nbsp;<? //$insertar;?></td>
  </tr>
  <? ($color=="#D9FFB3")?$color="#FFFFFF" : $color="#D9FFB3";
	} ?>
</table>

</BODY>
</HTML>
