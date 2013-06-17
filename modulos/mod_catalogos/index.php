<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Usuarios del Sistema</title>

  <link rel="stylesheet" type="text/css" media="all" href="../js/Calendario/calendar-green.css" title="win2k-cold-1" /> 
  <script src="../js/jquery.js" type="text/javascript"></script>
  <script type="text/javascript" src="../js/Calendario/calendar.js"></script>
  <script type="text/javascript" src="../js/Calendario/calendar-es.js"></script>
  <script type="text/javascript" src="../js/Calendario/calendar-setup.js"></script> 

  <script type="text/javascript">
	//$(document).ready(accion('listar'));
	function accion(a){
		  $.ajax({
		   async:true,
		   type: "POST",
		   dataType: "html",
		   contentType: "application/x-www-form-urlencoded",
		   url:"usuarios.php",
		   data:"accion="+a,
		   beforeSend:function(){ 
				$("#contenido").show().html('<center><br><img src="../img/barra6.gif"><br>Cargando pagina, espere un momento.</center>'); 
			},
		   success:function(datos){ $("#contenido").show().html(datos); },
		   timeout:90000000,
		   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		 }); 	
	}
	
	function validar_frm0(){
		var nivel_usuario=$("#nivel_usuario").attr("value");		if (validar_campo("Nivel de Usuario",nivel_usuario)) { /*OK*/ } else { return; }
		var grupo=$("#grupo").attr("value");						if (validar_campo("Grupo",grupo)) { /*OK*/ } else { return; }				
		var usuario=$("#usuario").attr("value");					if (validar_campo("Usuario",usuario)) { /*OK*/ } else { return; }
		var password=$("#password").attr("value");					if (validar_campo("Password",password)) { /*OK*/ } else { return; }
		var dp_nombre=$("#dp_nombre").attr("value");				if (validar_campo("Nombre Completo",dp_nombre)) { /*OK*/ } else { return; }
		var de_proyecto=$("#de_proyecto").attr("value");				if (validar_campo("Area / Proyecto",de_proyecto)) { /*OK*/ } else { return; }

		var de_noempleadoiq=$("#de_noempleadoiq").attr("value");		if (validar_campo("No. de empleado IQ",de_noempleadoiq)) { /*OK*/ } else { return; }
		var obs=$("#obs").attr("value");									
		var datos="guardar_usuario&usuario="+usuario+"&password="+password+"&grupo="+grupo+"&nivel="+nivel_usuario+"&nombre="+dp_nombre+"&area="+de_proyecto+"&noemp="+de_noempleadoiq+"&obs="+obs;
		//alert(datos);
		accion(datos);
		
		
		//alert(id_usuario+"\n"+f_alta+"\n"+usuario+"\n"+password+"\n"+password2+"\n"+activo+"\n"+dp_nombre+"\n"+dp_apaterno+"\n"+dp_materno+"\n"+dp_paisorigen+"\n"+dp_curp+"\n"+foto+"\n"+dp_calle+"\n"+dp_nexterior+"\n"+dp_colonia+"\n"+dp_ninterior+"\n"+dp_delmun+"\n"+dp_entidad+"\n"+dp_pais_residencia+"\n"+dp_tel_domicilio+"\n"+dp_tel_particular+"\n"+de_empresa+"\n"+de_proyecto+"\n"+de_sistema+"\n"+de_noempleadoiq+"\n"+de_puesto+"\n"+de_jefe_inmediato+"\n"+de_tel_trabajo+"\n"+obs);
		if (confirm("¿Desea guardar el usuario?")){
		     //document.frm0.submit();
		 }		
		
	}
	
	function validar_campo(campo,valor){
		//alert("Campo: "+campo+"\nValor: "+valor);
		if (valor==""||valor=="undefined")
		{
			alert("Error: El campo: "+campo+" es obligatorio, por favor capture un valor.");
			return false;
		} else {
			// ok
			return true;
		}	
	}
	
	function obtenervalores1(a){
		var claves="";
		if (document.getElementById("frm1"))
		{
			for (var i=0;i<document.frm1.elements.length;i++)
			{
				if (document.frm1.elements[i].type=="checkbox")
				{
					if (document.frm1.elements[i].checked)
					{
						//alert("Variable claves=["+claves+"]");
						if (claves=="")
							claves=claves+document.frm1.elements[i].value;
						else
							claves=claves+","+document.frm1.elements[i].value;
					}	
				}
			}
			//alert("Claves: "+claves);
		}
		if (claves==""||claves=='undefined') return;	
		if (a=="eliminar")
		{
			//alert("Eliminar: "+claves);
			if (confirm("¿Desea eliminar el/los usuario(s) seleccionado(s)?"))
			{
			  $.ajax({
			   async:true,
			   type: "POST",
			   dataType: "html",
			   contentType: "application/x-www-form-urlencoded",
			   url:"usuarios.php",
			   data:"accion=eliminar&ids="+claves,
			   beforeSend:function(){ 
					$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
				},
			   success:function(datos){ $("#contenido").show().html(datos); },
			   timeout:90000000,
			   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			 });
			} 			
		}
	}
	
	function ver_usuario(id_usuario){
		  $.ajax({
		   async:true,
		   type: "POST",
		   dataType: "html",
		   contentType: "application/x-www-form-urlencoded",
		   url:"usuarios.php",
		   data:"accion=ver_usuario&id_usuario="+id_usuario,
		   beforeSend:function(){ 
				$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 
			},
		   success:function(datos){ $("#contenido").show().html(datos); },
		   timeout:90000000,
		   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		 });
	}
</script>	
<link href="../css/style.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		
		#all { margin:0px 0px 0px 0px; }
			#titulo { text-align:center; padding:2px; font-size:16px; margin:10px 10px 10px 10px;  }
			#opciones { text-align:right; margin:1px 10px 2px 0px; }
			#contenido { text-align:left; margin:10px 10px 10px 0px; padding:10px 10px 10px 0px; }
			
		.txtoc { text-align:center; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}	
		.txtoi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}
		.txtvi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px dotted; height:17px;}
		
		.imgx { width:32px; height:32px;}
		/*.imgmediana{ width:50%; height:50%;}*/
		.cv { font-weight:bold; text-align:left; background-color:#EFEFEF; color: #666666; padding-left:5px; }				
	</style>	  
</head>

<body onload="accion('listar')">
	<?php include("../menu/menuX.php"); ?>
	<div id="all">
		<br />
		<div id="opciones">
			<a href="javascript:accion('listar');"><img src="../img/businessmen.png" border="0" title="Listar Usuarios" class="imgx" /></a>&nbsp;
			<a href="javascript:accion('nuevo');"><img src="../img/businessman_add.png" border="0" title="Agregar Usuario" class="imgx" /></a>&nbsp;
			<a href="#"><img src="../img/businessman_delete.png" border="0" title="Eliminar Usuario" class="imgx" /></a> 
		</div>
		<div id="contenido">
			<center>&nbsp;</center>
		</div>
	</div>
</body>
</html>
