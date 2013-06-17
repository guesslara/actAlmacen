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
    <td bgcolor="#333333"><div align="center" class="style6"><strong><span class="style11"><a href="movalm.php" class="style11">Movimientos</a> | <a href="inventario.php" class="style11">Inventarios</a> |</span> <a href="tipo_alm_listado.php" class="Estilo6">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo6">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo6">Lineas de Producto</a> | <a href="cat_product.php?op=2" class="Estilo6">Cat. Productos</a></strong></div></td>
  </tr>
  <tr>
    <td><div align="center" class="style6 style7"><a href="cat_product3.php" class="Estilo1"><span class="Estilo7">Alta de Productos </span></a> | <a href="cat_product2.php">Buscar Productos </a><a href="tipo_alm_buscar.php"></a> |<a href="cat_product1.php" class="Estilo7"> Listar Productos </a><a href="tipo_alm_listado.php"></a></div></td>
  </tr>
</table>
<? 	
			include("../php/conectarbase.php");
			$result3=mysql_db_query($sql_db,"SELECT count(id)as n FROM catprod");//numero de registros de BD
			$result2=mysql_db_query($sql_db,"SELECT ((count(id)) DIV (100))+1 as m FROM catprod");// numero de paginas DB
			$row3=mysql_fetch_array($result3); // numero de reg
			$row2=mysql_fetch_array($result2); // numero de pag
			$paginas=$row2["m"];
			echo "<div align='left'>Numero de Registros: ".$row3["n"]."</div><br>";
			$k=1;
			while($k<=$paginas){
				$limsup[$k]=$k*100;
				$liminf[$k]=$limsup[$k]-99;
				//echo "|".$liminf[$k];
				//echo "<->".$limsup[$k];
				echo "<span class='Estilo2'><a href='cat_product.php?op=100&pag=$k'>".$k."</a></span> | ";
				$k=$k+1;
			}
			$numpag=$_GET["pag"];
			if($numpag=="") $numpag=1;
			//echo $liminf[$numpag]."<-->".$limsup[$numpag];
			$inferior=($liminf[$numpag])-1;
			$sql="SELECT catprod.id, catprod.id_prod, catprod.descripgral, catprod.especificacion, lineas.descripcion FROM catprod, lineas WHERE lineas.linea=catprod.linea ORDER BY catprod.id LIMIT ".$inferior.",100";
			//$sql_alm="SELECT * FROM tipoalmacen";
			//$liminf[$numpag] 
			//echo $sql;
			$result=mysql_db_query($sql_db,$sql);
			//$r_alm=mysql_db_query($sql_db,$sql_alm);
?>
  <br /><br /><table width="801" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#333333" class="style6"><div align="center"><strong>Listado de Items Almacen</strong></div></td>
    </tr>
    <tr>
      <td width="37" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>#</strong></div></td>
      <td width="89" bgcolor="#CCCCCC" class="style17"><div align="center">NumParte Almacen</div></td>
      <td width="317" bgcolor="#CCCCCC" class="style17"><strong>Descripcion</strong></td>
      <td width="91" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Especificacion</strong></div></td>
      <td width="83" bgcolor="#CCCCCC" class="style17"><div align="center">linea</div></td>
      <td width="165" bgcolor="#CCCCCC" class="style17"><div align="center">asociar</div></td>
    </tr>
<?
			$color=="#D9FFB3";
			$i=1;
			while($row=mysql_fetch_array($result)){
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
<?
		echo $inferior++; //."--".$row[0];
		
?>			</font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["id_prod"]; ?></font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["descripgral"]; ?></font> </div></td>
      <td bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["especificacion"]; ?></font></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["descripcion"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center" class="style21"><font face="Verdana, Arial, Helvetica, sans-serif"><span class="style20"><a href="javascript:popUp('prodxprov.php?id=<?=$row["id_prod"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=2";?>')">ver</a> | proveedor</span></font><span class="style20"> | </span><span class="style19"><a href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a></span></div></td>
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
  <p>&nbsp; </p>
  <p>&nbsp;</p>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics 2008</p>
</body>
</html>