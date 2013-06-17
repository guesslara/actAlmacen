<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
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
.Estilo50 {color: #FFFFFF}
body {
	margin-top: 0px;
}
.style11 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td bgcolor="#333333"><div align="center" class="style6"><a href="mov_list.php" class="style6">Movimientos</a> |<a href="inventario.php" class="style6"> Inventarios</a>  | <a href="tipo_alm_listado.php" class="Estilo50">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo50">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo50">Lineas de Producto</a> | <a href="cat_product1.php" class="Estilo50">Cat. Productos</a></div></td>
  </tr>
  <tr>
    <td><div align="center" class="style6 style7"><a href="conc_mov_es.php">Conceptos de Movimientos</a> | <a href="conc_mov_buscar.php">Busqueda de Movimientos</a> | <a href="conc_mov_listado.php">Listado de Movimientos</a></div></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
    <table width="346" border="0" align="center" cellspacing="1">
      <tr>
        <td colspan="2" bgcolor="#666666" class="style8"><p align="center" class="style8">Conceptos de Movimientos </p></td>
      </tr>
      <tr>
        <td width="195" bgcolor="#CCCCCC"><span class="Estilo3">
          <label>Concepto</label>
          </span></td>
        <td width="154"><label>
          <input type="text" name="textfield2" />
        </label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><span class="Estilo3">Cuenta Contable </span></td>
        <td><label>
        <input type="text" name="textfield22" />
        </label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC" class="Estilo3">Asociado</td>
        <td><label>
        <select name="select">
        </select>
        </label></td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><span class="Estilo3">Tipo</span></td>
        <td><input type="text" name="textfield4" /></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#666666"><label>
            <div align="right">
              <input type="submit" name="Submit" value="Enviar" />
            </div>
          </label></td>
      </tr>
    </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr />
<p align="center" class="Estilo1">IQ Consumer Devices </p>
</body>
</html>