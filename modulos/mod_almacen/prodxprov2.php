<?php 
	include ("../php/conectarbase.php");
	print_r($_GET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Productos de Proveedor</title>
<script language="javascript">
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
<style type="text/css">
<!--
body { margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px; font-family:Arial, Helvetica, sans-serif; }
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #666666; }
.tabla1 {width:590px; margin:5px; padding:0px; font-size:9pt; text-align:justify; border:#333333 1px solid;  overflow:auto;}
.campo1 {float:left; background-color:#333333; width:50px; text-align:center; color:#FFFFFF; font-weight:bold;}
.campo2 {float:left; background-color:#333333; width:300px; text-align:left; color:#FFFFFF; font-weight:bold;}
.campo3 {float:left; background-color:#333333; width:190px; text-align:left; color:#FFFFFF; font-weight:bold;}
.campo4 {float:left; background-color:#333333; width:50px; text-align:left; color:#FFFFFF; font-weight:bold; clear:right;}
.reg1 {float:left; width:50px; text-align:center; color:#000000; clear:left;}
.reg2 {float:left; width:300px; text-align:left; color:#000000;}
.reg3 {float:left; width:190px; text-align:left; color:#000000;}
.reg4 {float:left; width:50px; text-align:left; color:#000000; clear:right;}

.campo10 {float:left; background-color:#333333; width:50px; text-align:center; color:#FFFFFF; font-weight:bold;}
.campo11 {float:left; background-color:#333333; width:540px; text-align:left; color:#FFFFFF; font-weight:bold; clear:right;}
.reg10 {float:left; width:50px; text-align:center; color:#000000; clear:left;}
.reg11 {float:left; width:540px; text-align:left; color:#000000; }
-->
</style>
</head>
<body>
<?
	$id=$_GET['id'];
	$id_prod=$_GET['id_prod'];
	$desc=$_GET['desc'];
	$op=$_GET['op'];

	$sql="SELECT id_prod, id_prov FROM prodxprov WHERE id_prod='$id_prod' ";
	$result=mysql_db_query($sql_db,$sql);  	
	$color=="#D9FFB3";
?>
<div class="t1" id="titulo" style=" font-size:10pt; text-align:center; font-weight:bold; margin-top:10px; margin-bottom:10px;">
	Producto: <font color="#FF0000"><?=$id_prod."  - ".$desc;?></font>
</div>
<div style="margin-left:5px; font-size:14px; font-weight:normal; text-align:left; ">Proveedores Asociados:</div>
<div class="tabla1">
	<div class="campo1">ID</div>
	<div class="campo2">Proveedor</div>
	<div class="campo3">Contacto</div>
	<div class="campo4">Status</div>
<?php
while($row=mysql_fetch_array($result))
{	
	//$color=="#ffffff";
	$sql2="SELECT nr, contac, status FROM catprovee WHERE id_prov=".$row["id_prov"];
	$result2=mysql_db_query($dbcompras,$sql2);
		while($row2=mysql_fetch_array($result2))
		{	?>
	<div class="reg1" style="background-color:<?=$color;?>"><?= $row["id_prov"]; ?></div>
	<div class="reg2" style="background-color:<?=$color;?>"><?= $row2["nr"]; ?></div>
	<div class="reg3" style="background-color:<?=$color;?>"><?= $row2["contac"]; ?></div>
	<div class="reg4" style="background-color:<?=$color;?>"><?= $row2["status"]; ?></div>
<?php 		if ($color=="#D9FFB3") 
			$color="#ffffff";
			else 
			$color="#D9FFB3";
		} 
} ?>
	
</div>

<p><div style="margin-left:5px; font-size:14px; font-weight:normal; text-align:left; ">Almacenes Asociados:</div>
<div class="tabla1">
	<div class="campo10">ID</div>
	<div class="campo11">Almacen</div>
<?php 	
	//include("clase_asociacion_prod_alm.php");
	//$n_a1=new asociacion_producto_almacen($id_prod);
	//print_r($n_a1->get_almacenes_asociados());
?>
				<div class="reg10" style="background-color:<?=$color;?>"><?= $i2; ?></div>
				<div class="reg11" style="background-color:<?=$color;?>"><?= $alm7; ?></div>
				<?php
				if ($color=="#D9FFB3") 
				$color="#ffffff";
				else 
				$color="#D9FFB3";
			//}
		//$i2++;
		//} 
 ?>
</div>
<p></p>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics International SA de CV 2007</p>
</body>
</html>