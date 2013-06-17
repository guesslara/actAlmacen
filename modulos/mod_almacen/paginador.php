<?php 
//session_start();
	//if (isset($_GET['menu'])) $_SESSION['menu']=0;

include ("../php/conectarbase.php");
$lista_campos="id,id_prod,descripgral,especificacion,control_alm,$cexi0,$ctra0";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Paginador con AJAX</title>
<script language="javascript" src="../js/jquery.js"></script>
<script language="javascript">
function start()
{
	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"paginador2.php",
    data:"action=xxx",
    beforeSend:inicio1,
    success:resultado1,
    timeout:10000,
    error:problemas1
  	});
}
function inicio1()
{
  	$("#contenido").show().html('<img src="../img/barra6.gif">');
}
function resultado1(datos)
{
	$("#contenido").show('slow').html(datos);
}
function problemas1()
{
	$("#contenido").show().html('Error: El servidor no responde.');
}
// =======================================================================================
function paginar(ca,op,cr,or,as,pa)
{
	if (cr==undefined||cr==''||cr=='undefined')
		cr='';
	var datos="action=paginar&campo="+ca+"&op="+op+"&cri="+cr+"&orden="+or+"&ascdes="+as+"&pagina="+pa;
	//alert(datos);
	$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"paginador2.php",
    data:datos,
    beforeSend:inicio1,
    success:resultado1,
    timeout:10000,
    error:problemas1
  	});
	
}
function buscar()
{
	var txt_ca=$("#txt_campo").attr("value");
	var txt_op=$("#txt_op").attr("value");	
	var txt_cri=$("#txt_buscar").attr("value");
	var txt_ord=$("#txt_orden").attr("value");
	var txt_as=$("#txt_ascdes").attr("value");	

	//alert('Buscar y Paginar:'+'\n'+txt_ca+'\n'+txt_op+'\n'+txt_cri+'\n'+txt_ord+'\n'+txt_as);
	paginar(txt_ca,txt_op,txt_cri,txt_ord,txt_as,'1');
}
function exportar()
{
	$("#transparente").show();
	$('#ventana1').show();	
}
function exportar_xls()
{
	var w=$("#where1").attr("value");
	var ndr1=$("#ndr1").attr("value");
	//alert(w+'\n'+ndr1);
	if (ndr1>100){
		
		var conf=confirm("Esta a punto de Exportar gran cantidad de datos. \nEsto puede requerir un tiempo considerable.\n\n\n¿Desea Continuar? ");
		//alert(conf);
		if (!conf==true)
			cancelar();
		else 
			location.href="reportes/xls_inventario.php?sql="+w;	
	} else {
		location.href="reportes/xls_inventario.php?sql="+w;	
	}	
}
// ===========================================================================
function ver_producto(id)
{
	$("#transparente").show();
	$("#ventana2").show();
	//alert(id);
		$.ajax({
    async:true,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url:"fichaprod2.php",
    data:"action=ver_producto&id="+id,
    beforeSend:inicio2,
    success:resultado2,
    timeout:10000,
    error:problemas2
  		});	
}
function inicio2()
{
  	$("#v2_c").html('<img src="../img/barra6.gif">');
}
function resultado2(datos)
{
	$("#v2_c").html(datos);
}
function problemas2()
{
	$("#v2_c").html('Error: El servidor no responde.');
}


// ===========================================================================
function bavanzada()
{
	$('#transparente').show();
	$('#ventana3').show();
}
// ===========================================================================
function bavanzada2()
{
	var ca=$("#e_campo").attr("value");
	var op=$("#e_operador").attr("value");
	var cr=document.frm_ba.e_criterio.value;
	var or=$("#e_orden").attr("value");
	var as=document.frm_ba.e_ascdesc.value;
	//alert(ca+'\n='+op+'\n='+cr+'\n='+or+'\n='+as);
	paginar(ca,op,cr,or,as,'1');
	cancelar();
	
}
// ===========================================================================


function cancelar()
{
	$('#transparente').hide();
	$('#ventana1').hide();
	$('#ventana2').hide();	
	$('#ventana3').hide();		
}
function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
	if (codigo==27){
		cancelar();
	}	
}
document.onkeypress = cerrar;
</script>
<style type="text/css">
body{ margin:0px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
a:link{ text-decoration:none;}
a:hover{ text-decoration:none; color:#FF0000;}
a:visited{ text-decoration:none;}

#all{ background-color:#ffffff; z-index:1; position:absolute; width:100%; height:100%; margin:0px; padding:0px;}
#paginador{ background-color:#FFFFFF; /*border:#333333 1px solid;*/ width:900px; height:auto; position:relative; 
/*top:50%;*/ left:50%; margin:2px; margin-left:-450px; padding:0px;}
#tit{ height:30px; text-align:right;}
#contenido{ margin-top:10px; background-color:#FFFFFF; padding:0px; text-align:center; }
.td1{ border-right:#CCCCCC 1px solid; padding:1px;}
.buscador{ background-color:#ffffff; text-align:center; font-size:11px; margin-bottom:1px; margin:1px; }
.form_buscador{ text-align:right; margin:0px;}

 .paginador1:link{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#000000; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:10px; margin:1px;}
 .paginador1:hover{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px;}
 .pagact:link{ border:#CCCCCC 1px solid; border-bottom:#CCCCCC 2px solid; border-right:#CCCCCC 2px solid; background-color:#efefef; color:#333333; font-weight:normal; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
 .pagact:visited{ border:#CCCCCC 1px solid; background-color:#efefef; color:#333333; font-weight:bold; text-align:center; 
 width:20px; height:30px; padding:2px; font-size:15px; margin:1px; margin-right:4px;}
/*==========================================================================================*/
#transparente{ background-image:url(../img/transparente.png); width:100%; height:100%; position:absolute; margin:0px; padding:0px; z-index:2; display:none;}
#ventana1{ display:none; position:absolute; z-index:3; width:300px; height:200px; top:50%; left:50%; margin-top:-150px; margin-left:-100px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v1_t{ text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}

#ventana2{ display:none; position:absolute; z-index:3; width:600px; height:500px; top:50%; left:50%; margin-top:-250px; margin-left:-300px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v2_t{ height:17px; text-align:right; padding:1px; background-color:#333333; color:#FFFFFF;}
#v2_c{ height:479px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}

#ventana3{ display:none; position:absolute; z-index:3; width:400px; height:220px; top:50%; left:50%; margin-top:-110px; margin-left:-200px; 
border:#333333 2px solid; background-color:#FFFFFF;}
#v3_t{ height:17px; text-align:right; padding:1px; padding-bottom:2px; background-color:#333333; color:#FFFFFF;}
#v3_c{ height:198px; margin-top:0px; overflow:auto; text-align:right; padding:1px; background-color:#ffffff; text-align:center;}

</style>
</head>
<body onload="start();">
<div id="all">
	<? 
	//if (!$_SESSION['menu'])
		include("menu.php");
	
	 ?>
	<div id="paginador">
		<?php //if (!$_SESSION['menu']) { ?>
		<div id="tit">
			<a href="javascript:exportar();">Exportar Datos</a><br />
			<a href="javascript:bavanzada();">B&uacute;squeda avanzada</a>
		</div>
		<?php //} ?>
		<div id="contenido">...</div>
	</div>
	<? include("../f.php"); ?>
</div>
<div id="transparente"></div>

<div id="ventana1">
	<div id="v1_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Exportar informaci&oacute;n</div>
	<a href="javascript:cancelar();"><img src="../img/cerrar_2.png" align="Cerrar" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v1_c">
		<img src="../img/xls1.png" border="0" title="Exportar datos a Excel." style="cursor:pointer; margin:10px; margin-top:50px;" />
		<a href="javascript:exportar_xls();" style="position:absolute; top:89px; left:87px; " title="Esta operacion puede tardar un tiempo considerable en relacion al numero de productos.">
		Exportar resultados a Excel.</a>	</div>	
</div>

<div id="ventana2">
	<div id="v2_t">
	<div style="float:left; padding-left:5px; font-weight:bold;">Descripci&oacute;n del Producto</div>
	<a href="javascript:cancelar();"><img src="../img/cerrar_2.png" align="Cerrar" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v2_c">
		<img src="../img/xls1.png" border="0" title="Exportar datos a Excel." style="cursor:pointer; margin:10px; margin-top:50px;" />
		<a href="javascript:exportar_xls();" style="position:absolute; top:89px; left:87px; " title="Esta operacion puede tardar un tiempo considerable en relacion al numero de productos.">
		Exportar resultados a Excel.</a>	</div>	
</div>

<div id="ventana3">
	<div id="v3_t">
		<div style="float:left; padding-left:5px; font-weight:bold;">B&uacute;squeda avanzada</div>
		<a href="javascript:cancelar();"><img src="../img/cerrar_2.png" align="Cerrar" border="0" title="Cerrar esta ventana." style="cursor:pointer;" /></a></div>
	<div id="v3_c">


		<form id="frm_ba" name="frm_ba" style="margin:0px;" method="post" action="<?=$_SERVER['PHP_SELF']?>">
		<table width="90%" cellspacing="0" align="center" style="margin-top:2px; text-align:left;">
			<tr>
				<td width="13%">&nbsp;</td>
				<td width="72%">&nbsp;</td>
			</tr>
			<tr>
				<td>Campo:</td>
				<td>
				<select name="e_campo" id="e_campo">
                  <option value="id_prod">Clave del producto</option>
                  <option value="descripgral">Descripci&oacute;n</option>
                  <option value="especificacion">Especificaci&oacute;n</option>
                  <option value="control_alm">Control de Almac&eacute;n</option>
                  <option value="<?=$cexi0;?>">Existencias</option>
                  <option value="<?=$ctra0;?>">Transferencias</option>				  
                </select>				</td>
			</tr>
			<tr>
				<td>Operador</td>
				<td>
				<select name="e_operador" id="e_operador">
				  <option value="LIKE">Similar a</option>
                  <option value="=">Igual</option>
                  <option value=">">Mayor que</option>
                  <option value="<">Menor que</option>
                  <option value="<>">Distinto</option>
                </select></td>
			</tr>
			<tr>
				<td>Criterio</td>
				<td><input type="text"  name="e_criterio"  id="e_criterio" value="" /></td>
			</tr>
			<tr>
				<td>Orden</td>
				<td>
				<select name="e_orden" id="e_orden">                  
				  <option value="id_prod">Clave del producto</option>
                  <option value="descripgral">Descripci&oacute;n</option>
                  <option value="especificacion">Especificaci&oacute;n</option>
                  <option value="control_alm">Control de Almac&eacute;n</option>
                  <option value="<?=$cexi0;?>">Existencias</option>
                  <option value="<?=$ctra0;?>">Transferencias</option>					
				</select>
				
				<select name="e_ascdesc" id="e_ascdesc">                  
				  <option value="ASC">Ascendente</option>
                  <option value="DESC">Descendente</option>
				</select>				
			</tr>												
			<tr>
				<td colspan="2" style="text-align:center; padding:2px;">
					<br /><input type="button" id="va_enviar" value="Buscar" onclick="bavanzada2();" />
				</td>
			</tr>												
		</table>
	</form>	



	</div>	
</div>

</body>
</html>
