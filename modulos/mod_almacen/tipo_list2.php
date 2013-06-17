<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Equipo</title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:hover {
	color: #FF0000;
	text-decoration: underline;
}
a:visited {
	color: #333333;
	text-decoration: none;
}
.Estilo51 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo57 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
a:active {
	text-decoration: none;
}
.style2 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
</head>
<script language="javascript" src="js/asistente.js"></script>
<body>
<?
	$clavetipo=$_GET['n'];
	$clavep=$_GET['clavep'];
	//cargando Valores para combos
	include("../php/conectarbase.php");
	$sql="SELECT * FROM cat_tipoprod Where clavetec='$clavetipo'";
	$result=mysql_db_query($sql_db,$sql);
?>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#000066"><div align="center"><span class="Estilo51">Catalogo de  tecnologia </span></div></td>
  </tr>
  <tr>
    <td width="64" bgcolor="#CCCCCC" class="Estilo57"><div align="center"><strong>id</strong></div></td>
    <td width="100" bgcolor="#CCCCCC"><div align="center"><span class="style2">Clave Tecnologia</span></div></td>
    <td width="198" bgcolor="#CCCCCC"><strong>
      <label><span class="Estilo57">Descripcion</span></label>
    </strong></td>
    <td width="765" bgcolor="#CCCCCC"><span class="style2">Obsevaciones</span></td>
  </tr>
  <?
	$color=="#D9FFB3";	
	$i=1;
	while($row=mysql_fetch_array($result)){
?>
  <tr>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><div align="center">
      <?=$row[1];?>
    </div></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><div align="center">
      <?=$row[2];?>
    </a></div></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><span class="Estilo57"><a href="#" onclick="tercerElemento('<?= $row[1];?>','<?=$clavep;?>','<?= $row[3];?>')"><?=$row[3];?></a>      
    </span></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><?=$row[4];?></td>
  </tr>
  <?
	if ($color=="#D9FFB3") 
					$color="#FFFFFF";
				else 
					$color="#D9FFB3";
					$i=$i+1;
	}	
?>
  <tr>
    <td colspan="4" bgcolor="#000066"><div align="right" class="Estilo57">.</div></td>
  </tr>
</table>
<hr />
<p align="center" class="Estilo1">IQelectronics
</body>
</html>
