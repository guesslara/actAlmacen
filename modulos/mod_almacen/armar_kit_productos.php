<?php 
require_once("../conf/conectarbase.php");
$hostname_conexion=$host;
$database_conexion=$sql_db;
$username_conexion=$usuario;
$password_conexion=$pass;
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 

	$color="#EFEFEF";
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 50;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT id, id_prod, descripgral, especificacion FROM catprod ORDER BY id ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conexion) or die(mysql_error());
//$ndr=mysql_num_rows($Recordset1);
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Armar Kit de productos</title>
<script language="javascript" src="../js/jquery.js"></script>
<script language="javascript">
	function selecciona_casilla(i){
		var valor_checkbox=$("#chk_"+i).attr("checked");	//alert(valor_checkbox);
		if (!valor_checkbox){
			$("#chk_"+i).attr("checked","checked");
			var color_tr=$("#tr_"+i).attr("bgcolor");
			$("#tr_"+i).attr("bgcolor","#D9FFB3");
		} else {
			$("#chk_"+i).attr("checked","");
			$("#tr_"+i).attr("bgcolor","");
		}	
	}
	
	function armar_kit(){
		var claves="";
		for (var i=0;i<document.frm_kit_productos.elements.length;i++)
		{
			if (document.frm_kit_productos.elements[i].type=="checkbox")
			{
				if (document.frm_kit_productos.elements[i].checked)
				{
					//alert("Variable claves=["+claves+"]");
					if (claves==""){
						var id=document.frm_kit_productos.elements[i].value;
						var ca=$("#txt_cantidad_"+id).attr("value");
						if (isNaN(ca)){
							alert("La cantidad ("+ca+") no es un numero.");
							return;
						}
						claves=id+"("+ca+")";
					}else{
						var id=document.frm_kit_productos.elements[i].value;
						var ca=$("#txt_cantidad_"+id).attr("value");
						if (isNaN(ca)){
							alert("La cantidad ("+ca+") no es un numero.");
							return;
						}						
						claves=claves+","+id+"("+ca+")";
					}	
				}	
			}
		}
		if (claves==""||claves=='undefined'||claves==null) return;
		var campo_valor_kit=opener.document.form1.kit_array;
		var elementos_en_kit=campo_valor_kit.value;	
		//alert("NOMBRE DEL CAMPO ["+campo_valor_kit+"] VALOR ["+elementos_en_kit+"] "+"\nKIT ["+claves+"]");
		if (elementos_en_kit==""||elementos_en_kit==undefined||elementos_en_kit==null){
			campo_valor_kit.value=claves;
			self.close();
		} else {
			campo_valor_kit.value=elementos_en_kit+","+claves;
			self.close();
		}
	}
	function cerrar(elEvento) {
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	var caracter = String.fromCharCode(codigo);
	//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
		if (codigo==27){
			self.close();
		}	
	}
	document.onkeypress = cerrar;	
</script>
<style type="text/css">
	.cantidad{ text-align:right; width:50px;}
	.campos{ text-align:center; font-weight:bold; border-bottom:#000000 2px solid; }
	.campos_inferiores{  text-align:center; font-weight:bold; border-top:#000000 2px solid; }
</style>
</head>

<body>
<h2 align="center">Armando Kits de  Productos. </h2>
<h4 align="center"><?=$ndr?> Productos activos asociados al Almac&eacute;n (
  <?=$idalm?>
  )
  <?=$nalm0?>
  . </h4>
<form id="form1" name="frm_kit_productos" method="post" action="">
<table width="100%" cellspacing="0" cellpadding="2" align="center" style="font-size:11px;">
  <tr>
    <td height="33" colspan="7" align="right"><input type="reset" value="Limpiar Formulario" />&nbsp;<input type="button" onclick="armar_kit()" value="Agregar al Kit" /></td>
    </tr>
  <tr>
    <td width="20" class="campos">&nbsp;</td>
	<td width="73" class="campos">Cantidad</td>
    <td width="100" class="campos">Id Producto </td>
    <td width="138" class="campos">Clave de producto </td>
    <td width="381" class="campos">Descripci&oacute;n</td>
    <td width="262" class="campos">Especificaci&oacute;n</td>
  </tr>
  <?php do { ?>
      <tr id="tr_<?=$row_Recordset1['id']?>" bgcolor="<?=$color?>" onClick="selecciona_casilla('<?=$row_Recordset1['id']?>')" style="cursor:pointer;">
      <td><input type="checkbox" id="chk_<?=$row_Recordset1['id']?>" value="<?=$row_Recordset1['id']?>" /></td>
	  <td align="center"><input type="text" class="cantidad" id="txt_cantidad_<?=$row_Recordset1['id']?>" value="1" /></td>
      <td><?php echo $row_Recordset1['id']; ?></td>
      <td><?php echo $row_Recordset1['id_prod']; ?></td>
      <td><?php echo $row_Recordset1['descripgral']; ?></td>
      <td><?php echo $row_Recordset1['especificacion']; ?></td>
    </tr>
    <?php ($color=="#EFEFEF")? $color="#FFFFFF" : $color="#EFEFEF"; } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
	<td height="34" colspan="7" align="center" class="campos_inferiores"><input type="reset" value="Limpiar Formulario" />&nbsp;<input type="button" onclick="armar_kit()" value="Agregar al Kit" /></td>
	</tr>
</table>
<p>
<table border="0" width="50%" align="center" style="border:#000000 1px solid; background-color:#FFFFCC;">
  <tr>
    <td colspan="4" align="center">P&aacute;ginas</td>
    </tr>
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">Primero</a>
          <?php } // Show if not first page ?>    </td>
    <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Anterior</a>
          <?php } // Show if not first page ?>    </td>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Siguiente</a>
          <?php } // Show if not last page ?>    </td>
    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?>    </td>
  </tr>
</table>
</form>
</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
