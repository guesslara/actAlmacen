<?php
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,3,10);

$m_valores=array("Uso Constante","Lento Movimiento","Obsoleto");
$valor_recibido=$_GET["valor"];

function dame_valor_almacen($id_almacen,$status){
	require("../conf/conectarbase.php");
	$total_existencias=0;
	
	//echo "<br>".
	$sql="SELECT 
	sum(prodxmov.existen*prodxmov.cu) AS total_existencias
	from concepmov,mov_almacen,prodxmov,catprod 
	where 
		mov_almacen.id_mov=prodxmov.nummov 
		AND catprod.id=prodxmov.id_prod
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND concepmov.tipo='Ent' 
			AND mov_almacen.almacen=$id_almacen
		AND catprod.exist_$id_almacen>0
		AND catprod.status1=$status
				
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
$valor_almacen_x_status_0=dame_valor_almacen(1,0);
$valor_almacen_x_status_1=dame_valor_almacen(1,1);
$valor_almacen_x_status_2=dame_valor_almacen(1,2);

$suma_valor=$valor_almacen_x_status_0+$valor_almacen_x_status_1+$valor_almacen_x_status_2;

// Porcentajes ...
if($suma_valor>0){
	$p0=round($valor_almacen_x_status_0/$suma_valor*100,2);
	$p1=round($valor_almacen_x_status_1/$suma_valor*100,2);
	$p2=round($valor_almacen_x_status_2/$suma_valor*100,2);
}else{

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>valor_x_status.php</title>
<style type="text/css">
body{ margin:0px; padding:0px;}
.tablaX{ position:relative; width:500px; border-left:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid; }
.tablaX th{ text-align:center; font-weight:bold; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; background-color:#efefef; }
.tablaX td{ text-align:rigth; font-weight:normal; border-right:#CCCCCC 1px solid; border-bottom:#CCCCCC 1px solid; }
</style>
</head>

<body>
	<?php include("../menu/menu.php"); ?>
<h3 align="center">Valor del Inventario por Estado</h3>
<h4 align="center">Almac&eacute;n 1. General</h4>
<p>
<table align="center" cellpadding="3" cellspacing="0" class="tablaX">
  <tr>
	  <th width="238">Estado</th>
	  <th width="110">$ valor</th>
	  <th width="56">%</th>
	  <th width="56">detalle</th>
  </tr>
  <tr>
    <td>Uso Constante </td>
    <td align="right"><?=number_format($valor_almacen_x_status_0,2,'.',',')?></td>
    <td align="right"><?=$p0?></td>
	<td align="center"><a href="valor_x_status_detalle.php?status=0" title="ver mas ..." target="_blank">ver</a></td>
  </tr>
  <tr>
	  <td>Lento Movimiento </td>
	  <td align="right"><?=number_format($valor_almacen_x_status_1,2,'.',',')?></td>
	  <td align="right"><?=$p1?></td>
	  <td align="center"><a href="valor_x_status_detalle.php?status=1" title="ver mas ..." target="_blank">ver</a></td>
  </tr>
  <tr>
	  <td>Obsoleto</td>
	  <td align="right"><?=number_format($valor_almacen_x_status_2,2,'.',',')?></td>
	  <td align="right"><?=$p2?></td>
	  <td align="center"><a href="valor_x_status_detalle.php?status=2" title="ver mas ..." target="_blank">ver</a></td>
  </tr>
  <tr>
  	  <th>&nbsp;</th>
	  <th><?=number_format($suma_valor,2,'.',',')?></th>
	  <th>100 %</th>
	  <th align="center">&nbsp;</th>
  </tr>
</table>
</p>
<p id="div_grafica" align="center"><img src="grafica_valor_status.php" style="border:#CCCCCC 1px solid; " /></p>
<p align="center"><a href="index.php" style="text-decoration:none;">Volver a reportes</a></p>
</body>
</html>
