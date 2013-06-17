<?php 
	session_start();
	exit;
	include("../conf/conectarbase.php");
	//print_r($_POST);
	
	if ($_POST['action']=="listar_productos")
	{
		//print_r($_POST);
		$idpv=$_POST["idpv"];
		//echo "<br>".
		$sql3="SELECT prodxprov.id_prod, catprod.id, catprod.descripgral, catprod.especificacion 
			FROM prodxprov,catprod 
			WHERE prodxprov.id_prov=$idpv AND prodxprov.id_prod=catprod.id_prod ORDER BY catprod.id ";
		$result3=mysql_db_query($sql_db,$sql3);
			?>
			<table width="400" cellspacing="0" cellpadding="2" id="tbl_2" align="center" style="font-size:9px; border:#333333 1px solid;">
			  <tr style="text-align:center; font-weight:normal; background-color:#333333; color:#FFFFFF;">
				<td colspan="4" height="20">Productos asociado al Proveedor <?=$idpv?>. </td>
				</tr>
			  <tr style="text-align:center; font-weight:bold; background-color:#CCCCCC;">
				<td width="40" height="20">Id_Prod </td>
				<td width="60">Clave</td>
				<td width="200">Descripci&oacute;n</td>
				<td width="100">Especificaci&oacute;n</td>
			  </tr>			
			<?php $color="#ffffff"; while ($row3=mysql_fetch_array($result3)){ ?>
				  <tr bgcolor="<?=$color?>" style="font-size:9px;">
					<td height="20" align="center"><?=$row3["id"]?></td>
					<td class="td1"><a href="javascript:ver_historico('<?=$idpv?>','<?=$row3["id_prod"]?>');" title="Ver historico"><?=$row3["id_prod"]?></a></td>
					<td><?=$row3["descripgral"]?></td>
					<td class="td1i"><?=$row3["especificacion"]?></td>
				  </tr>
			<?php 
			($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; 
			} ?>
			</table>
			<?php 
		//}			
		exit();
	}
	
	if ($_POST['action']=="listar_pvsp")
	{
		//print_r($_POST);
		$p=$_POST["cdp"];
		$v=$_POST["idpv"];
		//echo "<br>".
		$sql="SELECT oc.*,items.id_producto,items.cantidad FROM oc,items WHERE items.id_oc=oc.id_oc AND items.id_producto='$p' AND oc.id_prov='$v' ";
		$result=mysql_db_query($dbcompras,$sql);
		//echo "<br>NDR=".
		$ndr1=mysql_num_rows($result);		
		if ($ndr1>0) {
			?>
			<br /><br /><table width="790" align="center" cellspacing="0" cellpadding="1" style="border:#CCCCCC 1px solid;">
			  <tr style="font-size:11px; text-align:center; font-weight:bold; background-color:#CCCCCC;">
				<td height="20">Id OC </td>
				<td>Fecha de Realizaci&oacute;n </td>
				<td>Cantidad Solicitada </td>
				<td>Tiempo_de_entrega (d&iacute;as) </td>
				<td>Fecha de Entrega </td>
			  </tr>
			  <?php 
			  $c="#FFFFFF";
			  while ($row=mysql_fetch_array($result)){ ?>
				  <tr style="font-size:11px; text-align:center; font-weight:normal; background-color:<?=$c?>;">
					<td height="20"><?=$row["id_oc"]?></td>
					<td class="td1"><?=$row["fecha"]?></td>
					<td><?=$row["cantidad"]?></td>
					<td class="td1"><?=$row["tiempoEntrega"]?></td>
					<td><?=$row["fechaEntregado"]?></td>
				  </tr>
				  <?php ($c=="#FFFFFF")? $c="EFEFEF" : $c="#FFFFFF";  }  ?>
			</table>
			
			<?php
			//echo "<br>".
			$sql2="SELECT avg(tiempoEntrega) as media_aritmetica FROM oc,items WHERE items.id_oc=oc.id_oc AND items.id_producto='$p' AND oc.id_prov='$v' ";
			$result2=mysql_db_query($dbcompras,$sql2);
			//echo "<br>NDR MA=".$ndr2=mysql_num_rows($result2);
			while ($row2=mysql_fetch_array($result2)){
				$ma2=$row2["media_aritmetica"];
			}
			echo "<div align='center' style='font-size:11px;'>El tiempo PROMEDIO de entrega del Producto ($p) por parte del Proveedor ($v) es de <b>$ma2 dias</b>.</div>";
		
		} else { ?><br /><br /><div align="center">No se encontraron compras realizadas al proveedor <?=$v?>.</div><?php }
		
		exit();
	}		
	
	echo "<br>";
	$sql2="SELECT id_prov,codigo,nr FROM catprovee";
	$result2=mysql_db_query($dbcompras,$sql2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Proveedores y productos</title>
<style type="text/css">
	body,document{ margin:0px 0px 0px 0px; font-family:Verdana, Arial, Helvetica, sans-serif;}
	a:link{ text-decoration:none;}
	a:hover{ text-decoration:none; color:#FF0000;}
	a:visited{ text-decoration:none;}
		
	#opciones{ text-align:right;}
	#div1{ text-align:center;}
	.txt1 { border:#CCCCCC 1px solid; background-color:#FFFFFF; text-align:right;} 
	.graficar{border: #666666 1px solid; padding:2px; font-weight:bold; margin:2px; text-decoration:none; background-color:#EFEFEF;}
	
	/*#datos{ position:relative; width:800px; height:310px; left:50%; margin-left:-400px; margin-bottom:5px; border:#EFEFEF 1px solid; }*/
	#grafica{ position:relative; width:800px;height:500px; left:50%; margin-left:-400px; border:#EFEFEF 1px solid; }
	
	
	#tbl_1{ border:#333333 1px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; }
	.td1{ border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid; }
	.td1i{ border-left:#CCCCCC 1px solid; }
	.div_pap{ background-color:#FFFFFF; margin:1px; padding:2px; display:none; /*height:250px; overflow:auto;*/}
	
	#div_historico{ display:none; z-index:2; position:absolute; width:800px; height:600px; top:50%; left:50%; margin-top:-300px; margin-left:-400px; border:#333333 2px solid; background-color:#FFFFFF;}
	#div_historico2{ width:796px; height:574px; /*border:#CCCCCC 2px solid;*/ background-color:#FFFFFF; overflow-y:auto; clear:both; /*margin-top:20px;*/ }
</style>
<script language="javascript" type="text/javascript" src="../js/flot/jquery.js"></script>
<script language="javascript" type="text/javascript">
	function ver_productos_asociados(c,i)
	{
		//$(".div_pap").hide();
		//alert("Ver productos del Proveedor: "+i+"\nColocarlo en la capa: "+c);
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"<?=$_SERVER['PHP_SELF']?>",
			data:"action=listar_productos&idpv="+i,
			beforeSend:function(){ 
				$("#"+c).show().html('<center><img src="../img/indicator.gif" /><br>Procesando datos, espere un momento.</center>'); 
			},
			success:function(datos){ $("#"+c).show().html(datos); },
			timeout:90000000,
			error:function() { $("#"+c).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	function ocultar(d) { $("#"+d).hide(); $("#datos").show();  }
	function ver_historico(p,cdp)
	{
		//alert("Ver Historico del Proveedor: "+p+"\ny Producto: "+cdp);
		$("#div_historico").show();
		$("#datos").hide();
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"<?=$_SERVER['PHP_SELF']?>",
			data:"action=listar_pvsp&idpv="+p+"&cdp="+cdp,
			beforeSend:function(){ 
				$("#div_historico2").show().html('<center><img src="../img/indicator.gif" /><br>Procesando datos, espere un momento.</center>'); 
			},
			success:function(datos){ 
				$("#div_historico1").show().html('&nbsp;Compras del Producto ('+cdp+') realizadas al Proveedor ('+p+').'); 
				$("#div_historico2").show().html(datos); 
				
			},
			timeout:90000000,
			error:function() { $("#div_historico2").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}
	
	function cerrar(elEvento) {
		var evento = elEvento || window.event;
		var codigo = evento.charCode || evento.keyCode;
		var caracter = String.fromCharCode(codigo);
		//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
		if (codigo==27||codigo==13)	ocultar('div_historico');
		//true==$("#div_historico").show()&&(
	}
	document.onkeypress = cerrar;		
</script>	
</head>

<body topmargin="0">

<br />
<div id="datos">
<div align="right"><a href="index.php" style="font-size:12px;">Regresar al Reportes.&nbsp;&nbsp;</a></div><br />	
<table width="800" cellspacing="0" cellpadding="2" id="tbl_1" align="center">
  <tr style="text-align:center; font-weight:bold; background-color:#333333; color:#FFFFFF;">
    <td colspan="4" height="20">Asociaci&oacute;n Proveedores y Productos. </td>
    </tr>
  <tr style="text-align:center; font-weight:bold; font-size:11px; background-color:#CCCCCC;">
    <td width="56" height="20">Id_Prov. </td>
    <td width="356">Proveedor</td>
    <td width="65">Detalles</td>
    <td width="305">Producto(s) asociado(s)</td>
  </tr>
  <?php 
  $c="#FFFFFF";
  while ($row2=mysql_fetch_array($result2)){ ?>
  <tr bgcolor="<?=$c?>">
    <td align="center" height="20"><?=$row2["id_prov"]?></td>
    <td class="td1"><?=$row2["nr"]?></td>
    <td align="center"><a href="javascript:ver_productos_asociados('div_pap<?=$row2["id_prov"]?>','<?=$row2["id_prov"]?>');">Ver</a></td>
    <td class="td1i">&nbsp;<div id="div_pap<?=$row2["id_prov"]?>" class="div_pap"></div>&nbsp; </td>
  </tr>
  <?php 
  ($c=="#FFFFFF")? $c="EFEFEF" : $c="#FFFFFF"; 
  } ?>
</table>
	<?php include("../f.php"); ?>
</div>
<div id="div_historico">
	<div id="div_historico1" style="width:784px; height:19px; float:left; background-color:#333333; color:#FFFFFF; font-size:12px; padding-top:3px; ">&nbsp;</div>
	<a href="javascript:ocultar('div_historico');" style="border:#333333 1px solid; background-color:#FFFFFF; color:#990000; font-weight:bold; padding:1px; float:right;">X</a>
	
	<div id="div_historico2"></div>
</div>


</body>
</html>
