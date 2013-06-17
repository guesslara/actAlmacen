<? 
//echo "Pagina en mantenimeinto.";	exit();
include("../conf/conectarbase.php");
$id_almacen=$_GET["id_almacen"];
$c_eX="exist_".$id_almacen;
$c_tX="trans_".$id_almacen;

$lista_campos=" id,id_prod,descripgral,especificacion,linea,marca,control_alm,ubicacion,uni_entrada,uni_salida,stock_min,stock_max,observa,unidad,status1,cpromedio,$c_eX,$c_tX ";

$fecha = date('m-d-Y');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=CATALOGO_DE_PRODUCTOS_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET["sql"]))
{
//str_replace("%","iqesisco",$where1);
//echo "<br>".
$sql="SELECT $lista_campos FROM catprod ".str_replace("iqesisco","%",$_GET["sql"]);
$sql=stripslashes($sql);
	$result=mysql_db_query($sql_db,$sql);
//echo "<br>$sql";

} 
//exit();
?>
<style type="text/css">
body { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
.tabla{ border:#333333 2px solid;}
.tit{ background-color:#333333; color:#FFFFFF; font-size:18px; text-align:center;}
.campos{ background-color:#cccccc; color:#000000; font-size:12px; text-align:center; font-weight:bold;}
.td1{ border-top:#cccccc 1px solid; border-right:#cccccc 1px solid; padding:1px;}
</style>
<br>
<table width="auto" class="tabla" align="center" cellpadding="0" cellspacing="0">
<tr>
  <TD colspan="20" class="tit" >&nbsp;CAT&Aacute;LOGO DE PRODUCTOS </TD>
  </tr>
<tr>
<TD height="25" ALIGN=CENTER class="campos">ID</TD>
<TD ALIGN=CENTER class="campos">CLAVE DEL PRODUCTO </TD>
<TD ALIGN=CENTER class="campos">DESCRIPCI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">ESPECIFICACI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">L&Iacute;NEA</TD>
<TD ALIGN=CENTER class="campos">MARCA</TD>
<TD ALIGN=CENTER class="campos">CONTROL DE ALMACEN </TD>
<TD ALIGN=CENTER class="campos">UBICACI&Oacute;N</TD>
<TD ALIGN=CENTER class="campos">UNIDAD DE ENTRADA </TD>
<TD ALIGN=CENTER class="campos">UNIDAD DE SALIDA </TD>
<TD ALIGN=CENTER class="campos">STOCK M&Iacute;NIMO </TD>
<TD ALIGN=CENTER class="campos">STOCK M&Aacute;XIMO </TD>
<TD ALIGN=CENTER class="campos">UNIDAD</TD>
<TD ALIGN=CENTER class="campos">STATUS</TD>
<TD ALIGN=CENTER class="campos">COSTO PROMEDIO </TD>
<TD ALIGN=CENTER class="campos">EXISTENCIAS</TD>
<TD ALIGN=CENTER class="campos">TRANSFERENCIAS</TD>
<TD ALIGN=CENTER class="campos">OBSERVACIONES</TD>
<TD ALIGN=CENTER class="campos">ENTRADAS TOTALES </TD>
<TD ALIGN=CENTER class="campos">SALIDAS TOTALES </TD>
</tr>
<?php while($registro=mysql_fetch_array($result))  {  
				$idp=$registro["id"];
				// ENTRADAS POR MES ...
				$sql1="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_e
				FROM mov_almacen, prodxmov, concepmov
				WHERE mov_almacen.id_mov = prodxmov.nummov
				AND prodxmov.id_prod =$idp
				AND mov_almacen.tipo_mov = concepmov.id_concep
				AND concepmov.tipo = 'Ent'
				ORDER BY mov_almacen.id_mov";
				$result1=mysql_db_query($sql_db,$sql1);	
				$ndrx=mysql_num_rows($result1);
				while ($registro1=mysql_fetch_array($result1))
				{
					$sumaE=$registro1["suma_total_mensual_e"];
					if ($sumaE=="") $sumaE=0; 
				}
				// SALIDAS POR MES ...
				$sql2="SELECT sum( prodxmov.cantidad ) AS suma_total_mensual_e
				FROM mov_almacen, prodxmov, concepmov
				WHERE mov_almacen.id_mov = prodxmov.nummov
				AND prodxmov.id_prod =$idp
				AND mov_almacen.tipo_mov = concepmov.id_concep
				AND concepmov.tipo = 'Sal'
				ORDER BY mov_almacen.id_mov";
				$result2=mysql_db_query($sql_db,$sql2);	
				$ndrx2=mysql_num_rows($result2);
				while ($registro2=mysql_fetch_array($result2))
				{
					$sumaS=$registro2["suma_total_mensual_e"];
					if ($sumaS=="") $sumaS=0; 
				}

?>
<tr>
<TD class="td1" align=center>&nbsp;<?=$registro["id"];?></TD>
<TD class="td1">&nbsp;<?=$registro["id_prod"];?></TD>
<TD class="td1">&nbsp;<?=$registro["descripgral"];?></TD>
<TD class="td1">&nbsp;<?=$registro["especificacion"];?></TD>
<TD class="td1">&nbsp;<?=$registro["linea"];?></TD>
<TD class="td1">&nbsp;<?=$registro["marca"];?></TD>
<TD class="td1">&nbsp;<?=$registro["control_alm"];?></TD>
<TD class="td1">&nbsp;<?=$registro["ubicacion"];?></TD>
<TD class="td1">&nbsp;<?=$registro["uni_entrada"];?></TD>
<TD class="td1">&nbsp;<?=$registro["uni_salida"];?></TD>
<TD class="td1">&nbsp;<?=$registro["stock_min"];?></TD>
<TD class="td1">&nbsp;<?=$registro["stock_max"];?></TD>
<TD class="td1">&nbsp;<?=$registro["unidad"];?></TD>
<TD class="td1" align="left">
<?php 
	if ($registro["status1"]==0) echo "USO CONSTANTE";
	if ($registro["status1"]==1) echo "LENTO MOVIMIENTO";
	if ($registro["status1"]==2) echo "OBSOLETO";
?></TD>
<TD class="td1" align="right"><?=$registro["cpromedio"];?></TD>
<TD class="td1" align="right"><?=$registro[$c_eX];?></TD>
<TD class="td1" align="right"><?=$registro[$c_tX];?></TD>
<TD style="border-top:#CCCCCC 1px solid;">&nbsp;<?=$registro["observa"];?></TD>
	
	<TD style="border-top:#CCCCCC 1px solid; text-align:right;" class="td1"><?=$sumaE?></TD>
	<TD style="border-top:#CCCCCC 1px solid; text-align:right;"><?=$sumaS?></TD>
</tr>
<?php } ?>
</table>
