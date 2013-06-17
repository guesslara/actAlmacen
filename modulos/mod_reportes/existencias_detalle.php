<?php 
	session_start();
	//print_r($_SESSION);
	//include ("../conf/validar_usuarios.php");
	//validar_usuarios(0,1,10);
require("../conf/conectarbase.php");
function obtener_valor_producto($idp){
	
	require("../conf/conectarbase.php");
	
	//prodxmov.id, concepmov.tipo, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion,
	//echo "<br>".
	$sql="SELECT 
	sum(prodxmov.existen*prodxmov.cu) AS subtotal
	from concepmov,mov_almacen,prodxmov 
	where 
		mov_almacen.id_mov=prodxmov.nummov
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND prodxmov.existen>0 
		AND concepmov.tipo='Ent' 
		AND mov_almacen.almacen=1
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
function obtener_valor_producto_detalle($idp){
	//echo "<br>Id recibido ($idp)";
	
	require("../conf/conectarbase.php");
	
	//prodxmov.id, concepmov.tipo, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion,
	//echo "<br>".
	$sql="SELECT 
		prodxmov.id_prod,prodxmov.clave,
		mov_almacen.id_mov,
		concepmov.concepto,concepmov.tipo,
		mov_almacen.almacen,
		prodxmov.cantidad,prodxmov.existen,prodxmov.cu,
		
		prodxmov.existen*prodxmov.cu AS subtotalX
	from concepmov,mov_almacen,prodxmov 
	where 
		mov_almacen.id_mov=prodxmov.nummov
		AND mov_almacen.tipo_mov=concepmov.id_concep 
		AND prodxmov.existen>0 
		AND concepmov.tipo='Ent' 
		AND mov_almacen.almacen=1
		AND prodxmov.id_prod=$idp  
	order by prodxmov.id";
	if($res=mysql_db_query($sql_db,$sql,$link)){
		//echo "<br> Resultados=".
		$ndr=mysql_num_rows($res);
		if($ndr>0){
			if($ndr==1){
				$reg=mysql_fetch_array($res);
				echo number_format($reg["cu"],2,'.',',');
			}else{
				?>
				<table align="left" cellpadding="1" cellspacing="0" class="tbl_0003">
				<tr>
					<td class="td_campos_small">Mov.</td>
					<td class="td_campos_small">concepto</td>
					<td class="td_campos_small">cantidad</td>
					<td class="td_campos_small">existen</td>
					<td class="td_campos_small">$CU</td>
					<td class="td_campos_small">subtotal</td>
				</tr>
				<?php
				while($reg=mysql_fetch_array($res)){
					//echo "<br><br>";	print_r($reg);
					//return $reg["subtotal"];
					?>
					<tr>
						<td align="center"><?=$reg["id_mov"]?></td>
						<td><?=$reg["concepto"]?></td>
						<td align="right"><?=$reg["cantidad"]?></td>
						<td align="right"><?=$reg["existen"]?></td>
						<td align="right"><?=$reg["cu"]?></td>
						<td align="right">$<?=number_format($reg["subtotalX"],2,'.',',')?></td>
					</tr>				
					<?php	
				}
				?>
				</table>
				<?php
			}
		}else{
			echo "<br>El Producto $idp no tiene existencias en el almacen 1. General.";
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
<title>Valor del Inventario</title>
<style type="text/css">
.tbl_0003{ width:100%; margin:2px; font-size:10px; }
.td_campos_small{ font-weight:bold; text-align:center; border-bottom:#333333 1px dashed; }
</style>
</head>

<body>
<?php include("../menu/menu.php"); 
//echo "<br>".
$sql="SELECT id,id_prod,descripgral,especificacion,exist_1 from catprod where exist_1>0 order by id;";
if($res=mysql_db_query($sql_db,$sql,$link)){
	$Resultados=mysql_num_rows($res);
	?><br /><table align="center" cellpadding="1" cellspacing="0" style="border:#333333 1px solid; " width="99%">
	<tr style=" font-weight:bold; text-align:center; background-color:#333333; color:#FFFFFF; ">
	  <td colspan="7" height="20">Valor del Inventario en el Almac&eacute;n 1 (<small>mostrando <?=$Resultados?> resultados</small>).</td>
  </tr>
	<tr style=" font-weight:bold; text-align:center; background-color:#CCCCCC;">
		<td height="20">id</td>
		<td>clave</td>
		<td>descripcion</td>
		<td>especificacion</td>
		<td>existencias</td>
		<td>subtotal $ </td>
		<td>Costo Unitario ($) </td>
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
			<td align="right"><?=$reg["exist_1"]?></td>
			<td style="border-left:#CCCCCC 1px solid;" align="right"><?=number_format($subtotal_producto,2,'.',',')?></td>
			<td align="right"><?php obtener_valor_producto_detalle($reg["id"]); ?></td>
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