<?php 
include("../conf/conectarbase.php");
$actual=$_SERVER['PHP_SELF'];
	// ------------------------------------- investigando nombre de los campos ...
	$sistema_actual='General';
	$n=0;
		while ($n<=100)
		{
		$campo="a_".$n."_".$sistema_actual; 
		$qry=mysql_db_query($sql_db,"select * from catprod"); 
		$campos = mysql_num_fields($qry); 
		$i=0; 
			while($i<$campos){ 
				if($campo==mysql_field_name ($qry, $i)){
					$existe=true;				
					$campo_almacen_actual=$campo;
					$numero_actual=$n;
					break;
				} else {
					$existe=false;
				}
			$i++; 
			} //echo ' X';
		++$n;
		} // -----------------------------------------------
		if ($campo_almacen_actual=='')
		{
			echo '<br>No se encontro coincidencia entre la ruta actual y algun almacen.<br> (La Pagina actual no se funcionara correctamente.)'; 
			exit();
		} else {		
			$campo_existencias_actual='exist_'.$numero_actual;
			$campo_transferencias_actual='trans_'.$numero_actual;
			//echo 'Self: '.$actual.'<br>Sistema es: ('.$sistema_actual.')<br>Campo almacen: '.$campo_almacen_actual.'<br>Numero Actual: '.$numero_actual.'<br>Existencias Actual: '.$campo_existencias_actual.'<br>Transferencias Actual: '.$campo_transferencias_actual;
			$resultado=true;
		} 
	// -------------------------------------------------------------------------



//if (isset($_GET['id_almacen'])) $id_almacen=$_GET["id_almacen"];
//if (isset($_GET['almacen'])) $almacen=$_GET["almacen"];
//if (isset($_GET['n'])) $n=$_GET["n"];
//$n_almacen="a_".$id_almacen."_".$almacen;
//$c_existencias="exist_".$id_almacen;
//$c_transferencias="trans_".$id_almacen;

//if (isset($_GET['n_almacen'])) $n_almacen=$_GET["n_almacen"];
//echo "<br>Id: $id_almacen <br>Almacen: $almacen <br>n [$n] <br>Campo Almacen: ($n_almacen)<br>";	
	
	if (isset($_GET['txt_criterio']))
	{
		$cri=$_GET['txt_criterio'];
		$n=$_GET['n'];
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id) as total_registros FROM catprod where $campo_almacen_actual='1' and descripgral like '%" . $cri . "%' ";
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
function seleccionar(id_prod,cont){ 
	var cantidad=document.getElementById("cantidad_kit_"+cont).value;
	var vanterior=opener.document.form1.kit_array.value;

	// Algoritmo :
	// 		a) Comprobar si esta vacio v anterior (si=agregar al kit) (NO=split y agrega...)
	//		b) 
	if (vanterior=='')
	{
	//alert('Tex es _, agregar al kit');
	agregar_al_kit(id_prod,cantidad,vanterior);
	self.close();
	} else {
	 	if (comparar_existe_kit(id_prod,vanterior)==true)
	 	{
	 	alert('Error: El producto ya esta agregado al Kit');
	 	self.close();
	 	} else {
	 	//alert('No existe en el kit, (Agregar)');
		agregar_al_kit(id_prod,cantidad,vanterior);
		self.close();
		}
	
	}
} 

	function comparar_existe_kit(id,kit)
	{
		//alert('Kit: '+kit);
		var clave = kit.split(",");
		var long=clave.length;
		//alert('Clave'+clave+'\nLongitud del split: '+long);	
			for (var i=0;i<long;i++)
			{
				var mivalor=clave[i];
				//alert('Valor actual: '+mivalor);
				var caracter = '(';
				var posicion=mivalor.indexOf(caracter);
					
						var pri_car=mivalor.substring(0,posicion);
						
						var c_sin_sdl=pri_car.replace("\r\n","");
						var c_sin_sdl=pri_car.replace("\n","");
						 
						//alert('Kit: '+kit+'\nId buscado: '+id+'\nValor sin p('+c_sin_sdl+')');
						
						if (c_sin_sdl==id) // si la clave ya esta agregada al kit ... 
						{
							//alert("Valor: "+pri_car+"\nError: El producto ya esta agregado al kit");
							return true;
							//self.close();
						} else {
							//return false;
						//agregar_al_kit(id_prod,cantidad))
						}
			}
	}

	
	
	function agregar_al_kit(id,cantidad,vanterior)
	{
		if (isNaN(cantidad))
		{
			alert('Error: El campo Cantidad contiene un valor que no es numero');
			return false;
		} else if (cantidad=='') {
			alert('Error: El campo Cantidad esta vacio');
			return false;
		} else {
			if (vanterior=='')
			{	
				opener.document.form1.kit_array.value=id+"("+cantidad+")";
				return true;
			} else {
				opener.document.form1.kit_array.value=vanterior+",\n"+id+"("+cantidad+")";
				return true;
			}
		}
	}

function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
if (codigo==27)
 	self.close();
}
document.onkeypress = cerrar;
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Catalogo de Productos</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
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
	font-weight: bold; text-align:center;
}
.Estilo2 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; color:#000000; }
.div_1 {font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:normal; 
		text-align:center; width:524px; padding-top:5px; padding-bottom:5px;}
-->
</style>
</head>

<body>
<center>
<p class="style10">Catálogo de Productos:</p>
Almacen: <u><?=$sistema_actual;?></u> <br />
<?
	$sql="SELECT * FROM catprod where $campo_almacen_actual='1' and descripgral like '%" . $cri . "%' order by id LIMIT ".$limitInf.",".$tamPag; 
	$result=mysql_db_query($sql_db,$sql);
?>
<br />
<form id="frm_buscar" name="frm_buscar" method="GET" action="<?= $_SERVER['PHP_SELF'];?>">
<div class="div_1" style="text-align:right; width:524px; ">
Resultados ( <strong> <?=$numeroRegistros;?> </strong>)
&nbsp;&nbsp;&nbsp;&nbsp;
Páginas [ <strong><?=$pagina."/".$numPags;?></strong> ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="id_almacen" value="<?=$id_almacen;?>" />
<input type="hidden" name="almacen" value="<?=$almacen;?>" />
<input type="hidden" name="n" value="<?=$n;?>" />
<input type="text" name="txt_criterio" id="txt_buscar" value="<?=$cri;?>" />&nbsp;<input type="submit" value="Buscar" />
</div></form>
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
$cont=1;
?>

</div>

<form id="form1" name="form1" method="post" action="">
  <table width="524" border="0" cellspacing="1">
    <tr>
      <td width="46" bgcolor="#333333" align="center"><span class="style9">Clave</span></td>
      <td width="261" bgcolor="#333333"><span class="style9">Producto</span></td>
      <td width="88" bgcolor="#333333"><span class="style9">Especificación</span></td>
	  <td width="116" bgcolor="#333333" align="center"><span class="style9">Cantidad</span></td>
    </tr>
    <?
	$color=="#cccccc";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr>
      <td align="center" bgcolor="<? echo $color; ?>">
        <a class="Estilo2" href="javascript:seleccionar('<?= $row["id_prod"]; ?>','<?= $cont; ?>');">
		<?= $row["id_prod"]; ?>
		</a>
	  </td>
      <td bgcolor="<? echo $color; ?>" align="left"><span class="Estilo2">
        <?= $row["descripgral"]; ?>
      </span></td>
      <td bgcolor="<? echo $color; ?>" align="left"><span class="Estilo2">
        <?= $row['especificacion']; ?>
      </span></td>
	  <td align="center" bgcolor="<? echo $color; ?>">
	  		<span class="Estilo2"><input type="text" name="cantidad_kit_<? echo $cont; ?>" id="cantidad_kit_<? echo $cont; ?>" size="5" value="1" maxlength="4" />
			</span>
	  </td>
    </tr>
    <?
	if ($color=="#cccccc") 
		$color="#FFFFFF";
	else 
		$color="#cccccc";
	++$cont;
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
include("../f.php");
?>

</div>
</center>

</body>
</html>
