<?php
session_start();
$year=date("Y");
$m_meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre",);
include("../conf/conectarbase.php");
mysql_select_db($sql_db);
	function dame_registro($sql){
		include("../conf/conectarbase.php");
		mysql_select_db($sql_db);
		if ($res=mysql_query($sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				while($reg=mysql_fetch_array($res)){ return $reg[0]; }
			}else{ return " "; }
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}
if(!empty($_POST)){
	//echo "<br>";	print_r($_POST);
	if($_POST["action"]=="calcular_consumo_mensual"){
		$total_consumo=0;
		
		($_POST["id_cc"]=="__")?$sql_cdc="":$sql_cdc="AND mov_almacen.asociado='".$_POST["id_cc"]."'";
		//echo "<br>".
		$sql_1="SELECT 
			DISTINCT (cat_cuentas.cuenta), cat_cuentas.descripcion, SUM(prodxmov.cantidad*prodxmov.cu) AS subtotal 
		FROM mov_almacen, prodxmov, cat_cuentas, rel_cc_vs_productos 
		WHERE 
			mov_almacen.id_mov=prodxmov.nummov
			
			AND rel_cc_vs_productos.id_producto=prodxmov.id_prod
			AND cat_cuentas.id_cuenta=rel_cc_vs_productos.id_cc
			
			AND mov_almacen.almacen IN (1,48,77)
			AND  (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
			$sql_cdc
			
			AND mov_almacen.fecha BETWEEN '$year-".$_POST["mes_indice"]."-01' AND '$year-".$_POST["mes_indice"]."-31'	
			
		GROUP BY  cat_cuentas.cuenta	
		ORDER BY cat_cuentas.a ASC, cat_cuentas.b ASC, cat_cuentas.c ASC, cat_cuentas.d ASC
		";	
		if ($res_1=mysql_query($sql_1,$link)){
			//echo "<br>NDR=".
			$ndr1=mysql_num_rows($res_1);
			if ($ndr1>0){
				$color="#FFFFFF";
			}else{ die("<h4 align='center'>Sin resultados </h4>"); }
		}else{ die("<h4 align='center'>Error SQL : <br>".mysql_error($link))."</h4>"; }	
		
		// EMPIEZA EL GRAFICO ...
		$datos_grafica_swf="";
			$datos_grafica_swf.="<chart palette='2' showBorder='0' formatNumberScale='0'  numberPrefix='$' >";			
		?>
		<h3 align="center">Desglose de Consumo <?=$m_meses[$_POST["mes_indice"]]?> <?=$year?></h3>
		<h4 align="center" onClick="ajax('div_cc_C','ac=listar_consumo_resumen_CC_del_CdC&id_centro_costo=<?=$id_centro_costo?>')" style="color:#0000FF; cursor:pointer; ">
			<?=$_POST["id_cc"]?> &rarr;  
			&quot; <?=dame_registro("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$_POST["id_cc"]."' LIMIT 1; ")?> &quot; 
		</h4>
		<div id="div_graficaX" align="center">&nbsp;</div> 
		<table align="center" cellspacing="0" cellpadding="3" width="600" class="tabla1">
		<tr>
			<th>cuenta &darr;</th>
			<th>descripci&oacute;n</th>
			<th>$ subtotal</th>
		</tr>
		<?php 
		while ($reg_1=mysql_fetch_array($res_1)){ 
			$total_consumo+=$reg_1["subtotal"];	
			$datos_grafica_swf.="<set label='".$reg_1["descripcion"]."' value='".round($reg_1["subtotal"],2)."'  />";
			?>
			<tr class="tr_hover">
				<td align="center"><?=$reg_1["cuenta"]?></td>
				<td><?=$reg_1["descripcion"]?></td>
				<td align="right"><?=number_format($reg_1["subtotal"],2,".",",")?></td>	
			</tr>
		<?php } ?>
		<tr>
			<th align="right" colspan="2">Total $ &rarr;</th>
			<th align="right"><?=number_format($total_consumo,2,".",",")?></th>
		</tr>
		</table><br />
		<div align="center">
			<!--
			<a href="vistas_impresion/consumo_x_cc_cc1.php?id_cc=<?=$id_centro_costo?>" target="_blank">vista de impresi&oacute;n</a> | 
			<a href="xls/consumo_anual_x_centro_costo.php?id_cc=<?=$id_centro_costo?>">exportar a M. Excel</a> | 
			//-->
			<a href="#" onClick="$('#div_grafico').show()">ver grafica &darr; </a> | 
			<a href="#" onClick="ajax('div_resultados_detalle','action=listar_consumo_detalle_CC_del_CdC&mes_indice=<?=$_POST["mes_indice"]?>&id_cc=<?=$_POST["id_cc"]?>')">ver detalle &darr; </a>
		</div>
		<?php
		$datos_grafica_swf.="</chart>";
		?>
		<script type="text/javascript">
			  var myChart = new FusionCharts("swf/Pie3D.swf", "myChartId", "800", "400", "0", "0");
			  myChart.setDataXML("<?=$datos_grafica_swf?>");		   
			  myChart.render("div_grafico");
		</script>		
		<div id="div_detalle_x_productoX">&nbsp;</div> 
		<?php			
	}
	if($_POST["action"]=="listar_consumo_detalle_CC_del_CdC"){	?>
		<h3 align="center">Desglose de Consumo <?=$m_meses[$_POST["mes_indice"]]?> <?=$year?></h3>
		<h4 align="center" onClick="ajax('div_cc_C','ac=listar_consumo_detalle_CC_del_CdC&id_centro_costo=<?=$id_centro_costo?>')" style="color:#0000FF; cursor:pointer; ">
			<?=$_POST["id_cc"]?> &rarr;  
			<?=$cdc_descripcion=dame_registro("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$_POST["id_cc"]."' LIMIT 1; ")?>
		</h4>
		<table cellspacing="0" align="center" cellpadding="3" class="tabla1">
		<tr>
			<!--<th>id_mov</th>//-->
			<th>almac&eacute;n</th>
			<th>fecha &darr;</th>
			<!--<th>asociado</th>//-->
			<th>cuenta_contable</th>
			<!--<th>concepto</th>//-->
			<th>id</th>
			<th>descripci&oacute;n</th>
			<th>especificacion</th>
			<th><a href="#" title="Este campo evalua si el producto ya esta asociado a una Cuenta Contable">esta en CC</a> </th>
			<th>cantidad</th>
			<th>c.u($).</th>
			<th>subtotal($)</th>
		</tr>
		<?php
			echo "<br>".$sql_1="SELECT 
				mov_almacen.*,
				prodxmov.*,
					prodxmov.cantidad*prodxmov.cu AS subtotal,
				catprod.descripgral,
				catprod.especificacion,
				tipoalmacen.almacen AS almacen_nombre 
			FROM mov_almacen, prodxmov, catprod, tipoalmacen 
			WHERE 
				mov_almacen.asociado=tipoalmacen.id_almacen
				AND mov_almacen.id_mov=prodxmov.nummov
				AND catprod.id=prodxmov.id_prod

				AND mov_almacen.almacen IN (1,48,77)
				AND (mov_almacen.tipo_mov='9' OR mov_almacen.tipo_mov='17' )
				AND mov_almacen.asociado='".$_POST["id_cc"]."'
				
				AND mov_almacen.fecha BETWEEN '$year-".$_POST["mes_indice"]."-01' AND '$year-".$_POST["mes_indice"]."-31'		

			ORDER BY mov_almacen.fecha,mov_almacen.id_mov,mov_almacen.fecha,prodxmov.id";				
			if ($res_1=mysql_db_query($sql_db,$sql_1,$link)){
				//echo "<br>NDR=".
				$ndr1=mysql_num_rows($res_1);
				if ($ndr1>0){
					$color="#FFFFFF";
					while ($reg_1=mysql_fetch_array($res_1)){
						//echo "<br><br>";	print_r($reg_1);
						$suma_subtotal+=$reg_1["subtotal"];
						?>
						<tr class="tr_hover">
							<!--<td align="center"><?=$reg_1["id_mov"]?></td>//-->
							<td align="center"><?=$reg_1["almacen"]?></td>
							<td align="center"><?=$reg_1["fecha"]?></td>
							<!--<td align="center"><?=$reg_1["asociado"]?></td>//-->
							<td align="center">&nbsp;<?php
								
								// cat_cuentas.descripcion cat_cuentas.cuenta
								$sql_cc="SELECT 
									CONCAT(cat_cuentas.cuenta,' ',cat_cuentas.descripcion)
								FROM 
									rel_cc_vs_productos, cat_cuentas 
								WHERE 
									rel_cc_vs_productos.id_cc=cat_cuentas.id_cuenta
									AND rel_cc_vs_productos.id_producto='".$reg_1["id_prod"]."'
								LIMIT 1;";
								$cuenta_contableX=dame_registro($sql_cc);
								//echo substr(,0,16);
								
							?><a href="#" title="<?=$cuenta_contableX?>"><?=substr($cuenta_contableX,0,16)?></a></td>
							<!--<td align="center"><?=$reg_1["tipo_mov"]?></td>//-->
							<td align="center"><?=$reg_1["id_prod"]?></td>
							<td><?=$reg_1["descripgral"]?></td>
							<td><a href="#" title="<?=$reg_1["especificacion"]?>"><?=substr($reg_1["especificacion"],0,15)?></a></td>
							<td align="center" style=" background-color:#efefef;">&nbsp;<?php
								//echo $this->dame_no_resultados("SELECT count(id_producto) FROM rel_cc_vs_productos WHERE id_producto='".$reg_1["id_prod"]."' LIMIT 1;");
								if(dame_registro("SELECT count(id_producto) FROM rel_cc_vs_productos WHERE id_producto='".$reg_1["id_prod"]."' LIMIT 1;"))
									echo "SI";
								else echo "NO";
							
							?></td>
							<td class="campo_d" align="right"><?=$reg_1["cantidad"]?></td>
							<td align="right"><?=number_format($reg_1["cu"],2,".",",");?></td>
							<td class="campo_Z" align="right"><?=number_format($reg_1["subtotal"],2,".",",");?></td>
						</tr>					
						<?php
					}
				} else {
					//echo "<br>NO se encontraron resultados en $mes del ".date("Y").".";
				}
			}else{ echo mysql_error($link); }
		//}
		?>
		<tr style="text-align:right; font-weight:bold;">
		  <td colspan="9">Total &rarr; </td>
		  <td>$<?=number_format($suma_subtotal,2,".",",");?></td>
		</tr>	
		</table>
		<div style="font-size:small; text-align:center; color:#0000FF; margin:5px;">La tabla presenta los movimientos de Salida por Traspaso (Concepto 9) y Salida por Asignacion (Concepto 17) de los almacenes : 1,48,77  al Centro de Costo ( <?=$cdc_descripcion?> ), realizados en el <?=$year?>.</div>
		<?php
	}
	exit;
}
// ------------------------------------------------------------------------------------
$sql="SELECT id_almacen,almacen FROM tipoalmacen WHERE activo=1 AND es_centro_costo=1 ORDER BY id_almacen ASC; ";
if($res=mysql_query($sql,$link)){
	$ndr=mysql_num_rows($res);
	if($ndr>0){ }else{ echo "<h4 align='center'>sin resultados </h4>"; }
} else{ die("<h4 align='center'>Error SQL (".mysql_error($link)."). </h4>"); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consumo mensual por Centro de Costo en <?=$year?>.</title>
<style type="text/css">
body,html,document{ position:absolute; width:100%; height:100%; margin:0px; padding:0px; background-color:#fff; color:#000; font-family:Arial, Helvetica, sans-serif; font-size:small; }
.tabla1 { border-left:#ccc 1px solid; border-top:#ccc 1px solid; }
.tabla1 th { font-size:small; border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; /*background-color:#efefef;*/ }		
.tabla1 td{ font-size:small; border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; }
.tr_hover:hover{ background-color:#efefcc; }

a{ text-decoration:none; color:#0033FF; }
h2{ /*color:#FFCC00;*/ }
</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="JavaScript" src="js/FusionCharts.js"></script>
<script language="javascript">
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
function calcular_consumo_mensual_x_cc(){
	var mes_indice=$("#sel_mes").val();
	var id_cc=$("#sel_cdc").val();
	var datos="action=calcular_consumo_mensual&mes_indice="+mes_indice+"&id_cc="+id_cc;
	$("#div_grafico").hide();
	$("#div_resultados_detalle").hide();
	ajax("div_resultados",datos,"div_frm1");
}		
</script>
</head>
<body>
<div>
	<h2 align="center">Consumo mensual por Centro de Costo en <?=$year?>.</h2>
	<div id="div_frm1">
	<table align="center" border="0" cellpadding="3">
	<tr>
		<th>mes</th>
		<th>centro costo</th>
	</tr>
	<tr>
		<td>
		<select id="sel_mes">
			<option value="">...</option>
			<?php foreach($m_meses as $indice_mes=>$mes){ ?>
				<option value="<?=$indice_mes?>"><?=$indice_mes." ".$mes?></option>	
			<?php } ?>
		</select>				
		</td>
		<td>
		<select id="sel_cdc">
			<option value="__">Todos</option>
			<?php while($reg=mysql_fetch_array($res)){ ?>
				<option value="<?=$reg["id_almacen"]?>"><?=$reg["id_almacen"].". ".$reg["almacen"]?></option>	
			<?php } ?>
		</select>				
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="button" value="Calcular" onClick="calcular_consumo_mensual_x_cc()" /></td>
	</tr>
	</table><br />
	</div>
	<div id="div_resultados"></div>
	<div id="div_grafico" align="center"></div>
	<div id="div_resultados_detalle"></div>
	<br />
</div>
</body>
</html>
