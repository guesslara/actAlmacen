$(document).ready(function(){ 
	//ajax('div_cc_C','ac=listar_CC');
});
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="acciones.php";
	$.ajax({
		async:true, type: "POST", dataType: "html", contentType: "application/x-www-form-urlencoded",
		url:url, data:datos, 
		beforeSend:function(){ 
			$("#"+capa).show().html('<center>Procesando, espere un momento.</center>'); 
		},
		success:function(datos){ 
			$("#"+capa).show().html(datos); 
		},
		timeout:999999,
		error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}

function nuevo_cc(){
	$("#tr_cc_nueva").show();
	$("#txt_ccA").focus();
}
function nuevo_cc_cancelar(){
	$("#tr_cc_nueva").hide();
}
function nuevo_cc_guardar(){

	/*
	#txt_cc{ text-align:center; }
	#txt_ccA{ text-align:center; width:40px; }
	#txt_ccB{ text-align:center; width:25px; }
	#txt_ccC{ text-align:center; width:25px; }
	#txt_ccD{ text-align:center; width:25px; }
	#txt_ccDES{ text-align:left; width:250px; }
	#txt_ccOBS{ text-align:left; width:250px; }	
	*/
	var cue;
	var a=$("#txt_ccA").attr("value");
	var b=$("#txt_ccB").attr("value");
	var c=$("#txt_ccC").attr("value");
	var d=$("#txt_ccD").attr("value");
	var des=$("#txt_ccDES").attr("value");
	var obs=$("#txt_ccOBS").attr("value");
		cue=a+'-'+b+'-'+c+'-'+d;
	var validacionA=validar_campo_cuenta(a);
	var validacionB=validar_campo_cuenta(b);
	var validacionC=validar_campo_cuenta(c);
	var validacionD=validar_campo_cuenta(d);
	if(!(validacionA&&validacionB&&validacionC&&validacionD)){
		alert("Validacion Incorrecta, Verifique sus datos.");
		return;		
	}
	if(des==''||des==undefined||des==null){
		alert("Por favor NO omita campos obligatorios.");
		return;
	}
	if(confirm("¿ Desea agregar la Cuenta : "+cue+" ?")){
		$("#txt_cc").attr('value',cue);
		var datos="ac=cuenta_cc_insertar&cue="+cue+"&a="+a+"&b="+b+"&c="+c+"&d="+d+"&des="+des+"&obs="+obs;
		//ajax();
		//alert("nuevo_cc_guardar ("+datos+")");	
		$('#div_transparente').show(); 
		$('#div_ventana1').show();			
		ajax('div_ventana1',datos);		
	}
}
	function validar_campo_cuenta(valor_campo){
		
		if(valor_campo==''||valor_campo==undefined||valor_campo==null) return false;
		// Recorremos los caracteres de la cadena ...
		var valorX;
		//alert("Largo cadena="+valor_campo.length);
		
		for(var i=0;i<valor_campo.length;i++){
			valorX=parseInt(valor_campo[i]);
			if(isNaN(valorX)){
				//alert("Caracter NO valido.");
				return false;			
			}
			
			if(valorX>=0&&valorX<=9){
				// OK
			}else{
				//alert("Caracter ("+valorX+") NO valido. ");
				return false;
			}
			
		}
		return true;
		//var cadena
		/**/
	}


function tecla_X(n,elEvento){
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	if (codigo==13){ // Enter o Tabulacion...
		if(n==1) $("#txt_ccB").focus();
		if(n==2) $("#txt_ccC").focus();
		if(n==3) $("#txt_ccD").focus();
		if(n==4) $("#txt_ccDES").focus();
		if(n==5) $("#txt_ccOBS").focus();
		
		if(isNaN(n)){
			buscar_en_catalogo(n);	
		}
	}
}
/*
function tecla_X2(linea,this.value,elEvento){
	
}
*/
// =========================================================================================
function linea_productos(linea){
	$("#div_asociacion_p_cc1").hide();
	$("#div_asociacion_p_cc2").show();
		$("#div_asociacion_p_cc2").css('width','50%');
	$("#div_asociacion_p_cc3").show();
		$("#div_asociacion_p_cc3").css('width','50%');
	
	ajax('div_asociacion_p_cc1','ac=ver_productos_x_linea&linea='+linea+'&criterio=');
}
	function buscar_en_catalogo(linea){
		var criterio_d=$("#txt_criterio_descripcion").attr("value");
		ajax('div_asociacion_p_cc1','ac=ver_productos_x_linea&linea='+linea+'&criterio='+criterio_d);
	}
	function seleccionar_todos_los_productos(){
		$("#btn_sel_all").hide();
		$("#btn_lim_all").show();
		
		for(var i=0;i<document.frm_productos_x_linea.elements.length;i++){
			if (document.frm_productos_x_linea.elements[i].type=="checkbox"){
				document.frm_productos_x_linea.elements[i].checked=true; 
			}	
		}		
	}
function fn_asociar_productos_a_cc(){
	//	frm_productos_x_linea
	var mis_prods_seleccionados=obtener_productos_seleccionados();
	var mi_cc_seleccionada=$("input[@name=rad_cc]:checked").val();
	if(mis_prods_seleccionados==''||mis_prods_seleccionados==null||mis_prods_seleccionados==undefined||mis_prods_seleccionados.length<=0){
		alert("Por favor seleccione 1 o mas Productos.");
		return;
	}
	if(mi_cc_seleccionada==''||mi_cc_seleccionada==null||mi_cc_seleccionada==undefined){
		alert("Por favor seleccione 1 Cuenta Contable.");
		return;
	}	
	var datos="ac=asociar_prods_a_cc&cc="+mi_cc_seleccionada+"&prods="+mis_prods_seleccionados;

	//alert(datos);("+mis_prods_seleccionados+")
	if(confirm("¿Desea asociar los productos seleccionados a la CC : "+mi_cc_seleccionada+" ?")){
		$('#div_transparente').show(); 
		$('#div_ventana1').show();			
		ajax('div_ventana1',datos);
	}
}
	function obtener_productos_seleccionados(){
	var valores=new Array();
	for(var i=0;i<document.frm_productos_x_linea.elements.length;i++){
		if (document.frm_productos_x_linea.elements[i].type=="checkbox"){
			if (document.frm_productos_x_linea.elements[i].checked){
				valores.push(document.frm_productos_x_linea.elements[i].value);
			}
		}	
	}
	return valores;
}
	
// ==========================================================================================	
	
	
	
	