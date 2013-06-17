<?php 
include('../conf/clase_mysql.php');
include('../conf/conectarbase.php');
$consulta1 = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db); //instanciar el objeto
if(!$consulta1->conectar_base_datos())	//probar la conexion al servidor
{
	echo 'Problemas al intentar conectarse a la Base de Datos.';
	exit;
}
////////////*************************Paginador*********************
//Crea el Indice de la Pagina Actual
if(!isset($_GET['pag'])){
	$pag=1;
}else{
	$pag=$_GET['pag'];
}
$hasta=20;	
/*
es aqui donde se indicara la primera posision del cursor para
recoger lso datos en la base de datos
*/
$desde=($hasta*$pag)-$hasta;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reorden</title>
<link href='../css/style.css' rel='stylesheet' type='text/css' media='screen' />
<style>
#tbl_principal {
	clear:both;
	border-right:#000000 1px solid;
border-left:#000000 1px solid;
border-bottom:#000000 1px solid;
	}
#margen_tbl{
	clear:both;
	padding:0;
	}
#margen_tbl table td{
	padding-left:3px;
	font-size:11px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	border-left:#ccc 1px solid;
	color:#000000;
	}
#margen_tbl table th{
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	background-color:#000000;
	}	
#centra_nav{
	margin: 0 auto;
	width:145px;
	font-size:11px;
	}
	
#exp_excel a{
	color: #000000;
	margin-left:2px;
	}	
#exp_excel a:hover{
	color: #0000CC;
	margin-left:2px;
	}
#contenedor{
	margin: 0 auto;
	width:890px;
	height:32px;
	color:#FFFFFF;
	font-size:12px;
}		
#exp_excel{
	float: left;
	padding-top:8px;
	width:130px;
	color:#000000;
			
	}
#paginador{
	float: left;
	width:270px;
	height:30px;
	}	
#paginador_down{
	float:left;
	width:280px;
	padding-top:8px;
	height:30px;
	color:#000000;
}	
#buscar{
	float: left;
	font-size:10px;
	padding-top:5px;
	width:390px;
	height:25px;
	color:#000000;
}
FORM {
clear: none;
float: none;
border-style: none;

margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;
} 
.color1{
	background-color:#FFFFFF;
}
.color2{
	background-color: #D9FFB3;
}
</style>
<style type="text/css" media="print">
#centra_nav, #exp_excel{
	display:none;
	}	
#frm1{
	display:none;
	font-size:12px;
	}	
#tbl_principal td{
	border:#000000 solid 1px;
	font-size:6px;
	}	
#buscar	{
	display:none;
	}	
#paginador{
	display:none;
	}
</style>
<script language="javascript">
function carga()
{
	var ok1=document.getElementById('ok').style;
	var delete1=document.getElementById('delete').style;
	delete1.display = "none";
	ok1.display = "block";
	primero()
}
function primero(){
	document.getElementById("primero").focus();
}	
function seleccionar_checkbox(chk){
	var ok1=document.getElementById('ok').style;
	var delete1=document.getElementById('delete').style;
	if(!chk)
	{
	delete1.display = "none";
	ok1.display = "block";
	for (i=0;i<document.f1.elements.length;i++)
		{
			if(document.f1.elements[i].type == "checkbox")
				document.f1.elements[i].checked=false
		}
	}
	else
	{
	delete1.display = "block";
	ok1.display = "none";
	for (i=0;i<document.f1.elements.length;i++)
		{
			if(document.f1.elements[i].type == "checkbox")
				document.f1.elements[i].checked=true
		}
	}	
} 
function resalta(objeto){         //cambia color a la fila al pasar el mouse
	objeto.style.background='#cccccc';
}
function regresa(color,objeto){		//Regresa el color de la fila a su estado original
	if(color=='color2')
		objeto.style.background='#D9FFB3';
	if(color=='color1')	
		objeto.style.background='#FFFFFF';
}
function selecciona(id){
	var chk='chk_'+id;
	for (i=0;i<document.f1.elements.length;i++)
	{
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].name==chk)
			if(document.f1.elements[i].checked==0)
				document.f1.elements[i].checked=true
			else	
				document.f1.elements[i].checked=false	
	}
}
</script>
</head>

<body onload="carga();">
<?php include("../menu/menusjq.php"); ?><br />
<?php 
if ($_POST['criterio']=="")
{ 
	$sql="SELECT id, id_prod, descripgral,especificacion, stock_min, exist_1, (stock_min-exist_1) as diferencia,unidad "
		."FROM catprod WHERE exist_1 < stock_min LIMIT $desde, $hasta"; 
	if(!$consulta1->consulta ($sql))
	{
		echo 'Problemas al intentar conectarse a la Base de Datos';
		exit;
}	
}
else	
{
	$campo=trim($_POST['opt_criterio']);
	$_POST['criterio']=trim($_POST['criterio']);
	$criterio=" $campo like '%".$_POST['criterio']."%' and ";
	$sql="SELECT id, id_prod, descripgral, stock_min, exist_1, (stock_min-exist_1) as diferencia,unidad "
		."FROM catprod WHERE $criterio exist_1 < stock_min"; 
	
	if(!$consulta1->consulta ($sql))
	{
		echo 'Problemas al intentar conectarse a la Base de Datos';
		exit;
	}
	$hasta=$consulta1->n_registros();
}

?>
<div id="contenedor"> <!--Capa que muestra las opcion de exportar a excel, paginador y busquda-->
<div id="exp_excel" align="right">
       <!--Exportar:<a href="imp_reorden.php<?php echo "?sql=".urlencode($sql); ?>" ><img src="../img/excel.png" border="0" /></a>//-->
</div>
	
<?php
///////////////////////////////////////Paginador

if($_POST['criterio']==""){
echo "<div id='paginador'>";
$consulta2 = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db); //instanciar el objeto
if(!$consulta2->conectar_base_datos())	//probar la conexion al servidor
{
	echo 'Problemas al intentar conectarse a la Base de Datos.';
	exit;
}
 
 $sql2="SELECT id, id_prod, descripgral,especificacion, stock_min, exist_1, (stock_min-existencias) as diferencia,unidad "
	."FROM catprod WHERE exist_1 < stock_min"; 
if(!$consulta2->consulta ($sql2))
{
	echo 'Problemas al intentar conectarse a la Base de Datos';
	exit;
}
$r2 = $consulta2->n_registros();
$paginas=ceil($r2/$hasta);
	echo "<div id='paginador_down' align='center' style='font-size:x-small; font-weight:bold; '>";
	echo "P&aacute;ginas (".$pag."/".$paginas.")&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if($pag>1){
	//echo "<a href=\"p_reorden.php?pag=1\"><img src='../img/primero.png' border='0'/></a> ";
	echo "<a href=\"p_reorden.php?pag=1\" title='Primera Pagina '>&nbsp; |< &nbsp;</a> ";
	//echo "<a href=\"p_reorden.php?pag=".($pag-1)."\"><img src='../img/atraz.png' border='0'/></a> | ";
	echo "<a href=\"p_reorden.php?pag=".($pag-1)."\" title='Pagina Anterior'>&nbsp; < &nbsp;</a>";
	}
	
	//echo "<a href=\"p_reorden.php\"><img src='../img/inicio.png' border='0'/></a> | ";
echo "<a href=\"p_reorden.php\" title='Pagina de Inicio'>&nbsp; Inicio &nbsp; </a> ";
if($pag<$paginas){
	//echo "<a href=\"p_reorden.php?pag=".($pag+1)."\"><img src='../img/adelante.png' border='0'/></a> "; 
	echo "<a href=\"p_reorden.php?pag=".($pag+1)."\" title='Siguiente pagina'> &nbsp; &gt; &nbsp; </a> ";
	//echo "<a href=\"p_reorden.php?pag=".($paginas)."\"><img src='../img/ultimo.png' border='0'/></a>";
	echo "<a href=\"p_reorden.php?pag=".($paginas)."\" title='Ultima pagina'> &nbsp; &gt; | &nbsp; </a>";
}	
	echo "</div>";
echo '</div>';	
}
?>
	
	<div id="buscar" align="left">
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<input type="hidden" name="buscar" value="buscar" />
       <label>
	<input type="radio" name="opt_criterio" 
	<?php if(isset($campo) && $campo=='descripgral') echo "checked='checked'";?> 
	<?php if($_POST['criterio']=="") echo "checked='checked'";?>  value="descripgral" onblur="primero();"/>		
     Descripci&oacute;n
    </label>
		<label>
		<input type="radio" name="opt_criterio" 
		<?php if(isset($campo) && $campo=='id') echo "checked='checked'";?> value="id" />ID Producto
		</label>
		

		<input type="text" name="criterio" id="primero" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;" value="<?php if(isset($_POST['criterio'])) echo $_POST['criterio'];?>"/>

		<input type="submit" value="Buscar" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;" />

	</form>

	</div>

</div>

<center> 

<div id="margen_tbl">

<form name="f1" method="post" action="popup_p_reorden.php">

	<input type="hidden" name="chk1" value="ok"  />

<table id="tbl_principal" align="center"" border="0" cellpadding="2" cellspacing="0" style="margin-top:20px;"> 

<tr bgcolor="#333333" style="color:#FFFFFF;">

	<th colspan="11" align="center" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:#000000 solid 1px;">Puntos de Reorden</th>
</tr>

<tr bgcolor="#CCCCCC" style=" background-color:#ccc; text-align:center; font-weight:bold; ">

 <td style="font:bold; font-size:14px;" width="26" align="center" height="22">

 <a href="javascript:seleccionar_checkbox(1);" id="ok"><img src="../img/ok.png" border="0" /></a>

 <a href="javascript:seleccionar_checkbox(0);" id="delete" style="display:none;"><img src="../img/delete.png" border="0" /></a> </td>

 <td width="47" style="font:bold; font-size:11px; ">ID</td>

 <td width="116" style="font:bold; font-size:11px; ">Clave</td>
 <td width="424" style="font:bold; font-size:11px; ">Descripci&oacute;n</td>

 <td width="179" align="center" style="font:bold; font-size:11px;">Especificaci&oacute;n</td>

 <td width="77" align="center" style="font:bold; font-size:11px;">Stock M&iacute;nimo</td>

	<td width="76" align="center" style="font:bold; font-size:11px;">Existencias</td>

	<td width="75" align="center" style="font:bold; font-size:11px;">Diferencia</td>
	
</tr>	

<?php

$color='color1';

while ($row1 = $consulta1->extraer_registro() ) {

//while($row1=mysql_fetch_array($resultado)){

	($color=='color2') ? $color='color1' : $color='color2';

	?>

	<tr id="<?php echo $row1['id_prod'] ?>" align='left' <?= "class='$color' onmouseover='resalta(this)'  onmouseout=\"regresa('$color',this)\" onclick=\"selecciona('".$row1['id_prod']."')\" "?>>

	<td align="center">

	<input type="checkbox" name="chk_<?php echo $row1['id_prod'] ?>" value="<?php echo $row1['id_prod'] ?>" onclick="selecciona('<?php echo $row1['id_prod'] ?>')"/>	</td>

	<?php 

	echo "<td align='center'>".$row1['id']."</td>"; 
	echo "<td>".$row1['id_prod'].'</td>'; 

	echo "<td align='left'>".$row1["descripgral"].'</td>'; 
	
	echo "<td align='left'>".$row1["especificacion"].'</td>'; 
	
	echo "<td align='right'>".$row1["stock_min"].' '.$row1["unidad"].'</td>';
	
	echo "<td align='right'>".$row1["exist_1"].'</td>';

	echo "<td align='right'>".$row1["diferencia"].' '.$row1["unidad"].'</td>';
	
	echo '</tr>';
	
}

?>	
<!--
<td id="frm1" colspan="8" align="right" bgcolor="#CCCCCC" style="border-bottom:#000000 1px solid;">
	<input type="submit" name="Submit" value="Enviar" style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;"></td>
</tr>
//-->	
</table>

</form>

</div>

</center>
</body>
</html>