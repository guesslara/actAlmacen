<?php 
include("../php/conectarbase.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
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
    <td><div align="center" class="style6 style7"><a href="alta_producto.php" class="Estilo1"><span class="Estilo7">Alta de Productos </span></a> | <a href="cat_product_buscar.php">Buscar Productos </a><a href="tipo_alm_buscar.php"></a> |<a href="cat_product1.php" class="Estilo7"> Listar Productos </a><a href="tipo_alm_listado.php"></a></div></td>
  </tr>
</table>
<? 	
			if(!$_POST)
			{
?>
</center>
<form id="form1" name="form1" method="post" action="cat_product3.php">
  <table width="742" border="0" align="center" cellspacing="0">
    <tr>
      <td colspan="3" bgcolor="#333333"><div align="center"><span class="Estilo2 Estilo1 Estilo8"><strong>Catalogo de Productos</strong></span></div></td>
    </tr>
    <tr>
      <td width="116" bgcolor="#EFEFEF" class="Estilo1"><div align="right">Clave del Producto</div></td>
      <td width="300" bgcolor="#EFEFEF"><input name="id_prod" type="text" id="id_prod" size="15" />
      <span class="style17"><a href="javascript:abreAsistente()">Asistente Prod. Reproceso</a></span></td>
      <td width="320" rowspan="11" bgcolor="#EFEFEF"><table width="320" border="0" align="center">
          <tr>
            <td><!---->
              <fieldset>
              <legend class="Estilo1">Almacen Asociado:</legend>
                <table width="200" border="0" align="center" cellpadding="1" cellspacing="0">
                  <tr>
                    <td colspan="2" bgcolor="#333333" class="Estilo11">&nbsp;</td>
                  </tr>
                  <?
				  //se listan los almacenes
				  //include("../php/conectarbase.php");
				  $sql="Select * from tipoalmacen";
				  $resultado=mysql_db_query($sql_db,$sql);
				  while($fila=mysql_fetch_array($resultado)){
				  ?>
                  <tr>
                    <td width="25"><input name="<?="a_".$fila['id_almacen']."_".$fila['almacen'];?>" type="checkbox" value="1" /></td>
                    <td width="171" class="Estilo1"><?=$fila['almacen'];?></td>
                  </tr>
                  <?
				  //echo "a_".$fila['id_almacen']."_".$fila['almacen'];
				  }
				  ?>
                </table>
              </fieldset>
            <!---->          </td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right"><span class="Estilo1">Descripcion</span></div></td>
      <td bgcolor="#EFEFEF"><span class="Estilo1">
        <input name="descripgral" type="text" id="descripgral" size="50" />
      </span></td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right"><span class="Estilo1">Especificacion</span></div></td>
      <td bgcolor="#EFEFEF"><span class="Estilo1">
        <input name="especificacion" type="text" id="especificacion" size="15" />
        <span class="Estilo11">(Modelo,Matricula,otro)</span></span></td>
    </tr>
	 <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Control de Almacen       </div></td>
      <td bgcolor="#EFEFEF" class="Estilo1"><input name="control_alm" type="text" id="control_alm" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Linea de Producto       </div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="linea" type="text" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Ubicacion       </div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="ubicacion" type="text" id="ubicacion" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Marca</div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="marca" type="text" size="15" /></td>
    </tr>	
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">
	  	<span class="Estilo1">
			<fieldset><legend>Unidades de:</legend>
			<table width="348" border="0" align="center">
			  <tr>
				<td width="50">Entrada</td>
				<td width="90"><span class="style15">
				  <input name="uni_entrada" type="text" id="uni_entrada" size="15" />
				</span></td>
				<td width="38">Salida</td>
				<td width="150"><input name="uni_salida" type="text" id="uni_salida" size="15" /></td>
			  </tr>
			</table>
			</fieldset>
		</span>	  </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">
	  <fieldset><legend>Stock:</legend>
		<table width="389" border="0" align="center">
		  <tr>
			<td width="66">Min</td>
			<td width="96"><span class="style15">
			  <input name="stock_min" type="text" id="stock_min" size="15" />
			</span></td>
			<td width="43">Max</td>
			<td width="156"><span class="style15">
			  <input name="stock_max" type="text" id="stock_max" size="15" />
			</span></td>
		  </tr>
		</table>
		</fieldset>	  </td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1">Observaciones</td>
      <td bgcolor="#EFEFEF" class="Estilo1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#EFEFEF">
        <div align="center">
          <textarea name="observa" cols="80" rows="5" wrap="virtual" id="observa"></textarea>
        </div></td>
    </tr>   
    <tr>
      <td colspan="3" bgcolor="#333333"><div align="right">
        <input type="submit" name="button" id="button" value="Guardar" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<center>
  <p>
    <?
			}
			else
			{
				//include("../php/conectarbase.php");
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				/*   Generando Dinamicamente la consulta de insercion 
				/*   en catalogo de productos y asociacion con almacenes --Dispercion de productos
				/*    --------------------------------PRIMERA PARTE---------------------------------
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
				
				
				
				
				$S="INSERT INTO catprod (";
				foreach($_POST as $i=> $v) {
					$Q=$Q.$i.", ";
					$L=$L.$v."', '";
				}
				//Generando consulta-----------------------------------------
				$lgQ=strlen($Q);
				$lgL=strlen($vv);
				$nQ= substr($Q, 0,$long-2);
				$nL= substr($L, 0,$long-3);
				//echo 
				$SQL=$S.$nQ.") values ('".$nL.")";
				
				/*echo "<script languaje='javascript'>alert('$SQL=$S.$nQ.) values (.\'$nL.\'');</script>";*/
				
				//include("../php/conectarbase.php");
				mysql_db_query($sql_db,$SQL);
				//redireccionando a si misma opcion 3
				$id_prod=$_POST['id_prod'];
				$descrip=$_POST['descripgral'];
				//echo "<br>Mandar a cat_product.php?op=3&id=$id_prod&des=$descrip <br>";
				echo "<script languaje='javascript'> window.location.href='cat_product.php?op=3&id=".$id_prod."&des=".$descrip."';</script>";
				
			}
?>
  </p>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics 2008</p>
</body>
</html>