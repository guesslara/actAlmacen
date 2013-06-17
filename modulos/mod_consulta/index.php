<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inventario IQ <?=date("Y");?></title>
<style type="text/css">
body,html,document{ position:absolute; width:100%; height:100%; margin:0px; padding:0px; background-color:#fff; color:#000; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:small;}
#div_transparente{ position:fixed; width:100%; height:100%; margin:0px; padding:0px; z-index:2; background-image:url(../../img/transparente2.png); cursor:pointer; display:none; }
/*
#div_ventana1 { position:absolute; width:300px; height:150px; left:50%; top:50%; margin-left:-400px; margin-top:-75px; z-index:3; overflow:auto; display:none; background-image:url(img/detalle0.png); }
*/
#div_ventana1 { position:absolute; width:150px; height:400px; left:-50px; top:50%; margin-top:-200px; z-index:3; overflow:auto; display:none; background-image:url(img/detalle3v.png); background-repeat:no-repeat; text-align:left; opacity:.1; }
.icono_01{ position:relative; width:70px; height:70px; float:left; cursor:pointer; clear: right; margin-left:25px; margin-top:3px; /*margin-right:50px;*/ }

#div_ventana2 { position:absolute; width:700px; height:400px; left:50%; margin-left:-350px; margin-top:-200px; top:50%; z-index:4; overflow:auto; display:none; background-image:url(img/detalle1b.png); }
#div_ventana3 { position:absolute; width:400px; height:300px; left:50%; margin-left:-200px; margin-top:-150px; top:50%; z-index:4; overflow:auto; display:none; background-image:url(img/login.png); }

#div_mainX{ position:absolute; width:100%; height:100%;  margin:0px; padding:0px; background-color:#FFFFFF;  z-index:1; }
	#div_A{ text-align:center; font-size:large; padding:2px; }
	#div_B{ text-align:center;  }
	#div_C{ text-align:justify; padding:2px; background-color:#fff; margin-top:0px;   }

#div_mainX table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
#div_mainX th { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; background-color:#efefef; text-align:center; }		
#div_mainX td { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }

#div_ventana2 table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
#div_ventana2 th { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; background-color:#efefef; text-align:center; }		
#div_ventana2 td { font-size:small; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }



/*td{ text-align:left; }*/
a{ text-decoration:none; color:#0033FF; }
h3{ text-align:center; }
select,option{ font-size:small; text-transform:capitalize; }


.campos_titulo_001{ cursor:pointer; }
	.campo_tituloX:hover{ color:#0000FF; }
.campo_vertical{ background-color:#efefef; text-align:left; font-weight:bold; font-size:small;  }

#lista_01{ margin-left:50px; }
	#lista_01 li { list-style:none; color:#0000FF; font-weight:bold; padding:2px; cursor:pointer; }
	#lista_01 li:hover { list-style:none; color:#FF0000; font-weight:bold; padding:2px; }


#div_tabla_resultados{ margin-top:10px; margin-bottom:10px; }
#div_tabla_resultados_buscador{ text-align:center; padding-right:5px; padding-bottom:2px;  font-weight:bold; color:#999999; }
#div_tabla_resultados_buscador input{ /*background-color:#efefcc;*/ text-align:center; color:#006600;font-size:20px; width:500px; }

#div_paginacion{ position:relative; width:96%; height:80px; left:50%; margin-left:-48%;  margin-top:10px; /*border:#ccc 1px solid;*/ background-color:#FFFFFF; text-align:center; }
	#div_paginacion1{ text-align:center; padding:3px; }
	#div_paginacion2{ text-align:center; padding:3px; font-size:x-small; }
	#div_paginacion3{ position:relative; width:210px; height:35px; clear:both; left:50%; margin-left:-105px;  /*border:#990000 1px solid;*/ background-color:#FFFFFF; text-align:center; }
		.paginacion_boton{ position:relative; float:left; width:30px; height:16px; margin:5px 0px 5px 5px; padding:2px; border:#999999 1px solid; background-color:#fff; 
text-align:center; font-weight:normal; font-size:x-small; cursor:pointer;  }
		.paginacion_boton:hover{ background-color:#D9FFB3; }

			#txt_no_pgina{ width:25px; height:15px; font-size:small; text-align:center; padding-top:0px; border:none; /*background-color:#fff;*/  }

.cdc_asociado{ position:relative; width:250px; height:auto; float:left; margin:1px; /*background-color:#CCCCCC;*/ padding:2px; overflow:hidden; }


</style>
<!--<script language="javascript" src="../js/jquery.js"></script>-->
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<script language="JavaScript" src="../cuentas_contables/js/FusionCharts.js"></script>
<script language="javascript">
var m_lineas_0=new Array();
var m_lineas_1=new Array();
var m_nextel_modelos=new Array();
/*
var lista_campos_0=new Array();
var lista_campos_1=new Array();
*/
$(document).ready(function(){ 
	ajax('div_D','ac=obtener_lineas');
	
	listar_default();
	//alert("OK");	
	document.getElementById("txt_buscador_criterio").focus();
	//pruebas_de_amor();
	$("#te_amo1").hide();
});
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="acciones.php";
	$.ajax({
		async:true, type: "POST", dataType: "html", contentType: "application/x-www-form-urlencoded",
		url:url, data:datos, 
		beforeSend:function(){ 
			//$("#"+capa).show().html('<div align="center">Procesando, espere un momento.</div>'); 
			$("#"+capa).show(); 
		},
		success:function(datos){ 
			$("#"+capa).show().html(datos); 
		},
		timeout:999999,
		error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function cancelar(){
	$('#div_transparente').hide(); 
	$('#div_ventana1').hide(); 
	$('#div_ventana2').hide();
	$('#div_ventana3').hide(); 
}
// =============================================================================================================================================
function listar_default(){
	ajax('div_C','ac=listar_productos');
}
function paginar(linea,campo,operador,criterio,orden,ascdes,no_pagina){
	var datos='ac=listar_productos&linea='+linea+'&campo='+campo+'&operador='+operador+'&criterio='+criterio+'&orden='+orden+'&ascdes='+ascdes+'&no_pagina='+no_pagina;
	ajax('div_C',datos);
	//alert(datos);
}
function ir_a_pagina(linea,campo,operador,criterio,orden,ascdes,no_pagina,numeroX,mi_valor,no_maximo_de_pagina,elEvento){
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	if (codigo==13){ // Enter o Tabulacion...
		if(numeroX==0){
			//alert("Ir a la Pagina : "+mi_valor);
			var mi_nueva_pagina=parseInt(mi_valor);
			if(isNaN(mi_nueva_pagina)){
				alert("Solo introduzca numeros.");
				return;
			}
			if(mi_nueva_pagina>0&&mi_nueva_pagina<=no_maximo_de_pagina){
				// ---------
			}else{
				alert("Introduzca un numero entre 0 y "+no_maximo_de_pagina+".");
				return;				
			}
			paginar(linea,campo,operador,criterio,orden,ascdes,mi_nueva_pagina);
		}
	}
}

function ver_detalle_producto(id_producto){
	$('#txt_id_producto_seleccionado').val(id_producto);
	$("#div_ventana1").animate({
		opacity: 1,
		left: "100px"
	});
	$("#div_ventana1").animate({
		opacity: 1,
		left: "5px"
	});
	$("#div_ventana1").fadeIn();
	$('#div_transparente').show(); 
	$('#div_ventana1').show();
}
function buscar(){
	$('#div_transparente').show(); 
	$('#div_ventana3').show();
	var lista_campos_0=new Array('id','id_prod','descripgral','especificacion','control_alm','status1');
	var lista_campos_1=new Array('id','clave','descripcion','especificacion','control de almacen','status');
	var mi_html='';
	mi_html+='<br><h3>Buscar<h3>';	
	mi_html+='<table align="center" cellspacing="0" cellpadding="2" >';	
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">l&iacute;nea</th>';
			mi_html+='<td align="left">';
				mi_html+='<select id="sel_buscar_linea">';
					mi_html+='<option value=""> Todo </option>';
					for(var i0=0;i0<m_lineas_0.length;i0++){
						mi_html+='<option value="'+m_lineas_0[i0]+'"> '+m_lineas_0[i0]+'. '+m_lineas_1[i0]+' </option>';
					}
				mi_html+='</select>';
			mi_html+='</td>';			
		mi_html+='</tr>';
		mi_html+='<tr align="left">';
			mi_html+='<th class="campo_vertical">campo</th>';
			//mi_html+='<td><select id="sel_buscar_campo"><option value="">...</option></select></td>';
			mi_html+='<td align="left">';
				mi_html+='<select id="sel_buscar_campo">';
					mi_html+='<option value=""> ...</option>';
					for(var i=0;i<lista_campos_0.length;i++){
						mi_html+='<option value="'+lista_campos_0[i]+'"> '+lista_campos_1[i]+' </option>';
					}
				mi_html+='</select>';
			mi_html+='</td>';		
		mi_html+='</tr>';		
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">operador</th>';
			mi_html+='<td align="left">';
				mi_html+='<select id="sel_buscar_operador">';
					mi_html+='<option value="LIKE"> &nbsp;&nbsp; similar a ...</option>';
					mi_html+='<option value="="> =&nbsp; igual a ... </option>';
					mi_html+='<option value="<"> &lt;&nbsp; menor a ... </option>';
						mi_html+='<option value="<="> &lt;= menor o igual a ... </option>';
					mi_html+='<option value=">"> &gt;&nbsp; mayor a ... </option>';
						mi_html+='<option value=">="> &gt;= mayor o igual a ... </option>';
					mi_html+='<option value="<>"> != distinto de </option>';
				mi_html+='</select>';
			mi_html+='</td>';
		mi_html+='</tr>';
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">criterio</th>';
			mi_html+='<td align="left"><input type="text" id="txt_criterio" onkeyup="busquedaX(5891,event)"></td>';
		mi_html+='</tr>';
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">orden</th>';
			mi_html+='<td align="left">';
				mi_html+='<select id="sel_buscar_orden">';
					mi_html+='<option value=""> ...</option>';
					for(var i=0;i<lista_campos_0.length;i++){
						mi_html+='<option value="'+lista_campos_0[i]+'"> '+lista_campos_1[i]+' </option>';
					}
				mi_html+='</select>';
			mi_html+='</td>';		
		mi_html+='</tr>';
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">ASC / DESC</th>';
			mi_html+='<td align="left"><select id="sel_buscar_asc_desc"><option value="ASC">ASC</option><option value="DESC">DESC</option></select></td>';
		mi_html+='</tr>';								
			
	mi_html+='</table><br>';
	mi_html+='<div align="center"><input type="button" value="Buscar" onclick="buscarX()"></div>';	
	$('#div_ventana3').html(mi_html);
	$("#txt_criterio").focus();
}
function buscar_nextel(){
	$('#div_transparente').show(); 
	$('#div_ventana3').show();	
	var mi_html='';
	mi_html+='<h1>&nbsp;</h1><br>';
	mi_html+='<h3>B&uacute;squeda Nextel </h3>';	
	mi_html+='<br><table align="center" cellspacing="0" cellpadding="2" >';	
		mi_html+='<tr>';
			mi_html+='<td>modelo &rarr; </td>';
			mi_html+='<td align="left">';
				mi_html+='<select id="sel_buscar_nextel_modelo">';
					mi_html+='<option value=""> Todo </option>';
					for(var i0=0;i0<m_nextel_modelos.length;i0++){
						mi_html+='<option value="'+m_nextel_modelos[i0]+'"> '+' &rArr; '+m_nextel_modelos[i0]+' </option>';
					}
				mi_html+='</select>';
			mi_html+='</td>';			
		mi_html+='</tr>';
	mi_html+='</table><br><br>';
	mi_html+='<div align="center"><input type="button" value="Buscar" onclick="buscar_nextelX()"></div>';	
	$('#div_ventana3').html(mi_html);
}
function buscar_nextelX(){
	var modelo=$("#sel_buscar_nextel_modelo").val();
	var operador;
	var orden;
	if(modelo==''||modelo==' '||modelo==undefined||modelo==null){
		operador='LIKE';
		orden='especificacion'
	}else{
		operador='='
		orden='control_alm'
	}
	paginar('NX','especificacion',operador,modelo,orden,'ASC',1);
	$('#div_transparente').hide(); 
	$('#div_ventana3').hide();	
}
function buscarX(){
	var l=$("#sel_buscar_linea").val();
	var c=$("#sel_buscar_campo").val();
	var o=$("#sel_buscar_operador").val();
	var r=$("#txt_criterio").val();
	var d=$("#sel_buscar_orden").val();
	var a=$("#sel_buscar_asc_desc").val();
	//alert(l+','+c+','+o+','+r+','+d+','+a);
	paginar(l,c,o,r,d,a,1);
	cancelar();
}

function exportar(){
	//alert("<br>exportar()");
	var l=$("#spa_lin").text();
	var c=$("#spa_cam").text();
	var o=$("#spa_ope").text();
	var r=$("#spa_cri").text();
	var d=$("#spa_ord").text();
	var a=$("#spa_aod").text();
	var lista_campos=$("#spa_camposX").text();
	var datos='ac=exportar_catalogo_excel&linea='+l+'&campo='+c+'&operador='+o+'&criterio='+r+'&orden='+d+'&asc_desc='+a+'&lista_campos='+lista_campos;
	if(confirm('¿ Desea exportar los datos ?')) location.href='xls_inventario.php?'+datos;
	//alert(datos);
}
function busca_producto1(numeroX,linea,operador,orden,asc_desc){
	var mi_valor=document.getElementById("txt_buscador_criterio").value;
	//alert(n+"\n"+elEvento);
	//var evento = elEvento || window.event;
	//var codigo = evento.charCode || evento.keyCode;
	paginar(linea,'descripgral',operador,mi_valor,orden,asc_desc,1);
	//if (codigo==13){ // Enter o Tabulacion...		
		/*if(numeroX==1985){
			paginar(linea,'descripgral',operador,mi_valor,orden,asc_desc,1);
		}*/
	//}
}

function busquedaX(numeroX,elEvento){
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	if (codigo==13){ // Enter o Tabulacion...
		if(numeroX==5891){
			buscarX();
		}
	}
}

function cancelar_tecla(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
	if (codigo==27){
		//alert("Cancelar");
		cancelar();
	}	
}
function pruebas_de_amor(){
	var prueba_miamor="TE AMO MUCHO gerardo mi amorsito";
	document.getElementById("te_amo").value=prueba_miamor;
	
	//FUNCION REALIZADA CON MUCHO AMOR PARA MI LEONAR, DE COLOR AMARILLO, MI AMORSITO KI YO AMO MUCHO Y 
	//QUIERO EL DIA DE 5 DE JULIO DEL 2011 12:13HRS
}
document.onkeypress = cancelar_tecla;
</script>
</head>

<body>
<div id="div_transparente" onclick="cancelar()"></div>
<div id="div_ventana1">
	<!-- //-->
	<div align="center">
		<input type="hidden" id="txt_id_producto_seleccionado" />
		<p><br /><br />
		<img src="img/btn_1.png" class="icono_01" title="Propiedades" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=propiedades')">		</p>
		<p><br /><br />
		<img src="img/btn_2.png" class="icono_01" title="Existencias" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=existencias')">		</p>
		<p><br /><br /><br /><br />
		<img src="img/btn_3.png" class="icono_01" title="Kardex" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=kardex')">		</p>
		<p><br /><br />
		<img src="img/btn_4.png" class="icono_01" title="Comportamiento" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=comportamiento')">		</p>
		<!--<img src="img/btn_5.png" class="icono_01" title="Editar">//-->
	</div>
</div>
<div id="div_ventana2"></div>
<div id="div_ventana3"></div>
<div id="div_mainX">
	<div id="div_A">Inventario IQ <?=date("Y");?></div>
	<div id="div_B">
		<a href="#" onclick="listar_default()">listar productos</a> | 
		<a href="#" onclick="buscar_nextel()">listar productos NX</a> | 
		<a href="#" onclick="buscar()">buscar</a> |
		<a href="#" onclick="exportar()">exportar</a>	</div>
	<div id="div_tabla_resultados_buscador"><br />
		Producto <input type="text" id="txt_buscador_criterio" onkeyup="busca_producto1(1985,'<?=$linea?>','<?=$operador?>','<?=$orden?>','<?=$ascdes?>')" />
		<!--<input type="text" id="txt_buscador_criterio" onkeyup="busca_producto1(1985,'<?=$linea?>','<?=$operador?>','<?=$orden?>','<?=$ascdes?>',this.value,event)" />--><br /><br />
	</div>
<div  id="te_amo1" >
	Cada dia que pasa:<input type="text" id="te_amo" style=" width:300px;" onchange="pruebas_de_amor()" readonly="readonly"/>
</div>			
	<div id="div_C">
		<?php
		
		?>
	</div>
	<div id="div_D"></div>
</div>
</body>
</html>
