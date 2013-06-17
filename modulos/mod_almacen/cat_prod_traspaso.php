<?php 
include("../php/conectarbase.php");
//include("../php/config.inc.php");
$actual=$_SERVER['PHP_SELF'];

if (isset($_GET['id_almacen'])) $id_almacen=$_GET["id_almacen"];
if (isset($_GET['almacen'])) $almacen=$_GET["almacen"];
if (isset($_GET['id_asociado'])) $id_asociado=$_GET["id_asociado"];
if (isset($_GET['asociado'])) $asociado=$_GET["asociado"];

if (isset($_GET['n'])) $n=$_GET["n"];
$n_almacen="a_".$id_almacen."_".$almacen;
$c_existencias="exist_".$id_almacen;
$c_transferencias="trans_".$id_almacen;


$n_almacen2="a_".$id_asociado."_".$asociado;
$c_existencias2="exist_".$id_asociado;
$c_transferencias2="trans_".$id_asociado;



//if (isset($_GET['n_almacen'])) $n_almacen=$_GET["n_almacen"];
//echo "<br>Id: $id_almacen <br>Almacen: $almacen <br>n [$n] <br>Campo Almacen: ($n_almacen)<br>";	
	
	if (isset($_GET['txt_criterio']))
	{
		$cri=$_GET['txt_criterio'];
		$n=$_GET['n'];
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(`id`) as total_registros FROM catprod where `$n_almacen2`='1' and `descripgral` like '%" . $cri . "%' ";
	$result0=mysql_db_query($sql_db,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];
	//mysql_free_result($result0);	
//$result=mysql_db_query($dbAlmacen,$sql);


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
function seleccionar(id_prod,dg){ 
	opener.document.frm1.cl1.value=id_prod;
	opener.document.frm1.ds1.value=dg;	
	self.close();
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
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
/*A:link {text-decoration:none;color:#000000;}
A:visited {text-decoration:none;color:#000099;}
A:active {text-decoration:none;color:#000000;}
A:hover {text-decoration:none;color:#ff0000;}*/
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.style10 {
	font-family: Verdana, Arial, Helvetica, sans-serif;  
	font-size: 12px;
	font-weight: bold;
}
.letra1 { font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color:#000000; }
.div_1 {font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:normal; 
		text-align:center; width:524px; padding-top:5px; padding-bottom:5px;}
.style91 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
-->
</style>
</head>

<body>
<?php //print_r($_GET); ?>
<center>
<?

	//$sql="SELECT * FROM catprod where descripgral like '%".$crit."%' order by id_prod ";
	//$sql2="SELECT * FROM archivos ".$criterio." ORDER BY ".$orden." $ordenad  LIMIT ".$limitInf.",".$tamPag; 
	$sql="SELECT * FROM catprod where `$n_almacen2`='1' and `descripgral` like '%" . $cri . "%' order by `id_prod` LIMIT ".$limitInf.",".$tamPag; 
	$result=mysql_db_query($sql_db,$sql);
?>
<br />
<form id="frm_buscar" name="frm_buscar" method="GET" action="<?= $_SERVER['PHP_SELF'];?>">
<div class="div_1" style="text-align:right; width:98%;">
Resultados ( <strong> <?=$numeroRegistros;?> </strong>)
&nbsp;&nbsp;&nbsp;&nbsp;
Páginas [ <strong><?=$pagina."/".$numPags;?></strong> ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="id_almacen" value="<?=$id_almacen;?>" />
<input type="hidden" name="almacen" value="<?=$almacen;?>" />
<input type="hidden" name="n" value="<?=$n;?>" />
<input type="text" name="txt_criterio" id="txt_buscar" value="<?=$cri;?>" />&nbsp;<input type="submit" value="Buscar" />
</div></form>
<?php if ($numeroRegistros>$tamPag) {?>
<div id="div_paginacion" class="div_1" >
<?php 
	// ...... Codigo de la Paginacion ..................................... 

	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'> "; 
       	echo "<< </a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo " <a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'>";   
		echo ">></a>"; 
	}	
?>

</div>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
  <table width="98%" border="0" cellspacing="1" align="center">
    <tr style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold; padding:1px;">
      <td colspan="6">Productos asociados al almacen: <?=$asociado;?></td>
      </tr>
    <tr style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold; padding:1px;">
      <td width="121" rowspan="2" style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">Clave</td>
      <td width="325" rowspan="2" style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">Producto</td>
      <td colspan="2">Almacen: <?=$almacen;?></td>
      <td colspan="2">Almacen: <?=$asociado;?></td>
    </tr>
    <tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
      <td width="105" >EXIST.</td>
	  <td width="128">TRANS.</td>
	  <td width="99">EXIST.</td>
      <td width="104">TRANS. </td>
    </tr>
    <?
	$color=="#cccccc";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
      <td align="center" bgcolor="<? echo $color; ?>">
        <a class="med" href="javascript:seleccionar('<?= $row["id_prod"]; ?>','<?= $row["descripgral"]; ?>');">
		<?= $row["id_prod"]; ?>
		</a>	  </td>
      <td bgcolor="<? echo $color; ?>" class="med"><?= $row["descripgral"]; ?></td>
      <td bgcolor="<? echo $color; ?>" class="med" align="center"><?= $row[$c_existencias]; ?></td>
	  <td bgcolor="<? echo $color; ?>" class="med" align="center"><?= $row[$c_transferencias]; ?></td>
	  <td bgcolor="<? echo $color; ?>" class="med" align="center"><?= $row[$c_existencias2]; ?></td>
      <td bgcolor="<? echo $color; ?>" class="med" align="center"><?= $row[$c_transferencias2]; ?></td>
    </tr>
    <?
  	if ($color=="#D9FFB3") $color="#ffffff";
	else $color="#D9FFB3";
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
if ($numeroRegistros>$tamPag) {
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'> "; 
       	echo "<< </a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo " <a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&n=".$n."&id_almacen=".$id_almacen."&almacen=".$almacen."&txt_criterio=".$cri."'>";   
		echo ">></a>"; 
	}	
}
?>

</div>
<br>
<hr />
<p align="center" class="Estilo1">IQelectronics SA de CV</p>

</center>
</body>
</html>