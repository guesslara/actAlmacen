<?php
session_start();
if(!empty($_POST)){
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=UTF-8");
	//print_r($_POST);
	$ac=$_POST["ac"];
	switch ($ac){
		case "valor_status":
			require_once("../clases/valor.php");	
			$v1=new valor();
			$v1->valor_status($_POST["year"]);		
			break;
		case "valor_lineas":
			require_once("../clases/valor.php");	
			$v1=new valor();
			$v1->valor_lineas();		
			break;			
		default:
			echo "<br>&nbsp;&rarr; Accion no Definida. ";
			break;		
	}
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Valor del Inventario</title>
<style type="text/css">
body{ margin:0px;}
#div_mainX{ font-family:Arial, Helvetica, sans-serif; font-size:small; }
#div_mainX table{ border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; background-color:#FFFFFF; }
#div_mainX th { border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; background-color:#efefef; text-align:center; }		
#div_mainX td { border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }

h3,h4{ text-align:center; }

#div_A{ text-align:center; font-weight:bold; color:#333333; padding:5px; font-size:11pt; background-color:#FFFFFF; }
#div_B{ text-align:center;  background-color:#FFFFFF; padding:2px;}
#div_C{ padding:2px; color:#333333; }

a{ text-decoration:none; color:#0000FF; }
a:hover{ color:#ff0000; }	
</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="JavaScript" src="../cuentas_contables/js/FusionCharts.js"></script>
<script language="javascript">
//alert("OK");
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="<?=$_SERVER['PHP_SELF']?>";
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:url,
		data:datos,
		beforeSend:function(){ 
			$("#"+capa).html('<div style="text-align:center;">Procesando, espere un momento</div>'); 
		},
		success:function(datos){ 
			$("#"+capa).show().html(datos);
		},
		timeout:99999999,
		error:function() { $("#"+capa).show().html('<div style="text-align:center;">Error: El servidor no responde. <br>Por favor intente mas tarde. </div>'); }
	});
}


</script>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<div id="div_mainX">
	<div id="div_A">Valor del Inventario IQ. </div>
	<div id="div_B">
		<a href="index.php" title="Volver a Reportes ">&lArr;</a> |
		<!--<a href="#" onclick="ajax('div_C','ac=valor_status&year=2011')">status 2011</a> |-->
		<a href="#" onclick="ajax('div_C','ac=valor_status&year=2012')">status 2012</a> |
		<a href="#" onclick="ajax('div_C','ac=valor_lineas&year=2012')">l&iacute;neas 2012</a>
	</div>
	<div id="div_C"></div>
</div>

</body>
</html>
