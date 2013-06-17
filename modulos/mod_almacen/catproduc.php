<?php 
include("../php/conectarbase.php");
include('clase_asociacion_prod_alm.php');
$lista_campos=" `id`, `id_prod`, `descripgral`, `especificacion`, `linea`, `marca`, `control_alm`, `ubicacion`,`uni_entrada`,`uni_salida`,`stock_min`,`stock_max`,`observa`,`unidad`,`tipo`,`kit`,`cpromedio`,`$calm0`,`$cexi0`,`$ctra0` ";
	print_r($_GET);
	$n=$_GET["n"];			echo $m=$_GET["m"];				$p=$_GET["p"]; //id de producto
	$a=$_GET["a"];// almacen a operar					
	$actual=$_SERVER['PHP_SELF'];

	if (isset($_GET['txt_criterio']))
	{
		$cri=$_GET['txt_criterio'];
		$n=$_GET['n'];
		$m=$_GET['m'];
		$p=$_GET["p"]; //id de producto
		$a=$_GET["a"];// almacen a operar
		
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id) as total_registros FROM catprod where descripgral like '%" . $cri . "%' ";
/*if($m==Compras){
$sql="SELECT catprod.*,prodxprov.* FROM catprod,prodxprov WHERE catprod.id_prod=prodxprov.id_prod AND prodxprov.id_prov='$p' and catprod.descripgral like '%" . $cri . "%' order by catprod.id_prod LIMIT ".$limitInf.",".$tamPag;
	}elseif($m=='Ajuste'||$m=='Dev Compras'||$m=='Ventas'||$m=='Dev venta'||$m=='Canc de Compra') {
$sql="SELECT * FROM catprod where descripgral like '%" . $cri . "%' order by id_prod LIMIT ".$limitInf.",".$tamPag;
	}elseif ($m=='Inventario Inicial'){
//echo "<br>Inventario Inicial ...";
$sql="SELECT * FROM catprod WHERE descripgral like '%" . $cri . "%' ORDER BY id_prod LIMIT ".$limitInf.",".$tamPag;	
	} else {
$sql="SELECT * FROM catprod WHERE `a_".$p."_".$a."`=1 and `descripgral` like '%" . $cri . "%' ORDER BY `id_prod` LIMIT ".$limitInf.",".$tamPag;
	}	
*/	
	
	// ... Reviso # de resultados con el criterio introducido ............. 	
	
	
	$result0=mysql_db_query($sql_db,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];
	$tamPag=25; 
	
    //pagina actual si no esta definida y limites 
    	if(!isset($_GET["pagina"])) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	} else { 	
			if (is_numeric($_GET["pagina"]))
				{ $pagina = $_GET["pagina"];  } else { $pagina=1; }
		} 
	
    //calculo del limite inferior 
    $limitInf=($pagina-1)*$tamPag; 
    //calculo del numero de paginas 
    $numPags=ceil($numeroRegistros/$tamPag); 
    
		if(!isset($pagina)) 
    	{ 
       		$pagina=1; 
       		$inicio=1; 
       		$final=$tamPag; 
    	}else{ 
       		$seccionActual=intval(($pagina-1)/$tamPag); 
       		$inicio=($seccionActual*$tamPag)+1; 
			if($pagina<$numPags) 
       			$final=$inicio+$tamPag-1; 
       		else 
          		$final=$numPags; 
       		
			if ($final>$numPags)
				$final=$numPags; 
	    } 
	
//echo "Citerio: $cri<br>No. $n";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function ponclave(id,clave,desc){ 
	opener.document.frm1.<?="id".$n;?>.value = id
	opener.document.frm1.<?="cl".$n;?>.value = clave 
	opener.document.frm1.<?="ds".$n;?>.value = desc
	window.close() 
} 

function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
if (codigo==27)
 	self.close();
/*if (codigo==13)
	codigo js*/
}
document.onkeypress = cerrar;

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Catalogo de Productos</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

-->
</style>
</head>

<body>
<center>
<br />
<?
if($m==Compras){
$sql="SELECT catprod.id_prod,catprod.descripgral,catprod.especificacion,prodxprov.* FROM catprod,prodxprov WHERE catprod.id_prod=prodxprov.id_prod AND prodxprov.id_prov='$p' and catprod.descripgral like '%" . $cri . "%' order by catprod.id_prod LIMIT ".$limitInf.",".$tamPag;
	}elseif($m=='Ajuste'||$m=='Dev Compras'||$m=='Ventas'||$m=='Dev venta'||$m=='Canc de Compra') {
$sql="SELECT * FROM catprod where descripgral like '%" . $cri . "%' order by id_prod LIMIT ".$limitInf.",".$tamPag;
	}elseif ($m=='Inventario Inicial'){
//echo "<br>Inventario Inicial ...";
$sql="SELECT * FROM catprod WHERE descripgral like '%" . $cri . "%' ORDER BY id_prod LIMIT ".$limitInf.",".$tamPag;	
	} else {
$sql="SELECT * FROM catprod WHERE `a_".$p."_".$a."`=1 and `descripgral` like '%" . $cri . "%' ORDER BY `id_prod` LIMIT ".$limitInf.",".$tamPag;
	}

	$result=mysql_db_query($sql_db,$sql);
	//$ndr2=mysql_num_rows();
?>
<br />
<form id="frm_buscar" name="frm_buscar" method="GET" action="<?= $_SERVER['PHP_SELF'];?>">
<div class="div_1" style="text-align:center; width:auto; ">
Resultados ( <strong> <?=$numeroRegistros;?> </strong>)
&nbsp;&nbsp;&nbsp;&nbsp;
Páginas [ <strong><?=$pagina."/".$numPags;?></strong> ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="p" value="<?=$p;?>" />
<input type="hidden" name="a" value="<?=$a;?>" />
<input type="hidden" name="m" value="<?=$m;?>" />
<input type="hidden" name="n" value="<?=$n;?>" />
<input type="text" name="txt_criterio" id="txt_buscar" value="<?=$cri;?>" />&nbsp;<input type="submit" value="Buscar" />
</div></form>
<div id="div_paginacion" class="div_1" >
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'> "; 
       	echo "<< </a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo " <a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'>";   
		echo ">></a>"; 
	}	
?>

</div>

<form id="form1" name="form1" method="post" action="">
  <table width="95%" border="0" cellspacing="1">
    <tr style="background-color:#333333; text-align:center; font-weight:bold; color:#ffffff;">
      <td colspan="5" align="center">Catálogo de Productos </td>
      </tr>
    <tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="70" align="center">Clave</td>
      <td width="740">Producto</td>
      <td width="155">Especificación</td>
      <td width="80">Existencias Totales</td>
	  <td width="104">Transferencias Totales</td>
    </tr>
    <?
	$color=="#cccccc";
	$i=1;

	while($row=mysql_fetch_array($result))
		{
		$id_producto2=$row["id_prod"];
			
			$asoc1=new asociacion_producto_almacen($id_producto2);
			//$a1->get_almacenes_asociados();
			$exist_trans=$asoc1->get_existencias(); // array(#existencias,#transferencias) ...
			//echo "<br>Existencias: (".$exist_trans[0].") Transferencias (".$exist_trans[1].")";
			
	//print_r($row);
?>
    <tr>
      <td align="center" bgcolor="<? echo $color; ?>">
        
		<a class="med" href="javascript:ponclave('<?= $row[0]; ?>','<?= $row["id_prod"]; ?>','<?= $row["descripgral"]; ?>');">
		<?=$row["id_prod"]; ?>
		</a>	  </td>
      <td align="left" bgcolor="<? echo $color; ?>"><span class="med">
        <?= $row["descripgral"]; ?>
      </span></td>
      <td align="left" bgcolor="<? echo $color; ?>"><span class="med">
        <?=$row["especificacion"]; ?>
      </span></td>
      <td align="right" bgcolor="<? echo $color; ?>"><?=$exist_trans[0]; ?>&nbsp;</td>
	  <td align="right" bgcolor="<? echo $color; ?>"><?= $exist_trans[1]; ?>&nbsp;</td>
    </tr>
    <?
  	if ($color=="#D9FFB3") $color="#ffffff";
	else $color="#D9FFB3";

	unset($asoc1);
	}
	mysql_free_result($result);
	
?>
  </table>
</form>
<br />
<div class="div_1" >Resultados ( <strong>
<?=$numeroRegistros;?>
</strong>)
&nbsp;&nbsp;&nbsp;&nbsp;
Páginas ( <strong>
<?=$pagina."/".$numPags;?>
</strong> ) 
<p>
  <?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'> "; 
       	echo "<< </a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo " <a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&n=".$n."&m=".$m."&p=".$p."&a=".$a."&txt_criterio=".$cri."'>";   
		echo ">></a>"; 
	}	
?>

</div>
<?php include("../f.php"); ?>
</center>
</body>
</html>



