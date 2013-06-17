<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function ponclave(clave,asociado,concepto,tipo){ 
	opener.document.frm.idtipomov.value = clave;
	opener.document.frm.tipomov.value = asociado;
	opener.document.frm.concepto.value = concepto;
	opener.document.frm.mov.value = tipo;
	window.close();
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
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.style10 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<?
	include("../php/conectarbase.php");
	$sql="SELECT * FROM concepmov";
	$result=mysql_db_query($sql_db,$sql);
?>
<form id="form1" name="form1" method="post" action="">
  <br /><table width="524" border="0" cellspacing="1" cellpadding="0" align="center">
    <tr style="background-color: #333333; text-align:center; font-weight:bold; color:#FFFFFF;">
      <td colspan="5">Conceptos de Movimientos </td>
    </tr>
    <tr style="background-color: #cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="52">ID</td>
      <td width="171">Concepto</td>
      <td width="105">Cuenta</td>
      <td width="86">Asociado</td>
      <td width="94">Tipo</td>
    </tr>
    <?
	$color=="#D9FFB3";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
    <td align="center" bgcolor="<? echo $color; ?>"><?= $row["id_concep"]; ?></td>
      <td bgcolor="<? echo $color; ?>"><a style="text-decoration:none;" href="javascript:ponclave('<?= $row["id_concep"]; ?>','<?= $row["asociado"]; ?>','<?= $row["concepto"]; ?>','<?= $row["tipo"]; ?>')"> <?= $row["concepto"]; ?></a></td>
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
</form>
<?php include("../f.php"); ?>
</body>
</html>