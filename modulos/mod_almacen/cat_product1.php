<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);	
	include ("../conf/conectarbase.php");

$actual=$_SERVER['PHP_SELF'];
$lista_campos=" `id`,`id_prod`, `descripgral`, `especificacion`, `control_alm`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `unidad`, `stock_min`, `linea`, `marca` ";	

	if (isset($_GET['orden'])) 
		$orden=$_GET["orden"];
	else 
		$orden='id';
	if (isset($_GET['cri']))
	{
		$cri=$_GET['cri'];
		$orden=$_GET['orden'];
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id) as total_registros FROM catprod where descripgral like '%" . $cri . "%' ";
	$result0=mysql_db_query($sql_db,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];

	$tamPag=30; 
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/asistente.js"></script>
<SCRIPT LANGUAGE="JavaScript">
var win1var; 
var n;	
<!-- 
function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,width=650,height=450');");
	}
function verificaOS(form){
	var numorder=form.numorder.value;
	if(numorder==""){
		alert("No hay un numero de orden a para ver");
		return false;
	}
	else{
		alert(numorder);
	}
}
function validar(form)
	{
		var numorder=form.numorder.value;
    	var fecha=form.fecha.value;
    	if (numorder=="" ){				//Fecha
			alert("falta Numero de Orden");
			form.numorder.focus();
			return false;}
		if (fecha==""){				//fecha
			alert("Falta fecha de Orden de Servicio");
			return false;} 	//form.submit();
	}
// -->
</script>
</head>
<body>
<?php include('../menu/menu.php'); ?><br />
<center>
<p>
<center>
<div class="buscador">
	<div class="paginas">P&aacute;ginas</div>
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cri=".$cri."'> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cri=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'>";   
		echo "<strong> >> </strong></a>"; 
	}	

// sentencia SQL ...
	$sql="SELECT $lista_campos FROM catprod where descripgral like '%" . $cri . "%' order by ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
	$result=mysql_db_query($sql_db,$sql);
?>	
	 </div>
	
	<div class="div_resultados" style="font-size:12px;">
		<u>Resultados</u> (<strong> <?=$numeroRegistros;?> </strong>) P&aacute;ginas (<strong><?=$pagina."/".$numPags;?></strong>)
		&nbsp;&nbsp;<u>Ordenar por:</u></strong> 
		<?php 
//echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'><strong> Id</strong></a>";   

echo "&nbsp;<a alt='Ordenar por Clave del Producto' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=id_prod&cri=".$cri."'> Clave del Producto </a>";   
echo "&nbsp;<a alt='Ordenar por Descripcion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripgral&cri=".$cri."'> Descripci&oacute;n </a>";   
echo "&nbsp;<a alt='Ordenar por Especificacion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=especificacion&cri=".$cri."'> Especificaci&oacute;n </a>";   
		?>
	</div>
	<div class="form_buscador">
		<form name="frm_buscador" action="<?=$_SERVER['PHP_SELF'];?>" method="get" style="margin:0px; padding:0px;">
		<input type="hidden" name="orden" value="<?=$orden;?>" />
		<input type="text" name="cri" id="txt_buscar" value="<?=$cri;?>" />&nbsp;
		<input type="submit" value="Buscar" />
		</form>
	</div>
</div>
<div align="center" style=" width:803px; padding:0px; clear:both;">
<table width="800" border="0" align="center" cellspacing="0" style="border:#333333 2px solid;">
    <tr>
      <td colspan="6" class="t0" height="20">Productos en Almac&eacute;n: <?=$nalm0; ?></td>
    </tr>
    <tr>
      <td width="37" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Id</strong></div></td>
      <td width="89" bgcolor="#CCCCCC" class="style17"><div align="center">Clave del Producto</div></td>
      <td width="283" bgcolor="#CCCCCC" class="style17"><strong>Descripci&oacute;n</strong></td>
      <td width="177" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Especificaci&oacute;n</strong></div></td>
      <td width="33" bgcolor="#CCCCCC" class="style17"><div align="center">L&iacute;nea</div></td>
      <td width="165" bgcolor="#CCCCCC" class="style17"><div align="center">Asociar</div></td>
    </tr>
<?
			$color=="#D9FFB3";
			$i=1;
			$inferior=1;
			while($row=mysql_fetch_array($result)){
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>" class="td1"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
<?
		echo $row["id"]; //."--".$row[0];
		
?>			</font></div></td>
      <td bgcolor="<? echo $color; ?>" class="td1"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["id_prod"]; ?></font></div></td>
      <td bgcolor="<? echo $color; ?>" class="td1"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        &nbsp;<?= $row["descripgral"]; ?></font> </div></td>
      <td align="left" bgcolor="<? echo $color; ?>" class="td1"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        &nbsp;<?= $row["especificacion"]; ?></font></td>
      <td bgcolor="<? echo $color; ?>" class="td1"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        &nbsp;<?= $row["linea"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>">
<div style="font-size:12px; text-align:center">
<a class="small" href="javascript:popUp('fichaprod.php?id=<?=$row["id"];?>')">ver</a> | 
<a class="small" href="javascript:popUp('cat_prov1.php?id_prod=<?=$row["id_prod"];?>&action=asignar_a_proveedor')">proveedor</a> |
<a class="small" href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a>
</div>
</td>
    </tr>
<?
				if ($color=="#D9FFB3") 
					$color="#FFFFFF";
				else 
					$color="#D9FFB3";
					$i=$i+1;
			}	
?>
  </table></div>
<br>

<div class="buscador">
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&cri=".$cri."'> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&cri=".$cri."'>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'>";   
		echo "<strong> >> </strong></a>"; 
	}	
?>	
    </div>
	<div class="paginas">P&aacute;ginas</div>
</div>
</center>	
  
<?php include('../f.php'); ?>
</body>
</html>