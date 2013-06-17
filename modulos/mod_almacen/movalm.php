<?php 
	session_start();
	/*if (!$_SESSION)
	{
		header("Location: ../index.php");
	} else {
		include("../login/validar_usuarios.php");
		validar_usuarios(0,1,2);
	}*/	
	
	include("../php/conectarbase.php");
	$op=$_GET['op'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body,document{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0,0,0,0px}
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
.style6 {
	font-size: 12px;
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo50 {color: #FFFFFF}
.style8 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style9 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo59 {color: #FFFFFF; font-weight: bold; }
.style12 {color: #003366}
.style21 {font-size: 10px; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style29 {color: #000099; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight:normal; }
.Estilo60 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; }
/*#texto { text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:bold;
padding-left:10px; margin-left:10px; }*/
#status { text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:bold;
padding:2px; margin-left:0px; color:#000000;  }
#texto { text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:bold;
padding:2px; margin-left:0px; color:#000000;   }

#todo { width:600px; height:200px; text-align:justify; font-family:Arial, Helvetica, sans-serif; font-size:9pt;
 padding:0px; float:none; /*margin-left:50px;*/ margin-top:15px; clear: both; margin-bottom:10px; overflow:auto;}
.a { width:150px; text-align:center; padding:2px; float:left;  margin:0px; border-bottom:#666666 1px solid;  border-left:#666666 1px solid;}
.b { width:310px; text-align:justify;  padding:2px; float:left; margin:0px; border-bottom:#666666 1px solid; border-left:#666666 1px solid;}
.c { width:100px; text-align:center;  padding:2px;  float:left; margin:0px; clear:right; border-left:#666666 1px solid; border-bottom:#666666 1px solid; border-right:#666666 1px solid;}
.a0 { width:150px; text-align:center; padding:2px; float:left;  margin:0px; border:#666666 1px solid; font-weight:bold; background-color:#CCCCCC;}
.b0 { width:310px; text-align:center;  padding:2px; float:left; margin:0px; font-weight:bold; background-color:#CCCCCC;
border-bottom:#666666 1px solid; border-top:#666666 1px solid; border-right:#666666 1px solid;}
.c0 { width:100px; text-align:center;  padding:2px;  float:left; margin:0px; clear:right; font-weight:bold; background-color:#CCCCCC; border-bottom:#666666 1px solid; border-top:#666666 1px solid; border-right:#666666 1px solid;}
.style211 {font-size: 10px; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; }
.campox{ text-align:left; padding:1px; font-weight:bold; background-color:#cccccc;}
.valorx{ text-align:left; padding:1px; font-weight:normal; background-color:#ffffff; border:#CCCCCC 1px solid;}
-->
</style>
<script language="javascript" src="../js/ajax_mov.js"></script>
<script language="javascript" src="../js/jquery.js"></script> 
<script language="javascript" src="../js/movimientos.js"></script> 
<script language="javascript"> 
function cerrarvx()
{
  	$('#all').show();
	$('#catalogosx').hide();
	$('#catalogosx2').hide();	
}
function ver_detallep() { 	$('#detallep').show('slow'); }

	function validar1() {
		var idtipomov=document.frm.idtipomov.value;
		var almacen=document.frm.id_almacen.value;
		var asociado=document.frm.idasociado.value;
		var referencia=document.frm.referencia.value;		
		var fecha=document.frm.fecha.value;	
		//alert('Validando primer formulario: \nId tipo Mov: '+idtipomov+'\nAlmacen Operado: '+almacen+'\nAsociado: '+asociado+'\nReferencia: '+referencia);
		if (idtipomov==''||almacen==''||asociado==''||referencia==''||fecha=='')
			alert('Error: Capture todos los campos.');
		else 
			document.frm.submit();
	}

// ---------------------------------------------------
function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
	if (codigo==27){
		cerrarvx();
	}	
}
document.onkeypress = cerrar;
</script> 
</head>
<body>
<?php include("menu.php"); ?><br /><br />
<div id="all">
<?
	if(!$_GET){
?>
	<form action="<?=$_SERVER['PHP_SELF'];?>?action=guardamov" method="post" name="frm" id="frm">
  	<br>
  	<table width="600px" border="0" align="center" cellspacing="0" style="border:#000000 1px solid; font-weight:bold; ">
    <tr style="background-color:#333333; height:20px; text-align:center; color:#FFFFFF; padding:1px;">
      	<td colspan="4" valign="middle" height="25px">Nuevo Movimiento a Inventario</td>
    </tr>
    <tr>
      	<td width="20%" class="campox">Tipo de movimiento:&nbsp;</td>
      	<td width="21%" bordercolor="#FFFFFF" class="valorx">
			<a href="#" onclick="javascript:seleccionar('ver_movimientos');" style="font-size:12px;">
      		<input name="idtipomov" type="text" class="Estilo60" id="idtipomov" size="7" style="cursor:hand; margin-left:2px; text-align:center; font-weight:bold;" />
		  ?</a>
        	<input type="hidden" id="tipomov" name="tipomov" size="10" value=""/>
        	<input type="hidden" id="concepto" name="concepto" size="10" value="" />
      		<input type="hidden" name="mov" id="mov" value="" />	  </td>
      	<td width="15%" class="campox">
			Fecha:&nbsp;		</td>
     	<td width="22%" class="valorx">
			<input name="fecha" type="text" class="Estilo60" id="fecha" value="<?= date('Y-m-d'); ?>" size="10" style=" margin-left:2px;text-align:center; font-weight:bold;" />	  </td>
    </tr>
	<tr>
		<td class="campox">Almacen Operado:&nbsp;</td>
  		<td class="valorx">
			<a href="#" onclick="javascript:seleccionar('ver_almacenes');" style="font-size:12px;">
			<input name="id_almacen" type="text" class="Estilo60" id="id_almacen" size="7"  value="" style="cursor:hand; margin-left:2px;text-align:center; font-weight:bold;" />
		  ?</a>
			<input name="almacen" type="hidden" id="almacen" />	  </td>
	  	<td class="campox"> Referencia:&nbsp; </td>
		<td class="valorx">
			<input name="referencia" type="text" class="Estilo60" id="referencia" size="10" value="" style=" margin-left:2px;text-align:center; font-weight:bold;" />
			<sup>1</sup>	  </td>
	</tr>
    <tr>
      	<td class="campox">Asociado a:&nbsp;</td>
      	<td colspan="3" class="valorx">
			<a href="#" onclick="javascript:seleccionar('ver_asociado');" style="font-size:12px;">
        	<input name="idasociado" type="text" class="Estilo60" id="idasociado" size="7" value="" style="cursor:hand; margin-left:2px;text-align:center; font-weight:bold;" />
		  ?</a>
   	  <input name="asociado" type="hidden" id="asociado" value="" /></td>
   	  </tr>
    <tr>
      	<td colspan="4">
			Observaciones:<br />
          	<textarea name="obser" cols="69" rows="3" id="obser" style="background-color:#FFFFCC; padding:2px;"></textarea>
		  	<div style="text-align:right; padding-right:1px; font-size:10px; font-weight:normal;">
				<sup>1</sup> Factura, nota de remisi&oacute;n u otra			</div>		</td>
    </tr>
    <tr>
      	<td colspan="4">
        	<div align="right" style="padding:1px; background-color:#333333;">
          	<input name="reset1" type="reset" class="Estilo60" id="reset1" value="Limpiar" />
		  	<input name="button" type="button" class="Estilo60" id="button" value="Iniciar Movimiento" onclick="validar1()" />
        	</div>		</td>
    </tr>
  </table>
</form>
<?
	}
	
	if($_GET['action']=="guardamov"){
		//print_r($_POST);
		//echo '<hr>';
		$idtipomov=$_POST['idtipomov'];	
		$tipomov=$_POST['tipomov'];
		$concepto=$_POST['concepto'];	
		$id_almacen=$_POST['id_almacen'];	
		$almacen=$_POST['almacen'];
		$fecha=$_POST['fecha'];	
		$idasociado=$_POST['idasociado'];	
		$asociado=$_POST['asociado'];
		$referencia=$_POST['referencia'];
		$obser=$_POST['obser'];
		$mov=$_POST['mov'];

		$SQL="INSERT INTO mov_almacen (tipo_mov, almacen, fecha, referencia, asociado, observ) values(".$idtipomov.",".$id_almacen.",'".$fecha."','".$referencia."',".$idasociado.",'".$observ."')";
		$resultx=mysql_db_query($sql_db,$SQL);
		$result=mysql_db_query($sql_db,"Select LAST_INSERT_ID() as NumMov");
		$row=mysql_fetch_array($result);	//	$row[0]; variable del ultimo introducido
		$NumMov=$row['NumMov'];
		if($resultx==false){
			echo "<script language='javascript'>alert('Error al guardar');</script>";
		}
	?>
<br>
<table width="600px" align="center" cellspacing="0" style="border:#000000 1px solid; font-weight:bold; ">
  <tr style="background-color:#333333; height:20px; text-align:center; color:#FFFFFF; padding:1px;">
    <td colspan="9" height="25px">Movimiento: <?=$NumMov;?></td>
  </tr>
  <tr>
    <td class="campox">Tipo de movimiento:</td>
    <td width="38%" class="valorx">
      &nbsp;<?= $idtipomov.". ".$concepto." - ".$tipomov;?>    </td>
    <td width="18%" class="campox">Fecha: </td>
    <td width="23%" class="valorx">&nbsp;<?= $fecha;?></td>
  </tr>
  <tr>
    <td class="campox">Almacen Operado:</td>
    <td class="valorx">
      &nbsp;<?= $id_almacen.". ".$almacen;?>    </td>
    <td class="campox">Referencia:</td>
    <td class="valorx">&nbsp;<?=$referencia ;?></td>
  </tr>
  <tr>
    <td class="campox">Asociado a:</td>
    <td colspan="3" class="valorx">
      &nbsp;<?= $idasociado.". ".$asociado;?>    </td>
  </tr>
  <tr>
    <td colspan="4" class="valorx">
      Observaciones:<br />
	  <textarea name="textarea2" cols="69" rows="3" id="textarea2" readonly="readonly"  style="background-color:#FFFFCC; padding:2px;">
	  <?=$obser;?></textarea>
    </td>
  </tr>
</table>
<br>
<form id="frm1" name="frm1" method="post" action="movalm.php?action=guardaitem">

  <input name="idtipomov2" type="hidden" id="idtipomov2" value="<?= $idtipomov;?>" />
  <input name="tipomov2" type="hidden" id="tipomov2" value="<?= $tipomov;?>" />  
  <input name="concepto2" type="hidden" id="concepto2" value="<?= $concepto;?>" />
  <input name="id_almacen2" type="hidden" id="id_almacen2" value="<?=$id_almacen;?>" />
  <input name="almacen2" type="hidden" id="almacen2" value="<?= $almacen;?>" />
  <input name="fecha2" type="hidden" id="fecha2" value="<?= $fecha;?>" />
  <input name="referencia2" type="hidden" id="referencia2" value="<?= $referencia;?>" />
  <input name="idasociado2" type="hidden" id="idasociado2" value="<?= $idasociado;?>" />
  <input name="asociado2" type="hidden" id="asociado2" value="<?= $asociado;?>" />
  <input name="observ2" type="hidden" id="observ2" value="<?= $obser;?>" />
  <input name="NumMov" type="hidden" id="NumMov" value="<?= $NumMov;?>" />

  <input name="mov2" type="hidden" id="mov2" value="<?=$mov;?>" />
  <table width="600px" align="center" cellspacing="0"  style="border:#000000 1px solid;font-weight:bold; ">
    <tr style="height:20px; text-align:center; background-color:#333333; color:#FFFFFF;">
      <td width="44" height="25px;">Cant</td>
      <td width="158">Clave Producto </td>
      <td width="502">Descripci&oacute;n</td>
      <td width="51">C.U.</td>
      <td width="29">
        <img src="../img/chek2.jpg" alt="" width="15" height="19" />
      </td>
    </tr>
    <tr>
      <td style="text-align:center; background-color:#ffff99; padding:1px;"><input name="ca1" type="text" id="ca1" size="3" style="font-weight:bold; text-align:center;" /></td>
      <td  style="text-align:center; background-color:#ffff99; padding:1px;">
		<a href="#" onclick="javascript:elegir_producto();" style="font-size:12px;">
		<input name="cl1" type="text" size="15" id="cl1" style="cursor:hand;" />
		?</a>

	  </td>
      <td  style="text-align:left; background-color:#ffff99; padding:1px;"><input name="ds1" type="text" id="ds1" size="40" />
      <input type="hidden" name="id1" id="id1" /></td>
      <td  style="text-align:center; background-color:#ffff99; padding:1px;"><input name="cu1" type="text" id="cu1" size="5" /></td>
      <td bgcolor="#FFFF99"><!--<input name="chk1" type="checkbox" id="chk1" value="1" />--></td>
    </tr>
    <tr>
      <td colspan="5" style="text-align:right; padding:2px; border-top:#000000 2px solid0; background-color:#CCCCCC;">
			<input type="reset" name="reset2" value="Limpiar" class="Estilo60" />&nbsp;
			<input type="button" name="Submit8" class="Estilo60" value="Guardar Producto" onclick="guarda_producto()" />
      </td>
    </tr>
  </table>

<?php } 	// Termina GET[action]=='guardamov'..  ?>
</form>
<div id="resultados" style="font-size:12px; text-align:center; font-weight:bold; display:none; background-color:#FFFFFF; "></div>

<?php include("../f.php"); ?>
</div>
<div id="catalogosx" style="position:absolute; width:800px; height:500px; top:50%; left:50%; margin-left:-400px; margin-top:-250px; background-image:url(../img/cuadro2.png); background-repeat:no-repeat; display:none;">
<a href="javascript:cerrarvx();" style="text-align:right; margin-left:760px;">&nbsp;<img src="../img/close.png" alt="Cerrar" width="22" height="22" border="0" style="margin-top:3px;" /></a>
	<div id="conven" style="text-align:left; padding:0px; height:433px; overflow:auto; width:790px; margin-top:0px; margin-bottom:5px; margin-left:2px; margin-right:12px;">...</div>	
	<div id="pieven" style="text-align:center; color:#FFFFFF; font-weight:bold; padding:0px; margin-top:15px; 1px solid; font-size:10px; "><?php include("../f2.php"); ?></div>		
</div>

<div id="catalogosx2" style="position:absolute; z-index:3; width:600px; height:500px; top:50%; left:50%; margin-left:-300px; margin-top:-250px; background-image:url(../img/cuadro1.png); background-repeat:no-repeat; display:none;">
<a href="javascript:cerrarvx();" style="text-align:right; margin-left:560px;">&nbsp;<img src="../img/close.png" border="0" alt="Cerrar" style="margin-top:5px;" /></a>
	<div id="conven2" style=" position:absolute; height:433px;  width:590px; top:50%; left:50%;  margin-top:-216px; margin-bottom:5px; margin-left:-295px; margin-right:12px; overflow:auto;text-align:left; padding:0px;">...</div>	
	<div id="f7" style=" text-align:center; color:#FFFFFF; font-size:10px; font-weight:bold; padding:2px; margin-top:10px;">&copy; IQe International 2008. - Sistemas</div>
</div>

</body>
</html>