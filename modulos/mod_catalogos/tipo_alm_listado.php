<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3);
		
	include("../conf/conectarbase.php");
	$sql="SELECT * FROM tipoalmacen WHERE es_almacen=1 and activo=1";
	$result=mysql_db_query($sql_db,$sql);
	$ndr=mysql_num_rows($result);
		
	$color=="#ffffff";
	$m_si_no=array("<span style='color:red;'>NO</span>","<span style='color:green;'>SI</span>");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php include("../menu/menuX.php"); ?>
<h3 align="center"><a href="<?=$_SERVER['PHP_SELF']?>">Cat&aacute;logo de Almacenes (<small><?=$ndr?> resultados</small>)</a></h3>
<table align="center" cellspacing="0" cellpadding="2" class="tabla1" width="800">
    <tr>
      <th>id</th>
	  <th>descripci&oacute;n</th>
	  <th>activo</th>
	  <th>es_almac&eacute;n?</th>
	  <th>es_centro_costo?</th>
	  <th>obs.</th>
    </tr>
	<?php while($row=mysql_fetch_array($result)){ ?>
		<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#D9FFB3';" onmouseout="this.style.background='#ffffff'">
		  <td align="center"><?=$row["id_almacen"]?></td>
		  <td><?=$row["almacen"]?></td>
		  <td align="center"><?=$m_si_no[$row["activo"]]?></td>
		  <td align="center"><?=$m_si_no[$row["es_almacen"]]?></td>
		  <td align="center"><?=$m_si_no[$row["es_centro_costo"]]?></td>
		  <td><a href="#" title="<?=$row["observ"]?>"><?=substr($row["observ"],0,25)?></a></td>
		</tr>
    	<?php
  		//($color=="#ffffff")?$color="#efefef":$color="#ffffff";
	}
	?>
  </table>
  <p>&nbsp;</p>
	<?php include("../f.php"); ?>
</body>
</html>