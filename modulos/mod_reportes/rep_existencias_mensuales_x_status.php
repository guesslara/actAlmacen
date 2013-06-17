<?php
session_start();
if(!empty($_POST)){
	//echo "<br>";	print_r($_POST);
	$ac=$_POST["ac"];
	if($ac=='listar_existencias_mensuales'){
		require_once("../clases/valor_mensual_resumen.php");	
		$vm1=new valor_mensual();
		$vm1->listar_valor_mensual();		
		break;		
	}
	if($ac=='listar_existencias_detalle'){
		require_once("../clases/valor_mensual_detalle.php");	
		$vm1=new valor_mensual();
		$vm1->listar_valor_mensual();		
		break;		
	}	
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Existencias Mensuales</title>
</head>
<style type="text/css">
body{ margin:0px;}
#mainX{ font-family:Arial, Helvetica, sans-serif; font-size:small; }
#div_a{ text-align:center; font-size:large; color:#333333; padding:3px; display:none; }
#div_b{ text-align:center; padding:3px; }


table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
td,th { font-size:10pt; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }		
th{ background-color:#efefef; }
a{ text-decoration:none; color:#0033FF; }
h2,h3{ text-align:center; }

.entradas{ color:#009900; }
.salidas{ color:#FF3300; }

.status_0{ color:#009900; }
.status_1{ color:#0066FF; }
.status_2{ color:#FF0000; }


</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="JavaScript" src="../cuentas_contables/js/FusionCharts.js"></script>
<script language="javascript">
$(document).ready(function (){
	ajax('div_c','ac=listar_existencias_mensuales');
});
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="<?=$_SERVER['PHP_SELF']?>";
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
</script>
<body>
<?php include("../menu/menu.php"); ?>
<div id="mainX">
	<div id="div_a">Reporte de Existencias Mensuales</div>
	<div id="div_b">
		<a href="index.php" title="Regresar a Reportes ">&lArr;</a> | 
		<a href="#" onclick="ajax('div_c','ac=listar_existencias_mensuales')">resumen</a> |
		<a href="#" onclick="ajax('div_c','ac=listar_existencias_detalle')">detalle</a>
	</div>
	<div id="div_c"></div>
	<div id="div_d"></div>
</div>


</body>
</html>
