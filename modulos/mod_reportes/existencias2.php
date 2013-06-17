<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,10);
function obtener_valor_producto($idp){
	require("../conf/conectarbase.php");
	//prodxmov.id, concepmov.tipo, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion,
	//echo "<br>".
	$sql="SELECT 
	sum(prodxmov.existen*prodxmov.cu) AS subtotal
	from concepmov,mov_almacen,prodxmov 
	where mov_almacen.id_mov=prodxmov.nummov AND mov_almacen.tipo_mov=concepmov.id_concep AND prodxmov.existen>0 AND concepmov.tipo='Ent' AND prodxmov.id_prod=$idp  
	order by prodxmov.id";
	if($res=mysql_db_query($sql_db,$sql,$link)){
		//echo "<br> Resultados=".mysql_num_rows($res);
		while($reg=mysql_fetch_array($res)){
			//echo "<br>";	print_r($reg);
			return $reg["subtotal"];	
		}	
	}else{
		echo mysql_error($link);
	}		
}
function dame_total_dinero(){
	require("../conf/conectarbase.php");
	echo "<br>".$sql="SELECT id from catprod where exist_1>0 order by id";
	$total_dinero=0;
	if($res=mysql_db_query($sql_db,$sql,$link)){
		echo "<br> Resultados=".mysql_num_rows($res);
		while($reg=mysql_fetch_array($res)){
			//echo "<br>";	print_r($reg);
			$subtotal_producto=obtener_valor_producto($reg["id"]);
			$total_dinero+=$subtotal_producto;
		}
	}else{
		echo mysql_error($link);
	}
	return $total_dinero;
}
function obtener_valor_inventario(){
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
		AND catprod.exist_1>0		
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
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Existencias</title>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<!--<p style="text-align:center; font-weight:bold;">Valor del Inventario.</p>//-->
<p>&nbsp;</p>
<p style="text-align:center; font-weight:bold; font-size:12px;">Valor Total del Inventario:</p> 
<p style="text-align:center; font-weight:bold; font-size:24px;">$ <?=number_format(obtener_valor_inventario(),2,'.',',')?></p>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	<?php include("../f.php"); ?>
</body>
</html>