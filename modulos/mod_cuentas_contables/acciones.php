<?php 
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
//print_r($_POST);	echo "<hr>";	
$ac=$_POST["ac"];
switch ($ac){
	case "listar_CC":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->listar();
		break;
	//cuenta_cc_insertar	
	case "cuenta_cc_insertar":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->cuenta_cc_insertar($_POST["cue"],$_POST["a"],$_POST["b"],$_POST["c"],$_POST["d"],$_POST["des"],$_POST["obs"]);
			//cue="+cue+"&a="+a+"&b="+b+"&c="+c+"&d="+d+"&des="+des+"&obs="+obs;
		break;		
	//listar_productos_x_linea	
	case "listar_productos_x_linea":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->listar_productos_lineas();
		break;
	// ver_productos_x_linea
	case "ver_productos_x_linea":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->listar_productos_x_lineaX($_POST["linea"],$_POST["criterio"]);
		break;	
	//asociar_prods_a_cc	
	case "asociar_prods_a_cc":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->asociar_prods_a_cc($_POST["cc"],$_POST["prods"]);
		break;			
	//listar_asociados
	case "listar_asociados":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->listar_asociados();
		break;	
	//ver_productos_asociados
	case "ver_productos_asociados":
		include("clase_cc.php");
		$cc1=new cc();
		$cc1->ver_productos_asociados($_POST["id_cuenta"],$_POST["cuenta"]);
		break;	
	//listar_consumo_resumen
	case "listar_consumo_resumen":
		include("clase_consumo.php");
		$c1=new consumo();
		$c1->listar_consumo_resumen();
		break;
	
	case "listar_consumo_detalle":
		include("clase_consumo.php");
		$c1=new consumo();
		$c1->listar_consumo_detalle();
		break;					
	/*
	listar_consumo_resumen_cuentacontable
	*/
	case "listar_consumo_resumen_cuentacontable":
		include("clase_consumo.php");
		$c1=new consumo();
		$c1->listar_consumo_resumen_cuentacontable();
		break;
	// listar_consumo_detalle_cuenta_contable
	case "listar_consumo_detalle_cuenta_contable":
		include("clase_consumo.php");
		$c1=new consumo();
		$c1->listar_consumo_detalle_cuenta_contable();
		break;
	
	
	//listar_equipos_no_asociados
	case "listar_equipos_no_asociados":
		include("clase_cc_x_centro_costo.php");
		$cc1=new cc_vs_cc();
		$cc1->listar_equipos_no_asociados();
		break;			
	
	
	
	
	//--------------------------------------------- clase_cc_x_centro_costo		
	case "listar_consumo_cuentacontable_x_centro_costo":
		include("clase_cc_x_centro_costo.php");
		$cc1=new cc_vs_cc();
		$cc1->cc_x_cdc_menu();
		break;	
	//listar_consumo_detalle_CC_del_CdC
	case "listar_consumo_detalle_CC_del_CdC":
		print_r($_POST);
		include("clase_cc_x_centro_costo.php");
		$cc1=new cc_vs_cc();
		$cc1->listar_consumo_detalle_CC_del_CdC($_POST["id_centro_costo"]);
		break;		
	//listar_consumo_resumen_CC_del_CdC
	case "listar_consumo_resumen_CC_del_CdC":
		include("clase_cc_x_centro_costo.php");
		$cc1=new cc_vs_cc();
		$cc1->listar_consumo_resumen_CC_del_CdC($_POST["id_centro_costo"]);
		break;	
		
	default:
		echo "&nbsp;Accion no registrada.";
		break;
}
?>
