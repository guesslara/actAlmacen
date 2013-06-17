<?php 
	$idp=$_GET["idp"];
	//if ($idp=="") { echo "Error: No se recibio el id de un producto, necesario para que esta pagina funcione correctamente."; exit; }
	//$idp=2; 
  	$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$v1=array();	$v2=array();	$v3=array();	$v4=array();	$v5=array();	$v6=array();
	$v7=array();	$v8=array();	$v9=array();	$v10=array();	$v11=array();	$v12=array();	
	$id_conceptos=array();
	$letras=array('A','B','C','D','E','F','G','H','I','J');
	
	include("../conf/conectarbase.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
	#div1{ text-align:center;}
	.txt1 { border:#CCCCCC 1px solid; background-color:#FFFFFF; text-align:right;} 
</style>
    
    <link href="../js/flot/examples/layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.pack.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../js/flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script>

<script language="javascript">
	function graficar()
	{
		alert("Graficar");
		
		var le=new Array('A','B','C','D','E','F','G','H','I','J');
		var url="";
		for (var i0=0;i0<12;i0++)
		{			
			for (var i=0;i<le.length;i++)
			{
				var n=i0+1;
				var val=le[i]+n;
				var v=$("#"+val).attr("value");
				
				if (url=="")
				{ 
					url="&"+val+"="+v;
				} else {
					url+=','+"&"+val+"="+v;
				}	
				//alert(le[i]+n+"="+v);
			}
		}
		alert("URL="+url);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"comportamiento_producto2.php",
			data:"action=modificar_status&url="+url,
			beforeSend:function(){ 
				$("#div2").show().html('Cambiando status, espere un momento.'); 
			},
			success:function(datos){ $("#div2").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div2").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	
	function graficar2(l)
	{
		var url="";
		for (var i0=1;i0<=12;i0++)
		{
			var v=$("#"+l+i0).attr("value");
			
			if (url=="")
			{ 
				
				url="&"+l+i0+"="+v;
			} else {
				url+=','+"&"+l+i0+"="+v;
			}			
		}
		alert("URL="+url);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"comportamiento_producto2.php",
			data:"action=modificar_status&url="+url,
			beforeSend:function(){ 
				$("#div2").show().html('Cambiando status, espere un momento.'); 
			},
			success:function(datos){ $("#div2").show().html(datos); },
			timeout:90000000,
			error:function() { $("#div2").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
	}
	
	function graficar3()
	{	
	 	//alert("G 3");
		var claves1="";
		var url="";
		
		for (var i=0;i<document.frm1.elements.length;i++)
		{
			if (document.frm1.elements[i].type=="checkbox")
			{
				if (document.frm1.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves1=="")
					{
						var coo="";
						claves1=claves1+document.frm1.elements[i].value;
						/* -------------------------------- */
						var l=document.frm1.elements[i].value;
						//alert("Letra:"+l);
						for (var i0=1;i0<=12;i0++)
						{
							var v=$("#"+l+i0).attr("value");
							
							if (coo=="")
							{ 
								
								//url="&"+l+i0+"="+v;
								coo=v;
							} else {
								//url+=','+"&"+l+i0+"="+v;
								coo=coo+","+v+"";
							}
						}
						if (url=="") { url=l+'='+coo; } else { url=url+'?'+l+'='+coo;}															
						/* -------------------------------- */
					}	
					else
					{
						var coo="";
						claves1=claves1+"?"+document.frm1.elements[i].value;
						/* -------------------------------- */
						var l=document.frm1.elements[i].value;
						//alert("Letra:"+l);
						for (var i0=1;i0<=12;i0++)
						{
							var v=$("#"+l+i0).attr("value");
							
							if (coo=="")
							{ 
								coo=coo+v+"";
								//url="&"+l+i0+"="+v;
							} else {
								//url+=','+"&"+l+i0+"="+v;
								coo=coo+","+v;
							}			
						}
						if (url=="") { url=l+'='+coo; } else { url=url+'?'+l+'='+coo; }													
						/* -------------------------------- */						
					}	
				}	
			}
		}
		if (claves1==""||claves1=='undefined') return;
		//alert("Claves: "+claves1);	
		alert("URL: "+url);	
	}	
</script>
</head>

<body>
<?php include("../menu/menu.php");

if (!$_GET["idp"]) { 
	?>
	<br /><div align="center">
	<form name="frm1" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
	Introduzca el id del Producto <input type="text" name="idp" value="" /> &nbsp; <input type="submit" value="Ver Movimientos" />
	</form>
	</div>
	<?php
	exit;
} ?>
<br />
<div id="div1">
<form name="frm1" id="frm1" action="" method="post">
<table width="800" border="0" align="center" style="font-weight:normal; font-size:12px;">
  <tr>
    <td colspan="11" style="text-align:center;">COMPORTAMIENTO DEL PRODUCTO <?=$idp?> EN EL A&Ntilde;O <?=date("Y")?> </td>
  </tr>
  <tr style="text-align:center; font-weight:bold; font-size:11px;">
    <td>MES\CONCEPTO</td>
    <?php 
		$sql0="SELECT * FROM concepmov ORDER BY tipo,id_concep";
		$result0=mysql_db_query($sql_db,$sql0);	
		$no=0;
		while($row0=mysql_fetch_array($result0)){
			array_push($id_conceptos,$row0["id_concep"]);
			?>
			<td><input type="hidden" name="<?=$letras[$no]?>0" id="<?=$letras[$no]?>0" value="<?=$row0["id_concep"].".".$row0["concepto"]?>" readonly="1" size="5" class="txt1" /><?=$row0["id_concep"].".".$row0["concepto"]?></td>
			<?php
			++$no;
		}
	?>
  </tr>
  <?php 
  $cont=1; 
  foreach ($meses as $mes) { 
  ?>
  <tr>
    <td style="text-align:left;">&nbsp;<?=$mes?></td>
	<?php 
		$nombre_variable = "v$cont"; 
		$vX = $$nombre_variable;
		$cont2=0; 
		foreach ($id_conceptos as $id_concepto) { 
			$m=sprintf('%02s',$cont);
			//echo '<br><br>'.
			$sql1="SELECT sum(prodxmov.cantidad) as suma_total_mensual FROM mov_almacen,prodxmov WHERE mov_almacen.id_mov=prodxmov.nummov AND prodxmov.id_prod=$idp AND mov_almacen.tipo_mov=".$id_concepto." AND mov_almacen.fecha BETWEEN '".date("Y")."-".$m."-01' AND '".date("Y")."-".$m."-31'   ORDER BY mov_almacen.id_mov";
			$result1=mysql_db_query($sql_db,$sql1);	
			$ndrx=mysql_num_rows($result1);
			$suma=0;
			while ($registro1=mysql_fetch_array($result1))
			{
				$suma=$registro1["suma_total_mensual"];
				if ($suma=="") $suma=0; 
			}
			?>
    		<td><input type="text" name="<?=$letras[$cont2].$cont?>" id="<?=$letras[$cont2].$cont?>" value="<?=$suma?>" readonly="1" size="5" class="txt1" /></td>
			<?php 
		$cont2++;
		} ?>
  </tr>
  <?php  $cont++; } ?>
  <tr>
    <td>&nbsp;</td>
    <td><!--<input type="checkbox" name="chbA" id="chbA" value="A" />//--><a href="javascript:graficar9('A');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbB" id="chbB" value="B" />//--><a href="javascript:graficar9('B');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbC" id="chbC" value="C" />//--><a href="javascript:graficar9('C');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbD" id="chbD" value="D" />//--><a href="javascript:graficar9('D');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbE" id="chbE" value="E" />//--><a href="javascript:graficar9('E');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbF" id="chbF" value="F" />//--><a href="javascript:graficar9('F');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbG" id="chbG" value="G" />//--><a href="javascript:graficar9('G');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbH" id="chbH" value="H" />//--><a href="javascript:graficar9('H');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbI" id="chbI" value="I" />//--><a href="javascript:graficar9('I');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
    <td><!--<input type="checkbox" name="chbJ" id="chbJ" value="J" />//--><a href="javascript:graficar9('J');" style="text-decoration:none; font-size:10px;">Graficar</a></td>
  </tr>
  <tr>
    <td colspan="11" style="text-align:center; font-size:11px; ">Los n&uacute;meros reflejan la suma de las cantidades de los movimientos por mes. </td>
    </tr>
</table>
<br /><input type="button" value="Graficar Todo" onclick="graficar10('A','B','C','D','E','F','G','H','I','J')" />
</form>
</div>
<div id="div2">&nbsp;</div>
	<div id="placeholder" style=" position:relative; width:800px;height:400px; left:50%; margin-left:-400px; "></div>
<script language="javascript">
	function graficar9(l)
	{
		$(function () {
			var d1 =[[1, $("#"+l+1).attr("value")], [2, $("#"+l+2).attr("value")], [3, $("#"+l+3).attr("value")], [4, $("#"+l+4).attr("value")], [5, $("#"+l+5).attr("value")], [6, $("#"+l+6).attr("value")], [7, $("#"+l+7).attr("value")], [8, $("#"+l+8).attr("value")], [9, $("#"+l+9).attr("value")], [10, $("#"+l+10).attr("value")], [11, $("#"+l+11).attr("value")], [12, $("#"+l+12).attr("value")]];
				$.plot($("#placeholder"), [
					{
						data: d1, label: $("#"+l+0).attr("value"),
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

	function graficar10(a,b,c,d,e,f,g,h,i,j)
	{
		l="J";
		//alert('Graficar 10 \n'+l);
		
		$(function () {
			var d1 =[[1, $("#"+a+1).attr("value")], [2, $("#"+a+2).attr("value")], [3, $("#"+a+3).attr("value")], [4, $("#"+a+4).attr("value")], [5, $("#"+a+5).attr("value")], [6, $("#"+a+6).attr("value")], [7, $("#"+a+7).attr("value")], [8, $("#"+a+8).attr("value")], [9, $("#"+a+9).attr("value")], [10, $("#"+a+10).attr("value")], [11, $("#"+a+11).attr("value")], [12, $("#"+a+12).attr("value")]];
			var d2 =[[1, $("#"+b+1).attr("value")], [2, $("#"+b+2).attr("value")], [3, $("#"+b+3).attr("value")], [4, $("#"+b+4).attr("value")], [5, $("#"+b+5).attr("value")], [6, $("#"+b+6).attr("value")], [7, $("#"+b+7).attr("value")], [8, $("#"+b+8).attr("value")], [9, $("#"+b+9).attr("value")], [10, $("#"+b+10).attr("value")], [11, $("#"+b+11).attr("value")], [12, $("#"+b+12).attr("value")]];
			var d3 =[[1, $("#"+c+1).attr("value")], [2, $("#"+c+2).attr("value")], [3, $("#"+c+3).attr("value")], [4, $("#"+c+4).attr("value")], [5, $("#"+c+5).attr("value")], [6, $("#"+c+6).attr("value")], [7, $("#"+c+7).attr("value")], [8, $("#"+c+8).attr("value")], [9, $("#"+c+9).attr("value")], [10, $("#"+c+10).attr("value")], [11, $("#"+c+11).attr("value")], [12, $("#"+c+12).attr("value")]];
			var d4 =[[1, $("#"+d+1).attr("value")], [2, $("#"+d+2).attr("value")], [3, $("#"+d+3).attr("value")], [4, $("#"+d+4).attr("value")], [5, $("#"+d+5).attr("value")], [6, $("#"+d+6).attr("value")], [7, $("#"+d+7).attr("value")], [8, $("#"+d+8).attr("value")], [9, $("#"+d+9).attr("value")], [10, $("#"+d+10).attr("value")], [11, $("#"+d+11).attr("value")], [12, $("#"+d+12).attr("value")]];
			var d5 =[[1, $("#"+e+1).attr("value")], [2, $("#"+e+2).attr("value")], [3, $("#"+e+3).attr("value")], [4, $("#"+e+4).attr("value")], [5, $("#"+e+5).attr("value")], [6, $("#"+e+6).attr("value")], [7, $("#"+e+7).attr("value")], [8, $("#"+e+8).attr("value")], [9, $("#"+e+9).attr("value")], [10, $("#"+e+10).attr("value")], [11, $("#"+e+11).attr("value")], [12, $("#"+e+12).attr("value")]];
			var d6 =[[1, $("#"+f+1).attr("value")], [2, $("#"+f+2).attr("value")], [3, $("#"+f+3).attr("value")], [4, $("#"+f+4).attr("value")], [5, $("#"+f+5).attr("value")], [6, $("#"+f+6).attr("value")], [7, $("#"+f+7).attr("value")], [8, $("#"+f+8).attr("value")], [9, $("#"+f+9).attr("value")], [10, $("#"+f+10).attr("value")], [11, $("#"+f+11).attr("value")], [12, $("#"+f+12).attr("value")]];
			var d7 =[[1, $("#"+g+1).attr("value")], [2, $("#"+g+2).attr("value")], [3, $("#"+g+3).attr("value")], [4, $("#"+g+4).attr("value")], [5, $("#"+g+5).attr("value")], [6, $("#"+g+6).attr("value")], [7, $("#"+g+7).attr("value")], [8, $("#"+g+8).attr("value")], [9, $("#"+g+9).attr("value")], [10, $("#"+g+10).attr("value")], [11, $("#"+g+11).attr("value")], [12, $("#"+g+12).attr("value")]];
			var d8 =[[1, $("#"+h+1).attr("value")], [2, $("#"+h+2).attr("value")], [3, $("#"+h+3).attr("value")], [4, $("#"+h+4).attr("value")], [5, $("#"+h+5).attr("value")], [6, $("#"+h+6).attr("value")], [7, $("#"+h+7).attr("value")], [8, $("#"+h+8).attr("value")], [9, $("#"+h+9).attr("value")], [10, $("#"+h+10).attr("value")], [11, $("#"+h+11).attr("value")], [12, $("#"+h+12).attr("value")]];
			var d9 =[[1, $("#"+i+1).attr("value")], [2, $("#"+i+2).attr("value")], [3, $("#"+i+3).attr("value")], [4, $("#"+i+4).attr("value")], [5, $("#"+i+5).attr("value")], [6, $("#"+i+6).attr("value")], [7, $("#"+i+7).attr("value")], [8, $("#"+i+8).attr("value")], [9, $("#"+i+9).attr("value")], [10, $("#"+i+10).attr("value")], [11, $("#"+i+11).attr("value")], [12, $("#"+i+12).attr("value")]];
			var d0 =[[1, $("#"+j+1).attr("value")], [2, $("#"+j+2).attr("value")], [3, $("#"+j+3).attr("value")], [4, $("#"+j+4).attr("value")], [5, $("#"+j+5).attr("value")], [6, $("#"+j+6).attr("value")], [7, $("#"+j+7).attr("value")], [8, $("#"+j+8).attr("value")], [9, $("#"+j+9).attr("value")], [10, $("#"+j+10).attr("value")], [11, $("#"+j+11).attr("value")], [12, $("#"+j+12).attr("value")]];
				$.plot($("#placeholder"), [
					{
						data: d1, label: $("#"+a+0).attr("value"),
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d2, label: $("#"+b+0).attr("value"),
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d3, label: $("#"+c+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d4, label: $("#"+d+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d5, label: $("#"+e+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d6, label: $("#"+f+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d7, label: $("#"+g+0).attr("value"),
						lines: { show: true},
						points: { show: true }
					},
					{
						data: d8, label: $("#"+h+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					},
					{
						data: d9, label: $("#"+i+0).attr("value"),
						lines: { show: true},
						points: { show: true }
					},
					{
						data: d0, label: $("#"+j+0).attr("value"),
						lines: { show: true },
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}		
	//graficar10('A','B','C','D','E','F','G','H','I','J');	





	function graficarA()
	{
		//alert("Graficar A");
		var a="A";
		$(function () {
			var d1 =[[1, $("#"+a+1).attr("value")], [2, $("#"+a+2).attr("value")], [3, $("#"+a+3).attr("value")], [4, $("#"+a+4).attr("value")], [5, $("#"+a+5).attr("value")], [6, $("#"+a+6).attr("value")], [7, $("#"+a+7).attr("value")], [8, $("#"+a+8).attr("value")], [9, $("#"+a+9).attr("value")], [10, $("#"+a+10).attr("value")], [11, $("#"+a+11).attr("value")], [12, $("#"+a+12).attr("value")]];
				$.plot($("#placeholder"), [
					{
						data: d1, label: $("#A"+0).attr("value"),
						lines: { show: true, },
						points: { show: true }
					}
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}		
	//graficarA();	

	function graficarAJ()
	{
		//alert("Graficar AJ");
		var a="A";		var j="J";
		$(function () {
			var d1 =[[1, $("#"+a+1).attr("value")], [2, $("#"+a+2).attr("value")], [3, $("#"+a+3).attr("value")], [4, $("#"+a+4).attr("value")], [5, $("#"+a+5).attr("value")], [6, $("#"+a+6).attr("value")], [7, $("#"+a+7).attr("value")], [8, $("#"+a+8).attr("value")], [9, $("#"+a+9).attr("value")], [10, $("#"+a+10).attr("value")], [11, $("#"+a+11).attr("value")], [12, $("#"+a+12).attr("value")]];
			var d2 =[[1, $("#"+j+1).attr("value")], [2, $("#"+j+2).attr("value")], [3, $("#"+j+3).attr("value")], [4, $("#"+j+4).attr("value")], [5, $("#"+j+5).attr("value")], [6, $("#"+j+6).attr("value")], [7, $("#"+j+7).attr("value")], [8, $("#"+j+8).attr("value")], [9, $("#"+j+9).attr("value")], [10, $("#"+j+10).attr("value")], [11, $("#"+j+11).attr("value")], [12, $("#"+j+12).attr("value")]];			
				$.plot($("#placeholder"), [
					{
						data: d1, label: $("#A"+0).attr("value"),
						lines: { show: true, },
						points: { show: true }
					},
					{
						data: d2, label: $("#J"+0).attr("value"),
						lines: { show: true, },
						points: { show: true }
					}					
				],{ 
				xaxis: {
				ticks: [0, [1, "ENE"], [2, "FEB"], [3, "MAR"], [4, "ABR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AGO"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DIC"]]
				}
			});
		});
	}		
	graficar9('A');	

//if ($.browser.mozilla) { alert('Estas usando el navegador: FireFox'); } 
if ($.browser.msie && $.browser.version >= 8) { alert('Estas usando el navegador: Internet Explorer. Le recomendamos utilice otro Navegador como: \n Firefox o Google Chrome para navegar sin contratiempos a traves de este sitio. \n(Puede descargarlos directamente de Internet o ponerse en contacto con el departamento de Sistemas IQ.)'); } 
</script>
<?php include("../f.php"); ?>
</body>
</html>
