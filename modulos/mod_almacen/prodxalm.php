<?php include("../conf/conectarbase.php"); ?>
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
.Estilo2 {	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
.Estilo3 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #000000;
	font-size: 18px;
}
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
	color: #666666;
}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style6 {font-size: 12px; color: #333333; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style8 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.style9 {	font-size: 12px
}
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.encabezado{ width:500px; height:15px; margin-bottom:0px; background-color:#666666; BORDER: #999999 1px solid; font-size:12px; 
font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight:bold; padding:3px;}
.cuadro1{width:500px; height:200px; background-color:#efefef; margin-top:0px; text-align:center; overflow:auto; 
font-family:Arial, Helvetica, sans-serif; BORDER: #999999 1px solid; padding:3px; font-size:14px;}
.campo1{width:100px; height:25px; float:left; text-align:center; font-size:14px; }
.campo2{width:350px; height:25px; float:left; text-align:left; font-size:14px; clear:right;}
-->
</style>
</head>
<?
	$id_prod=$_GET['id'];
	$desc=$_GET['desc'];
?>
<body>
<center>
<div class="t1" id="titulo" style=" font-size:14px; text-align:center; font-weight:normal; margin-top:10px; margin-bottom:10px;">
	Producto: <font color="#FF0000"><?=$id_prod."  - ".$desc;?></font>
</div>


<? if(!$_POST){
		$result = mysql_list_tables($sql_db);
		$i = 0;
?>
<form id="form1" name="form1" method="post" action="<?=$_SERVER['PHP_SELF'];?>?id_prod=<?=$id_prod;?>" enctype="application/x-www-form-urlencoded">
<p><div class="encabezado" >Almacenes Asociados:</div>
<div class="cuadro1">
<?	//se listan los almacenes
	$sql="SHOW COLUMNS FROM catprod FROM ".$sql_db." LIKE 'a_%' ";
	//echo $sql;
	$result=mysql_db_query($sql_db,$sql);
	$i = 1;
	while ($row=mysql_fetch_array($result)) {
		//determinando almacenes no asociados
		//$alm='`'.$row[0].'`';
		$alm=$row[0];
		//echo "<br>$alm<br>";
		$sql_alm="SELECT count(`id_prod`) as existe FROM `catprod` WHERE `id_prod`='$id_prod' and `$alm`='0'";
		$res=mysql_db_query($sql_db,$sql_alm);
		$rowa=mysql_fetch_array($res);
		if($rowa[0]=='1'){ ?>	
			<div class="campo1"><input id='<?=$alm;?>' name='<?=$alm;?>' type="checkbox" value="1" /></div>
			<div class="campo2"><?=$alm;?></div>
		<?php } else {?>
			<div class="campo1">x</div>
			<div class="campo2"><?=$alm;?></div>
		<?php }
	} ?>
</div>
<div align="center" style="padding:3px; margin:5px;">
	<a href="javascript:document.form1.submit();" style="border:#000000 2px solid; text-align:center; background:#CCCCCC; text-decoration:none; padding:2px; color:#000000;">Guardar</a></div>
</form>
<?
	} 	else{
		//print_r(stripslashes($_POST));
		//print_r($_POST);
		//echo "<hr>";
		$id_prod=$_GET['id_prod'];
		//exit();
		$S="UPDATE catprod SET ";
		foreach($_POST as $i=> $v) {
			$Q=$Q.'`'.$i.'`='.$v.',';
			//echo "<br>$Q";
		}
		$lgQ=strlen($Q);
		$nQ= substr($Q, 0,$long-1);
		$SQL=$S.$nQ." WHERE id_prod='$id_prod'";
		//echo "<br><br> [$SQL]";
		//include("../php/conectarbase.php");
		if (mysql_db_query($sql_db,$SQL))
		{
			//echo "almacenes Asociados exitosamente...";
			echo '<script language="javascript">
			alert("Almacenes Asociados exitosamente");
			self.close();
			</script>';
		} else {
		echo '<br><br>Error: Los almacenes no se asociaron.';
		}
	}	
?>
</center>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics International SA de CV 2007</p>
</body>
</html>