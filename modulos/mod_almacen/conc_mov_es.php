<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script language="javascript">
function validar_datos()
{
	var c=document.getElementById('concep').value;
	var a=document.getElementById('asoc').value;
	var t=document.getElementById('tipo').value;
	
	alert(c+a+t);
	if (c!==''&&a!==''&&t!==''){
		document.getElementById('form1').submit();
	} else {
		alert('Por favor introduzca los datos requeridos.');
	}
}
</script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.style8 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FFFFFF}
body {
	margin-top: 0px;
}
.style9 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<div class="menu2"><a href="conc_mov_es.php" class="actual">Nuevo Concepto</a> | <a href="conc_mov_listado.php">Listado de Conceptos</a></div>
<?
	if(!$_POST){
?>
<form id="form1" name="form1" method="post" action="conc_mov_es.php">
<p><table width="346" border="0" align="center" cellspacing="1">
      <tr>
        <td colspan="2" bgcolor="#666666" class="style8"><p align="center" class="style8">Conceptos de movimientos </p></td>
      </tr>
      <tr>
        <td width="154" bgcolor="#CCCCCC"><span class="Estilo3">
          <label>Concepto</label>
        </span></td>
        <td width="185"><label>
          <input type="text" name="concep" id="concep" />
        *</label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><span class="Estilo3">Cuenta contable </span></td>
        <td><label>
        <input type="text" name="cuenta" id="cuenta" />
        </label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC" class="Estilo3">Asociado</td>
        <td><label>
        <select name="asoc" id="asoc">
          <option value="">...</option>
		  <option>Ninguno</option>
          <option>Cliente</option>
          <option>Proveedor</option>
		  <option>Almacen</option>
          <option>Proyecto</option>
        </select>
        *</label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><span class="Estilo3">Tipo</span></td>
        <td>
        <select name="tipo" id="tipo">
          <option value="">...</option>
		  <option value="Ent">Entrada</option>
          <option value="Sal">Salida</option>
        </select>
        *</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right; color:#000000; padding-right:11px; font-size:12px;">* Datos requeridos</td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#666666" style="text-align:right;">
            <input type="button" name="Submit" value="Enviar" onclick="validar_datos()" />
		</td>
      </tr>
    </table>
</form>
<?
	}
	else{
		//capturando variables posteadas
		$concep=$_POST["concep"];
		$cuenta=$_POST["cuenta"];
		$asoc=$_POST["asoc"];
		$tipo=$_POST["tipo"];
		//echo $concep."  ".$cuenta."   ".$asoc."   ".$tipo;
		//conectando con la base de datos
		include("../php/conectarbase.php");
		$sql="INSERT INTO concepmov (concepto, cuenta, asociado, tipo) values ('$concep','$cuenta','$asoc','$tipo')";
		//echo $sql;
		mysql_db_query($sql_db,$sql);
?>
<p>
<table width="21%" border="0" align="center" cellspacing="0">
  <tr>
    <td bgcolor="#333333">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center" class="Estilo3">Datos Guardados correctamente</div></td>
  </tr>
  <tr>
    <td bgcolor="#333333">&nbsp;</td>
  </tr>
</table>
S<?
	}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr />
<p align="center" class="Estilo1">IQ Consumer Devices </p>
</body>
</html>