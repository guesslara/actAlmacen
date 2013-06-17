// JavaScript Document
var m_lineas_0=new Array();
var m_lineas_1=new Array();
var m_nextel_modelos=new Array();
function ajaxApp(divDestino,url,parametros,metodo){	
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		$("#cargadorGeneral").show(); 
	},
	success:function(datos){ 
		$("#cargadorGeneral").hide();
		$("#"+divDestino).show().html(datos);		
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
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
	$('#div_ventana4').hide(); 
}
function listar_default(){	
	ajax('detalleEmpaque','ac=listar_productos');
}
function paginar(linea,campo,operador,criterio,orden,ascdes,no_pagina){
	var datos='ac=listar_productos&linea='+linea+'&campo='+campo+'&operador='+operador+'&criterio='+criterio+'&orden='+orden+'&ascdes='+ascdes+'&no_pagina='+no_pagina;
	ajax('detalleEmpaque',datos);
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
	$('#div_ventana4').show();
	var lista_campos_0=new Array('id','id_prod','descripgral','especificacion','control_alm','status1');
	var lista_campos_1=new Array('id','clave','descripcion','especificacion','control de almacen','status');
	var mi_html='';
	mi_html+='<br><center><h3>Buscar<h3></center>';	
	mi_html+='<table align="center" cellspacing="1" cellpadding="2" border="0" style="font-size:12px;" >';	
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">L&iacute;nea</th>';
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
			mi_html+='<th class="campo_vertical">Campo</th>';
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
			mi_html+='<th class="campo_vertical">Operador</th>';
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
			mi_html+='<th class="campo_vertical">Criterio</th>';
			mi_html+='<td align="left"><input type="text" id="txt_criterio" onkeyup="busquedaX(5891,event)"></td>';
		mi_html+='</tr>';
		mi_html+='<tr>';
			mi_html+='<th class="campo_vertical">Orden</th>';
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
	$('#div_ventana4').html(mi_html);
	$("#txt_criterio").focus();
}
function buscar_nextel(){
	$('#div_transparente').show(); 
	$('#div_ventana3').show();	
	var mi_html='';
	//mi_html+='<h1>&nbsp;</h1><br>';
	mi_html+='<center><h3>Filtrar Productos Nextel </h3></center>';	
	mi_html+='<br><table align="center" cellspacing="0" cellpadding="2" >';	
		mi_html+='<tr>';
			mi_html+='<td>Modelo &rarr; </td>';
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
	mi_html+='<div align="center"><input type="button" value="Filtrar" onclick="buscar_nextelX()"></div>';	
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