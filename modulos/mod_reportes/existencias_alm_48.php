<?php 
	session_start();
	/*
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,10);
	*/
require("../conf/conectarbase.php");
function obtener_valor_producto($idp){
	require("../conf/conectarbase.php");
	
	//prodxmov.id, concepmov.tipo, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion,
	//echo "<br>".
	$sql="SELECT 
	sum(prodxmov.existen*prodxmov.cu) AS subtotal
	from 
		concepmov,mov_almacen,prodxmov 
	where 
		mov_almacen.id_mov=prodxmov.nummov 
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND prodxmov.existen>0 
		AND concepmov.tipo='Ent' 
		AND mov_almacen.almacen=77
		AND prodxmov.id_prod=$idp
		
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
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Valor del Inventario - Almacen 77</title>
</head>

<body>
<?php include("../menu/menu.php"); 
//echo "<br>".
$sql="SELECT id,id_prod,descripgral,especificacion,exist_77 from catprod where exist_77>0 order by id";
if($res=mysql_db_query($sql_db,$sql,$link)){
	$Resultados=mysql_num_rows($res);
	?><br /><table align="center" cellpadding="1" cellspacing="0" style="border:#333333 1px solid; ">
	<tr style=" font-weight:bold; text-align:center; background-color:#333333; color:#FFFFFF; ">
	  <td colspan="6" height="20">Valor del Inventario del Almacen 77 (<small>mostrando <?=$Resultados?> resultados</small>).</td>
  </tr>
	<tr style=" font-weight:bold; text-align:center; background-color:#CCCCCC;">
		<td height="20">id</td>
		<td>clave</td>
		<td>descripcion</td>
		<td>especificacion</td>
		<td>existencias</td>
		<td>subtotal $ </td>
	</tr>
	<?php
	$color="#FFFFFF";
	while($reg=mysql_fetch_array($res)){
		//echo "<br>";	print_r($reg);
		$subtotal_producto=obtener_valor_producto($reg["id"]);
		$total_dinero+=$subtotal_producto;
		?>
		<tr bgcolor="<?=$color?>">
			<td align="center" height="20"><?=$reg["id"]?></td>
			<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;"><?=$reg["id_prod"]?></td>
			<td><?=$reg["descripgral"]?></td>
			<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;"><?=$reg["especificacion"]?></td>
			<td align="right"><?=$reg["exist_77"]?></td>
			<td style="border-left:#CCCCCC 1px solid;" align="right"><?=number_format($subtotal_producto,2,'.',',')?></td>
		</tr>		
		<?php
		($color=="#FFFFFF")? $color="#D9FFB3" : $color="#FFFFFF";
	}
	?></table>
<?php
}else{
	echo mysql_error($link);
}
echo "<br><p align='center'>Valor Total: <b>$ ".number_format($total_dinero,2,'.',',')."</b></p>";
?>
</body>
</html>