<?php
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
$valor_almacen1=round(dame_valor_almacen(1));
$valor_almacen44=round(dame_valor_almacen(44));
//$valor_almacen48=round(dame_valor_almacen(48));
	
	
	$paises=array("1. General","44. Material No Conforme"); //,"48. Producto Terminado Cosmetica"
	$valores=array($valor_almacen1,$valor_almacen44); 	//,$valor_almacen48
	$total=array_sum($valores);
	
	for($i=0;$i<count($valores);$i++){
		$porcentajes[]=round(($valores[$i]/$total)*100,2);
		$angulos[]=round(($porcentajes[$i]*360)/100);
	}
	
	header("Content-type: image/png");
	$imagen=imagecreate(580,240);
	$bg=imagecolorallocate($imagen,255,255,255);
	$gris=imagecolorallocate($imagen,100,100,100);
	
	$color1=imagecolorallocate($imagen,93,169,227);
	$color2=imagecolorallocate($imagen,227,93,93);
	//$color3=imagecolorallocate($imagen,93,227,144);
	
	/*
	$color1=imagecolorallocate($imagen,227,203,93);
	$color2=imagecolorallocate($imagen,93,227,144);
	$color3=imagecolorallocate($imagen,93,169,227);
	*/
	//$color4=imagecolorallocate($imagen,207,93,227);
	//$color5=imagecolorallocate($imagen,227,93,93);
	
	$colores=array($color1,$color2);	//,$color3
	
	$cx=120;
	$cy=120;
	
	$ancho=200;
	$alto=200;
	
	$inicio=0;
	for($i=0;$i<count($valores);$i++){
		imagefilledarc($imagen,$cx,$cy,$ancho,$alto,$inicio,$angulos[$i]+$inicio,$colores[$i],IMG_ARC_PIE);
		imagefilledrectangle($imagen,250,120+($i*20),264,134+($i*20),$colores[$i]);
		imagestring($imagen,3,276,122+($i*20),$paises[$i]." (".$porcentajes[$i]." %)",$gris);
		$inicio+=$angulos[$i];
	}
	imagepng($imagen);
	imagedestroy($imagen);
?>