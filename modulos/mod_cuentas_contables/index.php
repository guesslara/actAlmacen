<?php 
//$link=@mysql_connect('localhost','root','1q3m3x') or die("No se pudo conectar al servidor.<br>"); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cuentas Contables</title>
<style type="text/css">
body,html,document{ position:absolute; width:100%; height:100%; margin:0px; padding:0px; background-color:#fff; color:#000;}
#div_transparente{ position:fixed; width:100%; height:100%; margin:0px; padding:0px; z-index:2; background-image:url(../img/transparente.png); cursor:pointer; display:none; }
#div_ventana1 { position:absolute; width:600px; height:400px; left:50%; top:50%; margin-left:-300px; margin-top:-200px; z-index:3; background-color:#FFFFFF; border:#333333 1px solid; overflow:auto; display:none; }

#div_cc_main{ position:absolute; width:100%; height:100%;  margin:0px; padding:0px; background-color:#FFFFFF; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:small; z-index:1; }
	#div_cc_A{ position:relative; width:100%; height:3%; /*background-color:#ccc;*/ background-image:url(../menu/jdmenu/gradient.png); font-size:11pt; text-align:center;  }
	#div_cc_B{ position:relative; width:100%; height:3%; background-color:#efefef;   text-align:center; }
	#div_cc_C{ position:relative; width:100%; height:93%; border-top:#CCCCCC 1px inset; }
	/*#div_cc_C{ border-top:#CCCCCC 2px inset; }*/

table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
td,th { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }		
th{ background-color:#CCCCCC; }
a{ text-decoration:none; color:#0033FF; }


#tr_cc_nueva{ text-align:center; background-color:#efefef; display:none; }
	#txt_cc{ text-align:center; }
	#txt_ccA{ text-align:center; width:40px; }
	#txt_ccB{ text-align:center; width:25px; }
	#txt_ccC{ text-align:center; width:25px; }
	#txt_ccD{ text-align:center; width:25px; }
	#txt_ccDES{ text-align:left; width:250px; }
	#txt_ccOBS{ text-align:left; width:250px; }
	
	#tr_cc_nueva a{ margin:1px; border:#0033FF 1px solid; padding:2px; background-color:#6699FF; color:#000000;   }
	#hip_ncc{ margin:1px; border:#0033FF 1px solid; padding:2px; background-color:#6699FF; color:#000000; }
/*
<td><input type="text" id="txt_cc" disabled="disabled"></td>
<td><input type="text" id="txt_ccA" maxlength="4"></td>
<td><input type="text" id="txt_ccB" maxlength="3"></td>
<td><input type="text" id="txt_ccC" maxlength="3"></td>
<td><input type="text" id="txt_ccD" maxlength="3"></td>
<td><input type="text" id="txt_ccDES"></td>
<td><input type="text" id="txt_ccOBS"></td>
*/

</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="javascript" src="mi_js.js"></script>


<script language="JavaScript" src="js/FusionCharts.js"></script>
</head>

<body>
<div id="div_transparente" onclick="$('#div_transparente').hide(); $('#div_ventana1').hide(); "></div>
<div id="div_ventana1"></div>

<div id="div_cc_main">
	<div id="div_cc_A">Cuentas Contables</div>
	<div id="div_cc_B">
		<!--<a href="../contenido.php" title="Volver a la Portada."> &lArr;</a> |//-->
		<a href="#" onclick="ajax('div_cc_C','ac=listar_CC')">listar Cuentas</a> |
		<a href="#" onclick="nuevo_cc()" style="display:none;">nueva CC</a> 
		<a href="#" onclick="ajax('div_cc_C','ac=listar_productos_x_linea')">Asociar productos a Cuenta Contable</a> |
		<a href="#" onclick="ajax('div_cc_C','ac=listar_asociados')">Ver asociados </a> 
		
		Consumos : 
		<a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_resumen')">Por C. Costo</a> | 
		<!--<a href="index_consumo_mensual.php" target="_blank">Por C. Costo</a> | //-->
		<a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_resumen_cuentacontable')">Por C. Contable</a> | 
		
		<!--
		<a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_cuentacontable_x_centro_costo')">Relaci&oacute;n C. Costo y CC.</a> 
		<a href="#" onclick="ajax('div_cc_C','ac=listar_consumo_detalle')">Ver consumos (detalle) </a>
		
		
		//-->
		
		<a href="#" onclick="ajax('div_cc_C','ac=listar_equipos_no_asociados')">Prods. no Asociados</a> 
		
	</div>
	<div id="div_cc_C"></div>
</div>
</body>
</html>
