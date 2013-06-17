<?php
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,3,10);
	
function dame_valor_almacen($id_almacen){
	require("../conf/conectarbase.php");
	$total_existencias=0;
	
	//echo "<br>".
	$sql="SELECT 
	sum(prodxmov.existen*prodxmov.cu) AS total_existencias
	from concepmov,mov_almacen,prodxmov,catprod 
	where 
		mov_almacen.id_mov=prodxmov.nummov 
		AND catprod.id=prodxmov.id_prod
		AND prodxmov.id_prod=catprod.id
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND concepmov.tipo='Ent' 
			AND mov_almacen.almacen=$id_almacen
		AND catprod.exist_$id_almacen>0		
		AND prodxmov.existen>0 
	order by prodxmov.id";
	if($res=mysql_db_query($sql_db,$sql,$link)){
		//echo "<br> Resultados=".mysql_num_rows($res);
		while($reg=mysql_fetch_array($res)){
			//echo "<br>";	print_r($reg);
			$total_existencias=$reg["total_existencias"];
		}	
	}else{
		echo mysql_error($link);
	}
	return $total_existencias;		
}
//$valor_almacen1=dame_valor_almacen(1);
//$valor_almacen44=dame_valor_almacen(44);
$valor_almacen77=dame_valor_almacen(77);
//$valor_total_inventario=$valor_almacen1+$valor_almacen44;	//+$valor_almacen48;

//$porc_almacen1=$valor_almacen1/$valor_total_inventario*100;
//$porc_almacen44=$valor_almacen44/$valor_total_inventario*100;
$porc_almacen77=$valor_almacen77/$valor_total_inventario*100;
//$porc_almacen_total=$valor_total_inventario/$valor_total_inventario*100;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Valor del Inventario IQ - Existencias Resumen</title>
<style type="text/css">
body,document,html{ position:absolute; width:100%; height:100%; margin:0px; }
#div0{ position:absolute; width:100%; height:100%; background-image:url(../img/transparente.png);}
	#div01{ position:absolute; width:600px; height:500px; background-color:#FFF; border:#666 2px solid; left:50%; top:50%; margin-left:-300px; margin-top:-250px; }
		#div011{ text-align:center; font-size:24px; margin:5px 5px 5px 5px;}
			#tbl_1 { border:#efefef 1px solid; margin-top:5px; width:95%; }
				#tbl_1 td { border-right:#efefef 1px solid; border-bottom:#efefef 1px solid; }
			.campos{ text-align:center; font-weight:bolder; background-color:#efefef; }
			.concepto { text-align:left; padding:5px; }
			.monto{ text-align:right; padding:5px; }
			.porcentaje{ text-align:right; padding:5px; }
			.totales{ font-weight:bold; font-size:24px; text-align:center; }
			.detalle{ text-align:center; font-size:small; }
			.total_etiqueta{ text-align:center;}
			
			#div_grafica{ text-align:center; border:#CCCCCC1px solid; padding:2px;}
			img{ border:#CCCCCC1px solid; }
</style>
</head>

<body>
<div id="div0">
  <div id="div01">
    	<div id="div011">Valor del Inventario IQ Electronics.</div>
      <div id="div012">
       	  <p>&nbsp;</p>
		  <table align="center" border="0" id="tbl_1" cellspacing="0" cellpadding="0">
            <tr class="campos">
            	<td>almac&eacute;n</td>
                <td>$</td>
                <td>detalle</td>
            </tr>
             <!-- <tr>
            	<td class="concepto">1. General</td>
                <td class="monto"><?=number_format($valor_almacen1,2,'.',',')?>&nbsp;</td>
                <td class="porcentaje"><?=round($porc_almacen1,2)?>&nbsp;</td>
                <td class="detalle"><a href="existencias.php">ver</a> | <a href="existencias_detalle.php" title="Ver Costo Unitario.">CU ($)</a> <a href="xls_costos_unitarios.php" title="Exportar Costo Unitario a Excel."><img alt="XLS" src="../img/excel.png" border="0" /></a></td>
            </tr>
            <tr>
            	<td class="concepto">44. Material No Conforme</td>
                <td class="monto"><?=number_format($valor_almacen44,2,'.',',')?>&nbsp;</td>
                <td class="porcentaje"><?=round($porc_almacen44,2)?>&nbsp;</td>
                <td class="detalle"><a href="existencias_alm_44.php">ver</a></td>
            </tr>
            //--> 
			<tr>
            	<td class="concepto">77. Producto Terminado Cosm&eacute;tica</td>
                <td class="monto"><?=number_format($valor_almacen48,2,'.',',')?>&nbsp;</td>
                <td class="detalle"><a href="existencias_alm_48.php">ver</a></td>
            </tr>
          </table>
          <!--
		  <div id="div_grafica"><img src="valor_grafica.php" /></div>
          <div class="total_etiqueta">Total : $ <span class="totales"><? //number_format($valor_total_inventario,2,'.',',')?></span></div>
          //-->
		  <p>&nbsp;</p>
		  <div class="detalle">
		  	<br /><a href="index.php">Volver a reportes</a>
		  </div>
      </div>
  </div>

</div>
</body>
</html>