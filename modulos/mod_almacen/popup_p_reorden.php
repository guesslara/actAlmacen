<?php 
include('../php/clase_mysql.php');
include('../php/conectarbase.php');
$consulta1 = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db);  //instanciar el objeto
if(!$consulta1->conectar_base_datos())	//probar la conexion al servidor
{
	echo 'Problemas al intentar conectarse a la Base de Datos.';
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function Print() {
document.body.offsetHeight;
window.print();
}
</script>
<style type="text/css">
#datosPhi td{
	font-size:12px;
	margin-left:15px;
	padding-left:3px;
	}
#datosPhi {
 	border:1px #000000 solid;
	}
#encabezado {
 	border:1px #000000 solid;
	padding-left:3px;
	}	
#datos th{
	font-size:12px;
	margin-left:15px;
	background-color: #CCCCCC;
	height:26px;
	}
#datos{
	border:1px #000000 solid;
	font-size:12px;
	}
#datos td, th{
	border-right:#000000 1px solid;
	border-bottom:#000000 1px solid;
	padding-left:3px;
	padding-right:3px;
	}		
#imp{
	margin: 0 auto;
}	 
</style>
<style type="text/css" media="print">
	#imp{ display:none;}
</style>
</head>
<body>
<table id="imp" border="0" width="900">
<tr><td colspan="6" align="center">
<input style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;" type="button" value="  Imprimir  " onclick="print();" />
</td></tr>
</table>
<br />
<table id="encabezado" width="900" align="center" border="0" cellpadding="0" cellspacing="1">
<tr><td align="center" colspan="5" style="font-size:24px;">PHILIPS</td></tr>
<tr><td align="center" colspan="5" style="font-size:15px; border-bottom:1px #000000 solid;">Service Consumer Electronics México</td></tr>
<tr align="center"><td colspan="5" style="font-size:10px;">PURCHASE ORDER FORM</td></tr>
<tr><td colspan="5" height="19"></td>
</tr>
<tr><td width="70" style="font-size:10px; padding-left:3px;">Customer P.O.</td>
	<td width="383" style="font-size:10px;">PO 08-036</td>
	<td width="82" style="font-size:10px;">Order Date</td>
	<td width="96" style="font-size:10px;" align="right">/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td width="269" style="font-size:10px;">&nbsp;</td>
</tr>
<tr>
	<td height="37" style="font-size:10px; padding-left:3px;">Mode</td>
	<td style="font-size:10px;">&nbsp;</td>
	<td style="font-size:10px;">Order to:</td>
	<td style="font-size:10px; border:1px #000000 solid;" align="center"><strong>PHILIPS HONG KONG</strong></td>
	<td style="font-size:10px;">&nbsp;</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table id="datosPhi" width="900" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#999999">
    <th width="136" align="left" style="font-size:10px; border:none; border-bottom:1px #000000 solid">SHIP TO FUNLOC</th>
    <th width="321" align="center" style="font-size:10px; border-right: #000000 1px solid; border-bottom:1px #000000 solid;">660104</th>
    <th align="left" style="font-size:10px; border-right:none;">BILL TO FUNLOC</th>
    <th width="263" align="center" style="font-size:10px;">660104</th>
  </tr>
  <tr>
    <td colspan="2" style="border-right:#000000 1px solid;">Philips Mexicana, S.A. de C.V.</td>
    <td colspan="2">Philips Mexicana, S.A. de C.V.</td>
  </tr>
  <tr> </tr>
  <tr>
    <td colspan="2" style="border-right:#000000 1px solid;">Av. de la Palma #6</td>
    <td colspan="2">Av. de la Palma #6</td>
  </tr>
  <tr> </tr>
  <tr>
    <td colspan="2" style="border-right:#000000 1px solid;">Col. San Fernando la Herradura</td>
    <td colspan="2">Col. San Fernando la Herradura</td>
  </tr>
  <tr> </tr>
  <tr>
    <td colspan="2" style="border-right:#000000 1px solid;">Huixquilucan Edo de Mexico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C.P 25784</td>
    <td colspan="2">Huixquilucan Edo de Mexico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C.P 25784</td>
  </tr>
  <tr> </tr>
  <tr>
    <td>RFC PME620620E84</td>
    <td style="border-right:#000000 1px solid;"></td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>Contact Name </td>
    <td style="border-right:#000000 1px solid;">Jorge Flavio Vazquez</td>
    <td>Contact Name </td>
    <td>Ram&oacute;n Cedr&oacute;n </td>
  </tr>
  <tr>
    <td>Phone Number </td>
    <td style="border-right:#000000 1px solid;">(5255) 5269 9087</td>
    <td width="155">Jorge Flavio Vazquez</td>
    <td width="263">(5255) 5269 9384 </td>
  </tr>
  <tr>
    <td>FAX Number </td>
    <td style="border-right:#000000 1px solid;">(5255) 5269 9090 </td>
    <td>Jorge Flavio Vazquez</td>
	<td>(5255) 5269 9090 </td>
  </tr>
</table>
<br />
<table id="datos" width="900" align="center" cellpadding="0" cellspacing="0">
<tr> 
	<th>12NC NUMBER</th><th>MODEL</th><th>QTY</th><th width="80">SALE PRICE PER 1pce</th> 
	<th width="80" align="center">TOTAL PER QTY</th><th width="200">model</th>
<?php 
if (array_key_exists('chk1', $_POST))
{
$id=array();
$total=0;
$con=1;
		$consulta2 = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db);
foreach($_POST as $ind => $valor) //examinar cada valor del array $_POST para cada fila de la tabla 
	{
		if(($valor!=='ok' && $valor!=='Enviar')) //Evitar estos valores
		{
			array_push($id,$valor);	// agregar valor al array id
		$sql="SELECT id_prod, control_alm, stock_min, exist_1, (stock_min-exist_1) as diferencia FROM catprod WHERE id_prod='$valor'";
			if(!$consulta1->consulta ($sql))
			{
				echo 'Problemas al intentar conectarse a la Base de Datos';
				exit;
			}
			$row = $consulta1->extraer_registro();
	//*******************************Consulta a la tabla prodxmov para extraer el precio unitario del producto
				$sql2="select cu from prodxmov where clave='".$row['id_prod']."'";
				if(!$consulta2->consulta ($sql2))
					{
						echo 'prodxmovProblemas al intentar conectarse a la Base de Datos';
						exit;
					}				
				$row_precio = $consulta2->extraer_registro();
				$t_unitario=$row_precio['cu']*$row['diferencia'];
				$total +=$t_unitario;
				$con+=1;
			?>
  <tr>
				<td><?php echo $row['id_prod'];?></td>
				<td><?php echo $row['control_alm'];?></td>
				<td align="center">&nbsp;<?php echo $row['diferencia'];?></td>
				<td align="center">&nbsp;<?php echo $row_precio['cu'];?></td>
				<td align="center">&nbsp;<?php echo $t_unitario;?></td>
				<td><?php echo $row['control_alm'];?></td>
  </tr>
			<?php
		
		}
	}
}
$con=$con-1;
$con=48-$con;
if ($con > 0)
{
	for($i=1; $i<=$con; $i++)
	{
		echo '<tr><td>&nbsp;</td>';
		echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><tr>';
	}
}
?>

<tr>
	<td colspan="4" align="right">
	<td align="right"><?php echo $total; ?></td>
	<td>&nbsp;</td>
</tr>
</table>
<br />
<table id="imp" border="0" width="900">
<tr>
<td colspan="3" align="left" width="420"><a href="p_reorden.php" style="color: #000000; font-size:12px; text-decoration:none">&laquo;Regresar</a></td>
<td colspan="3" align="left" width="480">
<input style="font-family: Arial, Helvetica, sans-serif; font-size: 10px;" type="button" value="  Imprimir  " onclick="print();" />
</td></tr>
</table>
</body>
</html>
