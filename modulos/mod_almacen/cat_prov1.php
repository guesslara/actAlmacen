<?php 
include("../conf/conectarbase.php");
$actual=$_SERVER['PHP_SELF'];
	
	if ($_GET['action']=='asignarok') 
	{
		$id_prod=$_GET["id_prod"];
		$id_prov=$_GET["id_prov"];
		//echo "<br>Asignar el producto ($id_prod) <br>al<br> Proveedor: ($id_prov)";
		/* ................. SQL ................. */ 
			// verificar si el prov ya ha sido aignado al producto ...
			$sql_ya_asignado="SELECT * FROM prodxprov where id_prod='$id_prod' and id_prov='$id_prov' ";
			$result7=mysql_db_query($sql_db,$sql_ya_asignado);
			//$row7=mysql_fetch_array($result0);
			$numeroRegistros7=mysql_num_rows($result7);
			mysql_free_result($result7);
				if ($numeroRegistros7>0)
				{ // si existe, enviar mensaje al usuario que el pro ya ha sido asignado ...
				$mensaje="El Producto ya esta asignado al Proveedor";
				} else {
				// Insertamos el registro en la tabla prodxprov ...
				$sql_insertar_asignacion="INSERT INTO prodxprov (id_prod,id_prov) VALUES ('$id_prod','$id_prov')";
					if (mysql_db_query($sql_db,$sql_insertar_asignacion))
					$mensaje="El producto fue asignado al proveedor correctamente";
					else
					$mensaje="Error de Sintaxis SQL: El Producto no fue asignado al Proveedor";
				}
		echo "<script language=\"javascript\" type=\"text/javascript\">
		alert(\"$mensaje\");
		self.close();
		</script>";
		exit();
	}	
	
	/*  Definicion y recepcion de variables .............................*/
	if (isset($_GET['id_prod'])) $id_prod=$_GET["id_prod"];
	if (isset($_GET['action'])) $action=$_GET["action"];
	//echo "<br>Id de Producto: $id_prod<br>Action: $action<br>";
	
	if (isset($_GET['txt_criterio']))
	{
		$cri=$_GET['txt_criterio'];
		$n=$_GET['hid_no'];
	} else { $cri=''; }
	
	// ... Reviso # de resultados con el criterio introducido ............. 
	$sql_criterio="SELECT count(id_prov) as total_registros FROM catprovee where nr like '%" . $cri . "%' ";
	$result0=mysql_db_query($dbcompras,$sql_criterio);
	$row0=mysql_fetch_array($result0);
	$numeroRegistros=$row0['total_registros'];
	mysql_free_result($result0);	

	$tamPag=500; 
	
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
	$sql="SELECT * FROM catprovee where nr like '%" . $cri . "%' order by nr "; 
	$result=mysql_db_query($dbcompras,$sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Catalogo de Proveedores</title>
<script type="text/javascript">
function preguntar(id_prov,nr,id_prod){ 
	if (confirm("¿Desea asignar el Producto: ("+id_prod+") \nal \nProveedor: "+nr+"?"))
	{
	//alert("Registrar datos");
	location.replace("<?=$actual;?>?action=asignarok&id_prod="+id_prod+"&id_prov="+id_prov+"");
	} else {
	alert("La operacion fue cancelada")
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
<title>Catalogo de Proveedores</title>
<style type="text/css">
<!--
body,document{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
A:link {text-decoration:none;color:#000000;}
A:visited {text-decoration:none;color:#000099;}
A:active {text-decoration:none;color:#000000;}
A:hover {text-decoration:none;color:#ff0000;}
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.style10 {
	font-family: Verdana, Arial, Helvetica, sans-serif;  
	font-size: 12px;
	font-weight: bold;
}
.Estilo2 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.div_1 {font-family:Arial, Helvetica, sans-serif; font-size:9pt; font-weight:normal; 
		text-align:center; width:524px; padding-top:5px; padding-bottom:5px;}
-->
</style>
</head>

<body>
<center>
<form id="frm_buscar" name="frm_buscar" method="GET" action="<?= $_SERVER['PHP_SELF'];?>" style="margin:0px;">
<div class="div_1" style="text-align:right; width:524px; ">
<input type="hidden" name="id_prod" value="<?=$id_prod;?>" />
<input type="hidden" name="action" value="<?=$action;?>" />
<input type="text" name="txt_criterio" id="txt_buscar" value="<?=$cri;?>" />&nbsp;<input type="submit" value="Buscar" />
</div></form>
<form id="form1" name="form1" method="post" action="" style="margin:0px;">
 <table width="524" border="0" cellspacing="0" style="border:#333333 2px solid;">
    <tr>
      <td colspan="2" height="20" align="center" style="text-align:center; font-weight:bold; background-color:#333333; color:#ffffff; font-size:15px;">CATÁLOGO DE PROVEEDORES ( <strong> <?=$numeroRegistros;?> </strong>)</td>
      </tr>
    <tr style="font-weight:bold; color:#000000; background-color:#CCCCCC; color:#000000;">
      <td width="61" height="20" align="center" >ID</td>
      <td width="456" >&nbsp;PROVEEDOR</td>
      </tr>
    <?
	$color=="#D9FFB3";
	$i=1;
	while($row=mysql_fetch_array($result))
		{
?>
    <tr  bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" style="cursor:pointer;">
      <td align="center" style="border-right:#CCCCCC 1px solid;">
        &nbsp;<?= $row["id_prov"]; ?>	  </td>
      <td align="left">&nbsp;
        <a href="javascript:preguntar('<?= $row["id_prov"]; ?>','<?= $row["nr"]; ?>','<?=$id_prod;?>');">
		<?= $row["nr"]; ?></a>      </td>
      </tr>
    <?
	($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
	}
	mysql_free_result($result);
?>
  </table>
</form>
<br />

<?php include("../f1.php"); ?>
<hr align="center" width="90%" />
<p style="font-size:9px; color:#999999; text-align:center;">IQelectronics International SA de CV 2008</p>

</center>
</body>
</html>
