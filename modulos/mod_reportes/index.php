<?php
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,4,10);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reportes del Sistema de Inventarios IQ.</title>
    <script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
	<script language="javascript">
		function descripcion(t)
		{
			$("#div_des").html(t);
		}
	</script>
<style type="text/css">
	/*body,document { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; background-color:#FFFFFF; }*/
	#all{ position:relative; width:800px; height:600px; left:50%; /*top:50%;*/ margin-left:-400px; margin-top:40px; border:#000000 1px solid; background-color:#FFFFFF; padding:0px; }
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#FF0000;}
	a:visited{ text-decoration:none;}
	
	
	#div1{ /*position:relative;*/ width:800px; height:600px; border:#000000 1px solid; background-color:#FFFFFF; padding:0px; }
	#div_tit1{ height:20px; text-align:center; font-weight:bold; background-color:#333333; color:#FFFFFF; padding-top:2px;}
	#div_adm{ position:relative; float:left; clear:left; width:250px; height:495px; margin:5px; border:#CCCCCC 1px solid; text-align:center; }
	#div_ope{ position:relative; float:left; clear:right; width:526px; height:495px; margin:5px; border:#CCCCCC 1px solid; text-align:justify; }
	#div_des{ position:relative; clear:both; height:60px; margin:5px; border:#CCCCCC 1px solid; text-align:justify; padding:2px; }
	#img1{ margin-top:150px; }
	.ulli li { margin:5px; text-align:left; font-size:12px; font-weight:normal;}
</style>
</head>

<body>
	<?php include("../menu/menu.php"); ?>
	<div id="all">
		<div id="div1">
			<div id="div_tit1">Reportes del Sistema de Inventarios IQ.</div>
			<div id="div_con1">
				<div id="div_adm"><img src="../img/document.png" id="img1"/></div>
				<div id="div_ope">
					<br />
					<ul class="ulli">
					<li class="ulli">Productos
						<ol>
							<li>Existencias.
								<ul>
									<!--<li class="ulli"><a href="existencias_generales_resumen.php" onmouseover="javascript:descripcion('Reporte que muestra las existencias en <b>resumen</b> de los Almacenes: 1.General, 43.Transito y 44.Material No Conforme. Adem&aacute;s muestra el monto ($) estimado del valor de los productos.');" onmouseout="javascript:descripcion('');">Resumen</a></li>//-->
<li class="ulli"><a href="valor_inventario2.php" onmouseover="javascript:descripcion('Reporte que muestra el valor de los productos del Inventario IQ.');" onmouseout="javascript:descripcion('');">Valor del Inventario Resumen</a></li>
<li class="ulli"><a href="valor_inventario_48.php" onmouseover="javascript:descripcion('Reporte que muestra el Valor del Inventario Producto Terminado Cosmetica (48).');" onmouseout="javascript:descripcion('');">Valor del Inventario Producto Terminado Cosmetica (48)</a></li>
									<!--
                                    <li class="ulli"><a href="existencias.php" onmouseover="javascript:descripcion('Reporte que muestra el valor de los productos en el Almacén: 1.General a detalle (desglose de productos).');" onmouseout="javascript:descripcion('');">Valor del Inventario Detalle</a></li>
									//-->
									<li><a href="valor_x_status.php?valor=0" onmouseover="javascript:descripcion('Reporte que muestra el valor del Almac&eacute;n 1. General, clasificado por estado : <b>Uso Constante</b>,<b>Lento Movimiento</b> y <b>Obsoleto</b>.');" onmouseout="javascript:descripcion('');">Valor del Inventario por Estado</a>
									</li>
									
									<li class="ulli"><a href="existencias_generales_totales_excel.php" onmouseover="javascript:descripcion('Reporte que exporta a Microsoft Excel las existencias a <b>detalle</b> de los Almacenes: 1.General y 44.Material No Conforme.');" onmouseout="javascript:descripcion('');">Generales en Excel</a></li>
									<li class="ulli"><a href="existencias_nextel.php" onmouseover="javascript:descripcion('Reporte que muestra las existencias a detalle de los Productos <b>Nextel</b> en los Almacenes: 1.General y 44.Material No Conforme. Adem&aacute;s muestra el monto ($) estimado del valor de los productos.');" onmouseout="javascript:descripcion('');">Nextel</a></li>
									<li class="ulli"><a href="existencias_nextel_excel.php" onmouseover="javascript:descripcion('Reporte que exporta a Microsoft Excel las existencias a detalle de los Productos <b>Nextel</b> en los Almacenes: 1.General y 44.Material No Conforme.');" onmouseout="javascript:descripcion('');">Nextel (Excel)</a></li>																		
									<li class="ulli"><a href="existencias_no_nextel.php" onmouseover="javascript:descripcion('Reporte que muestra las existencias a detalle de los Productos <b>NO Nextel</b> en los Almacenes: 1.General y 44.Material No Conforme. Adem&aacute;s muestra el monto ($) estimado del valor de los productos.');" onmouseout="javascript:descripcion('');">No Nextel</a></li>
									<li class="ulli"><a href="existencias_no_nextel_excel.php" onmouseover="javascript:descripcion('Reporte que exporta a Microsoft Excel las existencias a detalle de los Productos <b>NO Nextel</b> en los Almacenes: 1.General y 44.Material No Conforme.');" onmouseout="javascript:descripcion('');">No Nextel (Excel)</a></li>
									<li class="ulli"><a href="valor_inventarioX.php" onmouseover="javascript:descripcion('Reporte que muestra el valor del inventario por linea y por estado');" onmouseout="javascript:descripcion('');">Por l&iacute;nea</a></li>
									<!--//-->
									<li class="ulli"><a href="rep_existencias_mensuales_x_status.php" onmouseover="javascript:descripcion('Reporte que muestra el valor del inventario por mes durante el actual periodo');" onmouseout="javascript:descripcion('');">Por Mes</a></li>	
																																			
								</ul>
							</li>
							<li><a href="reporte_e_s.php" onmouseover="javascript:descripcion('Reporte que permite realizar un consulta de los <b>movimientos realizados en un rango de fechas determinado</b> por el usuario. Los resultados pueden mostrarse en el sistema o exportarse a Microsoft Excel para su edici&oacute;n personalizada.');" onmouseout="javascript:descripcion('');">Movimientos.</a> </li>
							<li><a href="existencias_por_mes.php" onmouseover="javascript:descripcion('Reporte que muestra las existencias, as&iacute; como la <b>suma</b> de los movimientos (Entrada y Salida) por mes de un producto determinado. Los n&uacute;meros reflejan cantidades (no montos $).');" onmouseout="javascript:descripcion('');">Comportamiento de Existencias.</a></li>
							<li><a href="comportamiento_producto.php" onmouseover="javascript:descripcion('Reporte que muestra los <b>movimientos</b> (Entrada y Salida) por mes de un producto determinado. Los n&uacute;meros reflejan cantidades (no montos $).');" onmouseout="javascript:descripcion('');">Comportamiento de Entradas y Salidas.</a></li>
							<!--li><a href="existencias_por_mes.php">Comportamiento de Existencias (Monto $).</a></li>//-->
						</ol>
					</li>
					<li>Proveedores
						<ol>
							<!--<li><a href="proveedores_y_productos.php" onmouseover="javascript:descripcion('Reporte que muestra a los Proveedores y productos  que c/u suministra a la Empresa. Adem&aacute;s, permite visualizar si ya se le han realizado compras a dicho proveedor, los tiempos de entrega y un tiempo de entrega promedio en d&iacute;as.');" onmouseout="javascript:descripcion('');">Asociaci&oacute;n de Proveedores y Productos.</a></li>//-->
							<li><a href="#" onmouseover="javascript:descripcion('Reporte que muestra a los Proveedores y productos  que c/u suministra a la Empresa. Adem&aacute;s, permite visualizar si ya se le han realizado compras a dicho proveedor, los tiempos de entrega y un tiempo de entrega promedio en d&iacute;as.');" onmouseout="javascript:descripcion('');">Asociaci&oacute;n de Proveedores y Productos.</a></li>							
						</ol>					
					</li>
					<li>Centros de Costo.
						<ol>
							<li><a href="planeacion_financiera1.php" onmouseover="javascript:descripcion('Reporte que muestra el consumo por Centro de Costo a lo largo del año en curso (<?=date("Y")?>).');" onmouseout="javascript:descripcion('');">Consumo por Centro de Costo.</a></li>
						</ol>					
					</li>					
					</ul>	
				</div>
				<div id="div_des"></div>
			</div>
			
		</div>
		
	</div>
	<?php include("../f.php"); ?>
</body>
</html>
