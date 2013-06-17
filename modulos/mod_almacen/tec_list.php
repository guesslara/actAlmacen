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
.style5 {font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 16px; }
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
.style8 {color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style10 {font-size: 12px}
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
-->
</style>
</head>
<script language="javascript" src="js/asistente.js"></script>
<script language="javascript">
function ponclave(clavetec){
	opener.document.form.clavetec.value = clavetec;
	opener.document.form.Clave.value = clavetec;
	window.close();
} 
</script>
<body>
<?
	//cargando Valores para combos
	include("../php/conectarbase.php");
	$sql="SELECT * FROM lineas";
	$result=mysql_db_query($sql_db,$sql);
?>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="4" bgcolor="#000066"><div align="center"><span class="Estilo51">Catalogo de  tecnologia </span></div></td>
  </tr>
  <tr>
    <td width="44" bgcolor="#CCCCCC" class="Estilo57"><div align="center">id</div></td>
    <td width="70" bgcolor="#CCCCCC"><span class="Estilo57">Clave</span></td>
    <td width="136" bgcolor="#CCCCCC"><label><span class="Estilo57">Tecnologia</span></label></td>
    <td width="529" bgcolor="#CCCCCC"><span class="Estilo57">Obsevaciones</span></td>
  </tr>
  <?
	$color=="#D9FFB3";	
	$i=1;
	while($row=mysql_fetch_array($result)){
?>
  <tr>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><div align="center"><span class="Estilo57">
      <?=$row[0];?>
    </span></div></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><div align="center"><span class="Estilo57">
      <?=$row[1];?>
    </span></div></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><a href="javascript:primerElemento('<?=$row[1];?>')"><?=$row[2];?> </a><span class="Estilo57">
      
    </span></td>
    <td bgcolor="<? echo $color; ?>" class="Estilo57"><span class="Estilo57">
      <?=$row[3];?>
    </span></td>
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
