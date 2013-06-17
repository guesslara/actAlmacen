<?php 
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
//print_r($_SESSION);	echo "<hr>";
//print_r($_POST);	echo "<hr>";	
$ac=$_POST["ac"];
switch ($ac){
	case "obtener_lineas":
		include("clase_inventario.php");
		$inv1=new inventario();
		$inv1->obtener_lineas();
		break;		
	case "listar_productos":
		(!empty($_POST['linea']))? $linea=$_POST["linea"] : $linea='';
		(!empty($_POST['campo']))? $campo=$_POST["campo"] : $campo='id';
		(!empty($_POST['operador']))? $operador=$_POST["operador"] : $operador='LIKE';	
		(!empty($_POST['criterio']))? $criterio=$_POST['criterio'] : $criterio='';
		(!empty($_POST['orden']))? $orden=$_POST["orden"] : $orden='id';		
		(!empty($_POST['ascdes']))? $ascdes=$_POST["ascdes"] : $ascdes='ASC';
		(!empty($_POST['no_pagina']))? $no_pagina=$_POST["no_pagina"] : $no_pagina=1;
		//$no_pagina=3;
		include("clase_inventario.php");
		$inv1=new inventario();
		$inv1->listar_productos($linea,$campo,$operador,$criterio,$orden,$ascdes,$no_pagina);
		break;
	case "ver_producto_detalle":
		include("clase_inventario.php");
		$inv1=new inventario();
		$inv1->ver_producto_detalle($_POST["id_producto"],$_POST["que"]);
		break;		
	case "editar_guardar_sql":
		include("clase_producto.php");
		$pro1=new producto();
		$pro1->editar_guardar_sql($_POST["sql"]);
		break;		
	default:
		echo "&nbsp;Accion no registrada.";
		break;
}
?>
