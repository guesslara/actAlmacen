<?php
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,4,10);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Planeaci&oacute;n Financiera.</title>
    <link href="../js/flot/examples/layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.pack.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script>
<script language="javascript">
	//document.ready(start);
	function ajax(capa,datos,ocultar_capa){
		$("#div_detalle").hide();
		$("#grafica").hide();
		
		if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
		var url="planeacion_financiera2.php";
		//alert("URL="+url+"\nCAPA="+capa+"\nDATOS="+datos);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:url,
			data:datos,
			beforeSend:function(){ 
				$("#"+capa).show().html("<center><img src='../img/barra6.gif'><br>Procesando, espere un momento.</center>"); 
			},
			success:function(datos){ $("#"+capa).show().html(datos); },
			timeout:90000000,
			error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});
	}	
	function start(){
		ajax("div_contenido","action=inicio");	
	}
	function ocultar(c){
		$("#"+c).hide();
	}	
	
</script>
<style type="text/css">
	body,document{ margin:0px;}
	#div_encabezado{ text-align:center; margin-top:5px;}
	#div_pie{ font-size:12px; text-align:center; border-top:#000000 1px dotted; color:#666666; padding:3px; margin-top:10px;}
	
	#div_detalle{ padding:10px;}
	
	h3{ text-align:center;}
	.tablaX{ border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; }
	.camposx{ text-align:center; font-weight:bold; border-bottom:#000000 2px solid;}
	
	.campo_inferior{border-top:#000000 2px solid;}
	.campo_A{ border-left:#000000 1px solid; border-right:#CCCCCC 1px solid;}
	.campo_d{ border-right:#CCCCCC 1px solid;}
	.campo_Z{ border-left:#CCCCCC 1px solid; border-right:#000000 1px solid;}
	
	
	#div1{ text-align:center;}
	.txt1 { border:#CCCCCC 1px solid; background-color:#FFFFFF; text-align:right;} 

	#datos{ position:relative; width:800px; height:600px; left:50%; margin-left:-400px; margin-bottom:5px; border:#EFEFEF 1px solid; }
	#grafica{ position:relative; width:800px;height:500px; left:50%; margin-left:-400px; border:#EFEFEF 1px solid; display:none; }
	
	.acotaciones{ text-align:center; color:#0000CC; font-size:12px; margin:5px;}	
</style>
</head>

<body>
<div id="all">
	<div id="div_encabezado">
		<a href="index.php">Reportes</a> | <a href="#" onclick="ajax('div_contenido','action=listar_cc');"> Centros de Costos</a></div>
	<div id="div_contenido"><div align="center"><img src="../img/dinero.jpg" /><br /><h4>Consumo por Centros de Costos <?=date("")?> de IQ Electronics.</h4></div></div>
		<div id="div_detalle">&nbsp;</div>
			
	<div id="grafica">
		<div id="grafica_titulo"><span id="spa_tdg1" style="float:left; font-weight:bold; font-size:13px;">T&iacute;tulo de la Gr&aacute;fica.</span><a href="javascript:ocultar('grafica');" style="border:#EFEFEF 1px solid; background-color:#FFFFFF; color: #FF0000; font-weight:bold; padding:1px; margin-top:1px; margin-right:1px; float:right; text-decoration:none;">X</a></div>
		<br />
		<div id="placeholder" style=" position:relative; width:780px; height:460px; left:50%; margin-left:-390px; "></div>
	</div>		
		
		
	<div id="div_pie">&copy; IQe Sisco - IQ Electronics International. </div>
	<script language="javascript">
	function graficar(id_cc)
	{
		//alert("graficar");
		$("#grafica").show();
		$("#spa_tdg1").html("&nbsp;&nbsp;Consumo del Centro de Costo "+id_cc+" en <?=date("Y")?>.");
			var m1=$("#hdn_01").attr("value");
			var m2=$("#hdn_02").attr("value");
			var m3=$("#hdn_03").attr("value");
			var m4=$("#hdn_04").attr("value");
			var m5=$("#hdn_05").attr("value");
			var m6=$("#hdn_06").attr("value");
			var m7=$("#hdn_07").attr("value");
			var m8=$("#hdn_08").attr("value");
			var m9=$("#hdn_09").attr("value");
			var m10=$("#hdn_10").attr("value");
			var m11=$("#hdn_11").attr("value");
			var m12=$("#hdn_12").attr("value");
			//alert(m1+","+m2+","+m3+","+m4+","+m5+","+m6+","+m7+","+m8+","+m9+","+m10+","+m11+","+m12);
		
		$(function () {
			var d1 =[[1, m1], [2, m2], [3, m3], [4, m4], [5, m5], [6, m6], [7, m7], [8, m8], [9, m9], [10, m10], [11, m11], [12, m12]]
			//alert(d1);
			$.plot($("#placeholder"), [
				{
					data: d1, label: "$ MN (00/100)",
					lines: { show: true, fill: true },
					points: { show: true }			
				}
			],{ 
				xaxis: {
					ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}
	function graficarX()
	{
		$("#grafica").show();
		$("#spa_tdg1").html('&nbsp;&nbsp;Existencias mensuales del Producto.');
		var b="B";
		var e="E";		
		$(function () {
			var d5 =[[1, 1], [2, 2], [3, 1], [4, 3], [5, 1], [6, 2], [7, 3], [8, 1], [9, 3], [10, 2], [11, 3], [12, 2]];
			//alert(d5);
				$.plot($("#placeholder"), [
					{
						data: d5, label: "Existencias",
						lines: { show: true,fill:true },
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
		$("#grafica").hide();
	}	
	graficarX();
	</script>
</div>
</body>
</html>