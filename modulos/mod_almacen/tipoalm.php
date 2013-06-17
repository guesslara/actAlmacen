<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function ponclave(clave,tipo){ 
	opener.document.frm.id_almacen.value = clave 
	opener.document.frm.almacen.value = tipo 
	window.close() 
} 
function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
if (codigo==27)
 	self.close();
/*if (codigo==13)
	codigo js*/
}
document.onkeypress = cerrar;

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Catalogo de Productos</title>
<style type="text/css">
<!--
body { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:left;}
a{ text-decoration:none;}
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.style10 { font-weight:bold; text-align:center;}
-->
</style>
</head>

<body>
<br />
<?
	include("../php/conectarbase.php");
	$sql="SELECT * FROM tipoalmacen";
	$result=mysql_db_query($sql_db,$sql);
?>
<form id="form1" name="form1" method="post" action="">
  <table width="95%" border="0" align="center" cellspacing="1">
    <tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
      <td colspan="2">Movimiento al Almacén </td>
    </tr>
    <tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="93">ID</td>
      <td width="820">Almacén</td>
    </tr>
    <?
	$color=="#D9FFB3";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
    <td bgcolor="<? echo $color; ?>" align="center"><?= $row["id_almacen"]; ?></td>
      <td bgcolor="<? echo $color; ?>"><a href="#" onclick="ponclave('<?= $row["id_almacen"]; ?>','<?= $row["almacen"]; ?>')"> <?= $row["almacen"]; ?></a></td>
    </tr>
    <?
	if ($color=="#D9FFB3") 
		$color="#FFFFFF";
	else 
		$color="#D9FFB3";
	}
?>
  </table>
</form>
<?php include("../f.php"); ?>
</body>
</html>