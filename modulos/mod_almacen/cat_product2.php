<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/asistente.js"></script>
<SCRIPT LANGUAGE="JavaScript">
var win1var; 
var n;	
<!-- 
function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400');");
	}
function verificaOS(form){
	var numorder=form.numorder.value;
	if(numorder==""){
		alert("No hay un numero de orden a para ver");
		return false;
	}
	else{
		alert(numorder);
	}
}
function validar(form)
	{
		var numorder=form.numorder.value;
    	var fecha=form.fecha.value;
    	if (numorder=="" ){				//Fecha
			alert("falta Numero de Orden");
			form.numorder.focus();
			return false;}
		if (fecha==""){				//fecha
			alert("Falta fecha de Orden de Servicio");
			return false;}
		//form.submit();
	}
// -->
/*function abreVentanaTipo(){
//	n=this.document.form.linea.value
	n=this.form1.linea.options[this.form1.linea.selectedIndex].value
    win1= window.open("tipo_list2.php?n="+n,"Catalogo","width=300,height=300,scrollbars=yes,top=50,left=600") 
    win1.focus()
}*/
</script>
<style type="text/css">
<!--
.Estilo1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo2 {	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
	color: #666666;
}
.Estilo6 {color: #FFFFFF}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.Estilo7 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo8 {font-size: 12px}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style15 {font-size: 9}
.style17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style18 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.style11 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
.style19 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.style20 {font-size: 9px}
.style21 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.ancho1{
	width:80%;
}	
.Estilo11 {font-size: xx-small}
-->
</style>
</head>

<body>
<center>
<table width="100%" border="0" align="center" cellspacing="0">
  <tr>
    <td bgcolor="#333333"><div align="center" class="style6"><a href="mov_list.php" class="style6">Movimientos</a> |<a href="inventario.php" class="style6"> Inventarios</a>  | <a href="tipo_alm_listado.php" class="Estilo50">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo50">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo50">Lineas de Producto</a> | <a href="cat_product1.php" class="Estilo50">Cat. Productos</a></div></td>
  </tr>
  <tr>
    <td><div align="center" class="style6 style7"><a href="alta_producto.php" class="Estilo1"><span class="Estilo7">Alta de Productos </span></a> | <a href="cat_product_buscar.php">Buscar Productos </a> |<a href="cat_product1.php" class="Estilo7"> Listar Productos </a><a href="tipo_alm_listado.php"></a></div></td>
  </tr>
</table>
<?
			if(!$_POST)
			{
?>
</center>
<form id="form1" name="form1" method="get" action="cat_product_buscar.php">
  <table width="555" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="3" valign="top" bgcolor="#333333"><div align="center" class="Estilo2">Criterio de Busqueda</div></td>
    </tr>
    <tr>
      <td width="186" valign="top" bgcolor="#CCCCCC" class="style17"><strong><input name="radio" type="radio" id="clave" value="Id_prod" checked="checked" />
      Clave del Producto </strong></td>
      <td width="300" rowspan="5" valign="middle" bgcolor="#FFFFFF"><input name="criterio" type="text" id="criterio" size="50" /></td>
      <td width="59" rowspan="5" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Buscar" /></td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bdesc" value="descripgral" />
      Descripcion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bespecif" value="especificacion" />
      Especificacion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Blinea" value="linea" />
      Linea de prod.</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bcontrol_alm" value="control_alm" />
      Control de almacen</td>
    </tr>
    <tr>
      <td colspan="3" valign="top" bgcolor="#333333">&nbsp;</td>
    </tr>
  </table>
</form>
  <?	
			}
			else
			{
				include("../php/conectarbase.php");
				$criterio=$_POST["criterio"];
				$radio=$_POST["radio"];
				$sql="SELECT * FROM catprod WHERE $radio LIKE '%$criterio%' ORDER BY id_prod";
				$result=mysql_db_query($sql_db,$sql);
				//echo $sql;
				//echo $criterio;
?>
<form id="form1" name="form1" method="post" action="">
  <table width="802" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#333333" class="style6"><div align="center"><span class="Estilo4">Datos encontrados:</span></div></td>
    </tr>
    <tr>
      <td width="46" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>#</strong></div></td>
      <td width="102" bgcolor="#CCCCCC" class="style17"><div align="center">NumParte Almacen</div></td>
      <td width="292" bgcolor="#CCCCCC" class="style17"><strong>Descripcion</strong></td>
      <td width="91" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Especificacion</strong></div></td>
      <td width="86" bgcolor="#CCCCCC" class="style17"><div align="center">Linea</div></td>
      <td width="166" bgcolor="#CCCCCC" class="style17"><div align="center">Asociar</div></td>
    </tr>
    <?
		$color=="#D9FFB3";
		$i=1;
		while($row=mysql_fetch_array($result)){
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
<? 
		$inferior++;
		echo $row['id'];
?>
      </font>
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?= $row['id'];?>" />
      </div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["id_prod"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["descripgral"]; ?>
      </font> </div></td>
      <td bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["especificacion"]; ?>
      </font></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["linea"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>">
      		<div align="center">
            	<font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
                	<a href="javascript:popUp('prodxprov.php?id=<?=$row["id"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=2";?>')">ver</a> | 
      				<!--<a href="javascript:popUp('prodxalm.php?id=<?=$row["id"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=100";?>')">-->proveedor<!--</a>--> | 
				</font>
	  				<span class="style19">
						<a href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a>
					</span>
			</div>
	  </td>
    </tr>
    <?
			if ($color=="#D9FFB3") 
				$color="#FFFFFF";
			else 
				$color="#D9FFB3";
		$i=$i+1;
		}
?>
  </table>
</form>
  <?
			}
?>
  </p>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics 2008</p>
</body>
</html>