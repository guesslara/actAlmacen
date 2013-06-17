<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);	
	include ("../conf/conectarbase.php");
	$actual=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.td1{ padding:1px; border-right:#CCCCCC 1px solid;}
</style>
<script language="javascript" src="js/asistente.js"></script>
<SCRIPT LANGUAGE="JavaScript">
var win1var; 
var n;	
<!-- 
function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400');");
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
			return false;}
		//form.submit();
	}
// -->
</script>
</head>

<body>
<?php include("../menu/menu.php"); ?><br /><br />
<center>
  <p>
</center>
<?php if (!$_GET) { ?>
<form id="form1" name="form1" method="get" action="<?=$actual;?>">
  <table width="555" border="0" align="center" cellspacing="0" style="border:#333333 2px solid;">
    <tr>
      <td colspan="3" valign="top" bgcolor="#333333"><div align="center" class="Estilo2">Criterio de Busqueda</div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#CCCCCC" class="style17">

<strong><input name="radio" type="radio" id="clave" value="id" checked="checked" />
      Id Producto </strong>	  
	  
	  </td>
      <td width="336" rowspan="6" valign="middle" bgcolor="#FFFFFF"><input name="criterio" type="text" id="criterio" size="50" /></td>
      <td width="4" rowspan="6" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td width="205" valign="top" bgcolor="#CCCCCC" class="style17">
	  <input name="radio" type="radio" id="clave" value="Id_prod" />
      Clave del Producto</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bdesc" value="descripgral" />
      Descripcion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bespecif" value="especificacion" />
      Especificacion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Blinea" value="linea" />
      Linea de prod.</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bcontrol_alm" value="control_alm" />
      Control de almacen</td>
    </tr>
	<tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="kit" id="Bkit" value="control_alm" /> Kit de Productos</td>
    </tr>
	
    <tr>
      <td colspan="3" align="right" bgcolor="#333333"><input type="submit" name="Submit" value="Buscar" />&nbsp;&nbsp;</td>
    </tr>
  </table>
</form>

  <p>&nbsp; </p>
<?php 
} 



if (isset($_GET['radio']))
{
$radio=$_GET['radio'];
if (isset($_GET['orden'])) 
		$orden=$_GET["orden"];
	else 
		$orden='id_prod';
	if (isset($_GET['criterio']))
	{
		$criterio=$_GET['criterio'];
	} else { $criterio=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id) as total_registros FROM catprod where $radio like '%" . $criterio . "%' ";
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
// .................................................
$sql="SELECT count(id_prod) AS total FROM catprod WHERE ".$radio." LIKE '%".$criterio."%' ";
				$result=mysql_db_query($sql_db,$sql);
				while ($row9=mysql_fetch_array($result))
				{
				$ndr9=$row9['total'];
				}
				//echo '<br>Radio: '.$radio.'<br>Criterio: '.$criterio.'<br>Numero de resultados: '.$ndr9;
	$sql1="SELECT * FROM catprod WHERE ".$radio." LIKE '%".$criterio."%' order by ".$orden." LIMIT ".$limitInf.",".$tamPag; 
	$result1=mysql_db_query($sql_db,$sql1);
	//echo "<br>BD [$sql_db]<br>";
	//while ($row=mysql_fetch_array($result1))
	//{
?>

<center>
<div class="buscador">
	<div class="paginas">P&aacute;ginas</div>
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$actual."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$actual."?pagina=".$i."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$actual."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '>";   
		echo "<strong> >> </strong></a>"; 
	}	
?>	
	 </div>
	
	<div class="div_resultados">
		<u>Resultados</u> (<strong> <?=$numeroRegistros;?> </strong>) P&aacute;ginas (<strong><?=$pagina."/".$numPags;?></strong>)
		&nbsp;&nbsp;<u>Ordenar por:</u></strong> 
		<?php 
//echo "<a class='small' alt='Siguiente' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&cri=".$cri."'><strong> Id</strong></a>";   

echo "&nbsp;<a alt='Ordenar por No. de Parte' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=id_prod&criterio=".$criterio."&radio=".$radio."'> No. de Parte </a>";   
echo "&nbsp;<a alt='Ordenar por Descripcion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripgral&criterio=".$criterio."&radio=".$radio."'> Descripcion </a>";   
echo "&nbsp;<a alt='Ordenar por Especificacion' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=especificacion&criterio=".$criterio."&radio=".$radio."'> Especificacion </a>";   
		?>
	</div>
	<div class="form_buscador">
		<form name="frm_buscador" action="<?=$actual;?>" method="get" style="margin:0px; padding:0px;">
		<input type="hidden" name="orden" value="<?=$orden;?>" />
		<input type="hidden" name="radio" value="<?=$radio;?>" />
		<input type="text" name="criterio" id="txt_buscar" value="<?=$criterio;?>" />&nbsp;
		<input type="submit" value="Buscar" />
		</form>
	</div>
</div>
<div align="center" style=" width:803px; padding:0px; clear:both;">

<form id="form1" name="form1" method="post" action="">
  <table width="802" border="0" align="center" cellspacing="0" style="border:#333333 2px solid;">
    <tr>
      <td colspan="6" height="20" bgcolor="#333333" class="style6"><div align="center"><span class="Estilo4"><?=$numeroRegistros;?> Datos encontrados en el Cat&aacute;logo de Productos  </span></div></td>
    </tr>
    <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
      <td width="46" bgcolor="#CCCCCC" class="style17">Id</td>
      <td width="102" bgcolor="#CCCCCC" class="style17">Clave del Producto </td>
      <td width="292" bgcolor="#CCCCCC" class="style17">Descripci&oacute;n</td>
      <td width="91" bgcolor="#CCCCCC" class="style17" align="left">Especificaci&oacute;n</td>
      <td width="86" bgcolor="#CCCCCC" class="style17">L&iacute;nea</td>
      <td width="166" bgcolor="#CCCCCC" class="style17">Asociar</td>
    </tr>
    <?
		$color=="#D9FFB3";
		$i=1;
		$inferior=1;
		while($row=mysql_fetch_array($result1)){
		//print_r($row);
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>" class="td1"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
 <?= $row["id"]; ?>
      </font>
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?= $row['id'];?>" />
      </div></td>
      <td bgcolor="<? echo $color; ?>" class="td1" align="center">
          <?= $row["id_prod"]; ?>
   </td>
      <td bgcolor="<? echo $color; ?>" class="td1" align="left">
          <?= $row["descripgral"]; ?>
      </td>
      <td bgcolor="<? echo $color; ?>" class="td1" align="left">
        <?= $row["especificacion"]; ?>
      </td>
      <td bgcolor="<? echo $color; ?>" class="td1">
          <?= $row["linea"]; ?>
  	  </td>
      <td bgcolor="<? echo $color; ?>">
      		<div align="center">
            	<font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
                	<a href="javascript:popUp('fichaprod.php?id=<?=$row["id"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=2";?>')">ver</a> | 
	  				<a href="javascript:popUp('cat_prov1.php?id_prod=<?=$row["id_prod"];?>&action=asignar_a_proveedor')">proveedor</a> |					
					<a href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a>
				</font>
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
  </table>
</form>
</div>
<br>

<div class="buscador">
	<div class="paginador"> 
<?php 
	// ...... Codigo de la Paginacion ..................................... 
	if($pagina>1) 
	{ 
    	echo "<a alt='Anterior' href='".$actual."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '> "; 
       	echo "<strong> << </strong></a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
		if($i==$pagina) 
       	{ 
       		echo "<strong><font color='#ff0000'> [".$i."] </font></strong>"; 
       	} else { 
        	echo "<a class='' href='".$actual."?pagina=".$i."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '>"; 
          	echo $i."&nbsp;</a> "; 
	   	} 
    } 
    if($pagina<$numPags) 
  	{
		echo "<a class='small' alt='Siguiente' href='".$actual."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$criterio."&radio=".$radio." '>";   
		echo "<strong> >> </strong></a>"; 
	}	

?>	
    </div>
	<div class="paginas">P&aacute;ginas</div>
</div>
</center>	

<?php } 
include("../f.php");
?>
</body>
</html>