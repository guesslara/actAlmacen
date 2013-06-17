<?
//  Autentificator
//  Gestión de Usuarios PHP+Mysql
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  ------------------------------
require("aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=1; // definir nivel de acceso para esta página.
if (($nivel_acceso < $_SESSION['usuario_nivel']) or ($nivel_acceso == $_SESSION['usuario_nivel']) ){
header ("Location: $redir?error_login=0");
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Equipo</title>
<link type="text/css" rel="stylesheet" href="../php/CDCanada.css" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<script> 
var win1var; 
var n;	
function abreVentanaTec(){
    win1= window.open("tec_list.php","Catalogo","width=300,height=300,scrollbars=yes,top=50,left=600") 
    win1.focus()
} 
function abreVentanaMarcas(){
    win1= window.open("marc_list2.php","Catalogo","width=300,height=300,scrollbars=yes,top=50,left=600") 
    win1.focus()
} 
function abreVentanaTipo(){
	n=this.document.form.clavetec.value
    win1= window.open("tipo_list2.php?n="+n,"Catalogo","width=300,height=300,scrollbars=yes,top=50,left=600") 
    win1.focus()
} 
</script> 
</head>
<body>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td bgcolor="#0099FF"><div align="center" class="style6"><a href="mov_list.php" class="style6">Movimientos</a> |<a href="inventario.php" class="style6"> Inventarios</a>  | <a href="tipo_alm_listado.php" class="Estilo50">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo50">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo50">Lineas de Producto</a> | <a href="cat_product1.php" class="Estilo50">Cat. Productos</a></div></td>
  </tr>
  <tr>
    <td><div align="center"><span class="style8"><span class="style10"><a href="cat_prod.php" class="link2">Alta de Producto</a> | <a href="cat_prod_bus.php" class="link2">Busqueda</a> | <a href="cat_prod_list.php" class="link2">Listado de Productos</a></span></span></div></td>
  </tr>
</table>
<?
		include("../php/conectarbase.php");
		$select="SELECT cat_prod.*, cat_tecnologia.*, cat_marcas.*, cat_tipoprod.* ";
		$from="FROM cat_prod, cat_tecnologia, cat_marcas, cat_tipoprod  ";
		$where="WHERE cat_prod.tecnologia=cat_tecnologia.clave and cat_prod.marca=cat_marcas.clave and cat_prod.tipoprod=cat_tipoprod.clavetec";
		$sql="SELECT cat_prod.*,cat_marcas.marca FROM cat_prod,cat_marcas WHERE cat_prod.marca=cat_marcas.clave ORDER BY clave";
		$result=mysql_db_query("dbcanada",$sql);
		$row=mysql_fetch_array($result);	//	$row[0]; variable del ultimo introducido
?>.
<table width="743" border="0" align="center" cellspacing="1">
  <tr>
    <td colspan="7" bgcolor="#000066"><div align="center" class="style11">
      <div align="center"><span class="TituloTabla">Lista de Productos en CATALOGO</span></div>
    </div></td>
  </tr>
  <tr>
    <td width="34" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Id</strong></div></td>
    <td width="71" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Clave</strong></div></td>
    <td width="122" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Tecnologia</strong></div></td>
    <td width="98" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Marca</strong></div></td>
    <td width="94" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Tipo Prod</strong></div></td>
    <td width="229" bgcolor="#CCCCCC" class="TituloCabecera"><div align="left"><strong>Descripcion</strong></div></td>
    <td width="81" bgcolor="#CCCCCC" class="TituloCabecera"><div align="center"><strong>Modelo</strong></div></td>
  </tr>
<?
	$color="#DDFFFF";
	while($row=mysql_fetch_array($result)){
?>
  <tr>
    <td bgcolor=<?=$color;?> class="TextoTabla"><?=$row[0];?></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><div align="center">
      <?=$row[1];?>
    </div></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><div align="center">
      <?=$row[2];?>
    </div></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><div align="center">
      <?=$row[8];?>
    </div></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><div align="center">
      <?=$row[4];?>
    </div></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><?=$row[6];?></td>
    <td bgcolor=<?=$color;?> class="TextoTabla"><?=$row[5];?></td>
  </tr>
<?
		if ($color=="#DDFFFF") 
			$color="#ffffff";
		else 
			$color="#DDFFFF";
	}
?>
</table>
<?=$obs;?>
<hr />
<p align="center" class="Estilo1">IQelectronics
</body>
</html>