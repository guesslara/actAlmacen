<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function ponclave(clave,tipo){
	opener.document.frm.idasociado.value = clave 
	opener.document.frm.asociado.value = tipo 
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
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.style10 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo1 {	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
-->
</style>
</head>
<body>
<br />
<?
	$n=$_GET['n'];
		$alm_operado='';
		if (isset($_GET['alm_operado']))
			$alm_operado=$_GET['alm_operado'];
	
	if(!$n==""){
	switch($n){
		case 'Proveedor':{
			$sql="SELECT * FROM catprovee";
			break;
		}
		case 'Cliente':{
			$sql="SELECT * FROM catclient";
			break;
		}
		case 'Proyecto':{
			$sql="SELECT * FROM areas";
			break;
		}
		case 'Ninguno':{
			$sql="X";
			break;
		}
		case 'Almacenes':{
			$sql="SELECT * FROM tipoalmacen where  id_almacen<>'$alm_operado' ";
			if ($_GET['id_tipomov']==7)
			{
			$sql="SELECT * FROM tipoalmacen ";
			}
			break;
		}
	}
	if ($sql!='X'){
		include("../php/conectarbase.php");
		
		
		if ($n=='Proveedor'){
			$result=mysql_db_query($dbcompras,$sql);
		} else {
			$result=mysql_db_query($sql_db,$sql);
		}	
?>
<form id="form1" name="form1" method="post" action="">
  <table width="95%" border="0" cellspacing="1" align="center">
    <tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
      <td colspan="2">A quien va asociado: <?php echo $n; ?></td>
    </tr>
    <tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="32">ID</td>
      <td width="590">Asociar a:</td>
    </tr>
	<?
		$color=="#D9FFB3";
		$i=1;
		while($row=mysql_fetch_array($result)){
	
	if ($n=='Proveedor'){ ?>
    <tr>
	<td bgcolor="<? echo $color; ?>"><?= $row['id_prov']; ?></td>
      <td bgcolor="<? echo $color; ?>"><a href="#" style="text-decoration:none;font-size:11px;" onclick="ponclave('<?= $row['id_prov']; ?>','<?= $row["nr"]; ?>')"> <?= $row["nr"]; ?></a></td>
    </tr>	
	<?php } else {  ?>
	
	<td bgcolor="<? echo $color; ?>"><?= $row[0]; ?></td>
      <td bgcolor="<? echo $color; ?>"><a href="#" style="text-decoration:none;" onclick="ponclave('<?= $row["0"]; ?>','<?= $row["1"]; ?>')"> <?= $row["1"]; ?></a></td>
      </tr>
<?
	}	
		($color=="#D9FFB3")?$color="#FFFFFF":$color="#D9FFB3";
		}
?>
  </table>
</form>
<?
	}
	else{
?>
		<br /><br /><a href="#" style="text-decoration:none; font-size:15px; text-align:center; margin-top:30px;" onclick="ponclave('0','Ninguno')">El movimiento seleccionado no va asociado a ningun elemento. Por favor de clic aqui para colocar el valor y Cerrar Ventana</a>
		<br /><br />
<?
	}
	}
	else{
		echo "No a seleccionado tipo de movimiento";
	}
?>
<?php include("../f.php"); ?>
</body>
</html>