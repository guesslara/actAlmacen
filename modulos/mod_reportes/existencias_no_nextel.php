<?php 
	session_start();
	include ("../conf/conectarbase.php");
	
	$sql="SELECT id,id_prod,descripgral,especificacion,control_alm,linea,observa,unidad,cpromedio, 
	exist_1,trans_1, (exist_1+trans_1) AS te1,
	exist_43,trans_43, (exist_43+trans_43) AS te43, 
	exist_44,trans_44, (exist_44+trans_44) AS te44, 
	(exist_1+trans_1+exist_43+trans_43+exist_44+trans_44) AS existencias_totales,
	((exist_1+trans_1+exist_43+trans_43+exist_44+trans_44)*cpromedio) AS `total_dinero` 
	FROM `catprod` 
	WHERE linea<>'NX' ORDER BY id";
	
	if (!$result=mysql_db_query($sql_db,$sql)){		
		?>
		<div style="text-align:center; font-weight:bold; font-size:16px;">Error en la consulta a la Base de Datos.</div>
		<?php
		exit();
	}
	$ndr=mysql_num_rows($result);
	$color="#ffffff";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<? include("../menu/menu.php"); ?>
	
<div><a href="existencias_no_nextel_excel.php" style=" text-decoration:none;">&nbsp;Exportar a Excel</a></div><br />
<table align="center" width="auto" style="border:#000000 2px solid;" cellspacing="0" cellpadding="1">
  <tr style="text-align:center; font-weight:bold; font-size:14px; background-color:#333333; color:#FFFFFF;">
    <td height="20" colspan="15" style="border-bottom:#000000 2px solid;">CAT&Aacute;LOGO DE PRODUCTOS NO NEXTEL (<?=$ndr?> Resultados)</td>
  </tr>
  <tr style="text-align:center; font-weight:bold; font-size:11px; background-color:#CCCCCC;">
    <td rowspan="2" style="border-bottom:#000000 2px solid;">ID</td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">CLAVE</td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">DESCRIPCI&Oacute;N</td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">ESPECIFICACI&Oacute;N</td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">CONTROL ALM </td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">L&Iacute;NEA</td>
    <td rowspan="2" style="border-bottom:#000000 2px solid; border-right:#000000 2px solid;">UNIDAD</td>
    <td colspan="3" style=" border-right:#000000 1px solid; border-bottom:#000000 1px solid;">1. ALM. GENERAL </td>
    <td colspan="3" style=" border-right:#000000 1px solid; border-bottom:#000000 1px solid;">44. ALM MATERIAL NO CONFORME </td>
    <td rowspan="2" style="border-bottom:#000000 2px solid;">EXISTENCIAS TOTALES </td>
  </tr>
  <tr>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; background-color:#CCCCCC;">EXIST.</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; background-color:#CCCCCC;">TRANS</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; border-right:#CCCCCC 1px solid; background-color:#CCCCCC;">TOTAL_1</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; background-color:#CCCCCC;">EXIST</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; background-color:#CCCCCC;">TRANS</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; border-bottom:#000000 2px solid; border-right:#CCCCCC 1px solid; background-color:#CCCCCC;">TOTAL_44</td>
  </tr>
  <?php while ($row=mysql_fetch_array($result)) {  ?>
  <tr bgcolor="<?=$color?>">
    <td style=" border-right:#CCCCCC 1px solid;"><?=$row["id"]?></td>
    <td style=" border-right:#CCCCCC 1px solid;">&nbsp;<?=$row["id_prod"]?></td>
    <td style=" border-right:#CCCCCC 1px solid;">&nbsp;<?=$row["descripgral"]?></td>
    <td style=" border-right:#CCCCCC 1px solid;">&nbsp;<?=$row["especificacion"]?></td>
    <td style=" border-right:#CCCCCC 1px solid;">&nbsp;<?=$row["control_alm"]?></td>
    <td style=" border-right:#CCCCCC 1px solid;">&nbsp;<?=$row["linea"]?></td>
    <td style=" border-right:#000000 2px solid;">&nbsp;<?=$row["unidad"]?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?php echo $row["exist_1"]; $texist_1+=$row["exist_1"]; ?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?php echo $row["trans_1"]; $ttrans_1+=$row["trans_1"]; ?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><b><?php echo $row["te1"]; $tte1+=$row["te1"]; ?></b></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?php echo $row["exist_44"]; $texist_44+=$row["exist_44"]; ?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?php echo $row["trans_44"]; $ttrans_44+=$row["trans_44"]; ?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><b><?php echo $row["te44"]; $tte44+=$row["te44"]; ?></b></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><b><?php echo $row["existencias_totales"]; $texistencias_totales+=$row["existencias_totales"]; ?></b></td>
  </tr>
  <?php 	($color=="#ffffff")? $color="#D9FFB3" : $color="#ffffff"; } mysql_free_result($result); ?>
  <tr bgcolor="<?=$color?>" style="font-weight:bold; font-size:14px; text-align:right;">
    <td colspan="7" style=" border-right:#000000 2px solid;">TOTAL</td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$texist_1?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$ttrans_1?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$tte1?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$texist_44?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$ttrans_44?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$tte44?></td>
    <td style=" border-right:#CCCCCC 1px solid; text-align:right;"><?=$texistencias_totales?></td>
  </tr>  
</table>
<br /><br />
</body>
</html>
