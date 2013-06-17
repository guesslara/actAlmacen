<?php 
	session_start();
	include ("../conf/conectarbase.php");
	$color="#ffffff";

	$sql0="SELECT 
	sum(((exist_1+trans_1)*cpromedio)+((exist_43+trans_43)*cpromedio)+((exist_44+trans_44)*cpromedio)) AS total_dinero_00,
	sum((exist_1+trans_1)*cpromedio) AS total_dinero_01,
	sum((exist_43+trans_43)*cpromedio) AS total_dinero_043,
	sum((exist_44+trans_44)*cpromedio) AS total_dinero_044
	FROM `catprod` ORDER BY id";	
	if (!$result0=mysql_db_query($sql_db,$sql0)){		
		?>
		<div style="text-align:center; font-weight:bold; font-size:16px;">Error en la consulta a la Base de Datos.</div>
		<?php
		exit();
	}

	while ($row0=mysql_fetch_array($result0)) {  
	//echo "<br>";
	//print_r($row);
	$t0=$row0["total_dinero_00"];
	$t1=$row0["total_dinero_01"];
	$t43=$row0["total_dinero_043"];
	$t44=$row0["total_dinero_044"];
	}


	$sql="SELECT 
	sum(((exist_1+trans_1)*cpromedio)+((exist_43+trans_43)*cpromedio)+((exist_44+trans_44)*cpromedio)) AS total_dinero_0,
	sum((exist_1+trans_1)*cpromedio) AS total_dinero_1,
	sum((exist_43+trans_43)*cpromedio) AS total_dinero_43,
	sum((exist_44+trans_44)*cpromedio) AS total_dinero_44
	FROM `catprod` 
	WHERE linea='NX' ORDER BY id";	
	if (!$result=mysql_db_query($sql_db,$sql)){		
		?>
		<div style="text-align:center; font-weight:bold; font-size:16px;">Error en la consulta a la Base de Datos.</div>
		<?php
		exit();
	}

	while ($row=mysql_fetch_array($result)) {  
	//echo "<br>";
	//print_r($row);
	$tnx0=$row["total_dinero_0"];
	$tnx1=$row["total_dinero_1"];
	$tnx43=$row["total_dinero_43"];
	$tnx44=$row["total_dinero_44"];
	}

	$sql2="SELECT 
	sum(((exist_1+trans_1)*cpromedio)+((exist_43+trans_43)*cpromedio)+((exist_44+trans_44)*cpromedio)) AS total_dinero_0,
	sum((exist_1+trans_1)*cpromedio) AS total_dinero_1,
	sum((exist_43+trans_43)*cpromedio) AS total_dinero_43,
	sum((exist_44+trans_44)*cpromedio) AS total_dinero_44
	FROM `catprod` 
	WHERE linea<>'NX' ORDER BY id";	
	if (!$result2=mysql_db_query($sql_db,$sql2)){		
		?>
		<div style="text-align:center; font-weight:bold; font-size:16px;">Error en la consulta a la Base de Datos.</div>
		<?php
		exit();
	}

	while ($row2=mysql_fetch_array($result2)) {  
	//echo "<br>";
	//print_r($row);
	$tnonx0=$row2["total_dinero_0"];
	$tnonx1=$row2["total_dinero_1"];
	$tnonx43=$row2["total_dinero_43"];
	$tnonx44=$row2["total_dinero_44"];
	}
	
	
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style type="text/css">
	body, document { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; }
	.tda { border-bottom:#efefef 1px solid; border-right:#efefef 1px solid;}
	.tdb { border-bottom:#efefef 1px solid;}
	.td2 { border-right:#efefef 1px solid;}
</style>
</head>

<body>
<? include("../menu/menu.php"); ?>
<h3 align="center">Reporte de valor en existencias del  Inventario IQe.</h3>


  <h4 align="center">Existencias Generales. <a href="existencias_generales_totales_excel.php" title="Exportar a Microsoft Excel y Ver detalles." style="font-size:11px; text-decoration:none;">Exportar &raquo;</a> </h4>
  <table width="400" align="center" style="border:#333333 2px solid;">
    
    <tr style="text-align:center; font-weight:bold;">
      <td width="179" class="tda">Almac&eacute;n</td>
      <td width="193" class="tdb">Monto $ </td>
    </tr>
    <tr>
      <td class="tda">General</td>
      <td align="right" class="tdb">$<?=number_format($t1,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Tr&aacute;nsito</td>
      <td align="right" class="tdb">$<?=number_format($t43,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Material No Conforme </td>
      <td align="right" class="tdb">$<?=number_format($t44,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr style="font-weight:bold;">
      <td class="td2">Total</td>
      <td align="right">$<?=number_format($t0,4,'.',',')?>&nbsp;</td>
    </tr>
</table>
  
  <br /><h4 align="center">Existencias  Nextel <a href="existencias_nextel.php" style="text-decoration:none; font-size:12px;" title="Ver detalle."> Ver mas &raquo;</a></h4>
  <table width="400" align="center" style="border:#333333 2px solid;">
    
    <tr style="text-align:center; font-weight:bold;">
      <td width="179" class="tda">Almac&eacute;n</td>
      <td width="193" class="tdb">Monto $ </td>
    </tr>
    <tr>
      <td class="tda">General</td>
      <td align="right" class="tdb">$<?=number_format($tnx1,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Tr&aacute;nsito</td>
      <td align="right" class="tdb">$<?=number_format($tnx43,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Material No Conforme </td>
      <td align="right" class="tdb">$<?=number_format($tnx44,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr style="font-weight:bold;">
      <td class="td2">Total</td>
      <td align="right">$<?=number_format($tnx0,4,'.',',')?>&nbsp;</td>
    </tr>
</table>
  
  <br /><h4 align="center">Existencias NO Nextel <a href="existencias_no_nextel.php" style="text-decoration:none; font-size:12px;" title="Ver detalle."> Ver mas &raquo;</a></h4>
  <table width="400" align="center" style="border:#333333 2px solid;">
    
    <tr style="text-align:center; font-weight:bold;">
      <td width="179" class="tda">Almac&eacute;n</td>
      <td width="193" class="tdb">Monto $ </td>
    </tr>
    <tr>
      <td class="tda">General</td>
      <td align="right" class="tdb">$<?=number_format($tnonx1,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Tr&aacute;nsito</td>
      <td align="right" class="tdb">$<?=number_format($tnonx43,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr>
      <td class="tda">Material No Conforme </td>
      <td align="right" class="tdb">$<?=number_format($tnonx44,4,'.',',')?>&nbsp;</td>
    </tr>
    <tr style="font-weight:bold;">
      <td class="td2">Total</td>
      <td align="right">$<?=number_format($tnonx0,4,'.',',')?>&nbsp;</td>
    </tr>
</table> 
<br />
<p style=" position:relative; width:600px; left:50%; margin-left:-300px; background-color:#efefef; margin-top:20px; margin-bottom:20px; padding:5px 5px 5px 5px; border:#666666 2px solid; text-align:justify;">
<b>Nota importante:</b><br /><br />
Los n&uacute;meros reflejan montos aproximados que var&iacute;an de acuerdo al sistema de costeo utilizado en el Inventario (Costo Promedio). Si se desea obtener un reporte m&aacute;s preciso, vaya a reporte de &quot;Movimientos&quot;.
</p>
<br />
<? include("../f.php"); ?>
 
</body>
</html>
