<?php 
	$fecha = date('Y-m-d H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=CATALOG DE PRODUCTOS NEXTEL $fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");		
			
			
	include ("../conf/conectarbase.php");
	$sql="SELECT id,id_prod,descripgral,especificacion,control_alm,linea,observa,unidad,cpromedio, 
	exist_1,trans_1, (exist_1+trans_1) AS te1,
	exist_43,trans_43, (exist_43+trans_43) AS te43, 
	exist_44,trans_44, (exist_44+trans_44) AS te44, 
	(exist_1+trans_1+exist_43+trans_43+exist_44+trans_44) AS existencias_totales,
	((exist_1+trans_1+exist_43+trans_43+exist_44+trans_44)*cpromedio) AS `total_dinero` 
	FROM `catprod` 
	ORDER BY id";
	
	if (!$result=mysql_db_query($sql_db,$sql)){		
		?>
		<div style="text-align:center; font-weight:bold; font-size:16px;">Error en la consulta a la Base de Datos.</div>
		<?php
		exit();
	}
	$ndr=mysql_num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table align="center" width="auto" cellspacing="0" cellpadding="1">
  <tr style="text-align:left; font-weight:bold; text-align:center; font-size:14px;">
    <td height="20" colspan="16" style="">CAT&Aacute;LOGO DE PRODUCTOS  (
    <?=$ndr?> Resultados) </td>
  </tr>
  <tr style="text-align:center; font-weight:bold; font-size:11px;">
    <td rowspan="2" style="">ID</td>
    <td rowspan="2" style="">CLAVE</td>
    <td rowspan="2" style="">DESCRIPCI&Oacute;N</td>
    <td rowspan="2" style="">DESC.INGL&Eacute;S </td>
    <td rowspan="2" style="">ESPECIFICACI&Oacute;N</td>
    <td rowspan="2" style="">CONTROL ALM </td>
    <td rowspan="2" style="">L&Iacute;NEA</td>
    <td rowspan="2" style=" ">UNIDAD</td>
    <td colspan="3" style=" ">1. ALM. GENERAL </td>
    <td colspan="3" style=" ">44. ALM MATERIAL NO CONFORME </td>
    <td rowspan="2" style="">EXISTENCIAS TOTALES </td>
  </tr>
  <tr>
    <td style="text-align:center; font-weight:bold; font-size:11px; ">EXIST.</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; ">TRANS</td>
    <td style="text-align:center; font-weight:bold; font-size:11px;   ">TOTAL_1</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; ">EXIST</td>
    <td style="text-align:center; font-weight:bold; font-size:11px; ">TRANS</td>
    <td style="text-align:center; font-weight:bold; font-size:11px;  ">TOTAL_44</td>
  </tr>
  <?php while ($row=mysql_fetch_array($result)) {  ?>
  <tr>
    <td ><?=$row["id"]?></td>
    <td >&nbsp;<?=$row["id_prod"]?></td>
    <td >&nbsp;<?=$row["descripgral"]?></td>
    <td >&nbsp;<?=$row["observa"]?></td>
    <td >&nbsp;<?=$row["especificacion"]?></td>
    <td >&nbsp;<?=$row["control_alm"]?></td>
    <td >&nbsp;<?=$row["linea"]?></td>
    <td style=" ">&nbsp;<?=$row["unidad"]?></td>
    <td style="  text-align:right;"><?=$row["exist_1"]?></td>
    <td style="  text-align:right;"><?=$row["trans_1"]?></td>
    <td style="  text-align:right;"><b>
      <?=$row["te1"]?>
    </b></td>
    <td style="  text-align:right;"><?=$row["exist_44"]?></td>
    <td style="  text-align:right;"><?=$row["trans_44"]?></td>
    <td style="  text-align:right;"><b>
      <?=$row["te44"]?>
    </b></td>
    <td style="  text-align:right;"><b><?=$row["existencias_totales"]?></b></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
