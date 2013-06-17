<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
	
	include("../conf/conectarbase.php");
	$color=="#D9FFB3";
	$mensaje="";
	
	if ($_POST)
	{
		//print_r($_POST);
		$li=$_POST["txt3"];
		$de=$_POST["txt4"];
		$ob=$_POST["txt5"];
		
		//echo "<br>".
		$sql_insertar0="SELECT id FROM cat_tipoprod WHERE descr LIKE '%$de%'";
		$result0=mysql_db_query($sql_db,$sql_insertar0);
		if (mysql_num_rows($result0)>0) {
			$mensaje="<br><div style='text-align:center; font_weight:bold;'>Error de Captura: El Tipo de Producto ya existe.</div>";
		} else {
			//echo "<br>".
			$sql_insertar="INSERT INTO cat_tipoprod (id,clavetipo,clavetec,descr,obs) VALUES (NULL,'','$li','$de','$ob')";
			if (mysql_db_query($sql_db,$sql_insertar,$link))
			{
				/*
				$uid=mysql_insert_id($link);
				echo "<br>".$sql_insertar2="SELECT id FROM cat_tipoprod WHERE id=$uid LIMIT 1";
				$result2=mysql_db_query($sql_db,$sql_insertar2);				
				while($row2=mysql_fetch_array($result2)){
					$id2=$row2["id"];
				}
				*/
				
				$mensaje="<br><div style='text-align:center; font_weight:bold;'>El Tipo de Producto se agrego correctamente.</div>";
				
			} else {
				$mensaje="<br><div style='text-align:center; font_weight:bold;'>Error del sistema: No se registro el Tipo de Producto.</div>";
				//exit();
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FFFFFF}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo8 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }

-->
</style>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<script language="javascript">
	function nuevo()
	{
		//alert("VER FORMULARIO 1");
		$("#div_nue_for").show();
	}
	function validar()
	{
		var l=$('#txt3').attr('value');
		var d=$('#txt4').attr('value');
		var o=$('#txt5').attr('value');
		//alert('Linea: '+l+'\nDescripcion:'+d+'\nOBS:'+o);
		if (l==""||l=="undefined"||l==null) return;
		if (d==""||d=="undefined"||d==null) return;
		if (confirm("¿Desea guardar el tipo de Producto?"))
		{
			document.f1.submit();
		}
		
	}	
</script>


<br />
	<div id="div_nuevo">
		<div id="div_nue_tit" style="margin-right:50px; text-align:right;"><a href="javascript:nuevo();">Nuevo Tipo de producto &raquo;</a></div>
		<div id="div_nue_for" style="display:none;">
			<form name="f1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			<table width="800" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
			  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
				<td height="20">Id</td>
				<td>Clave tipo </td>
				<td width="47">L&iacute;nea</td>
				<td width="438">Descripci&oacute;n</td>
				<td width="182">Obs</td>
			  </tr>
			  <tr>
				<td width="31" height="20" style="border-right:#CCCCCC 1px solid;text-align:center;">
				  <input type="text" name="txt1" id="txt1" value="Autonumerico" size="15" readonly="1"/>
				</td>
				<td width="88" style="border-right:#CCCCCC 1px solid;"><input type="text" name="txt2" id="txt2" value="Autom&aacute;tico" size="15" readonly="1" /></td>
				<td style="border-right:#CCCCCC 1px solid;">
					<select name="txt3" id="txt3">
					<option value="">...</option>
					<?php 
						$sql2="SELECT linea,descripcion FROM lineas ORDER BY id_linea";
						$result2=mysql_db_query($sql_db,$sql2);
						while($row=mysql_fetch_array($result2)){
							?>
							<option value="<?=$row["linea"]?>">&nbsp;<?=$row["descripcion"]?></option>
							<?php
						}					
					?>
					</select>
					<!--<input type="text" name="txt3" id="txt3" value="" size="15" /></td>//-->
				<td align="left" style="border-right:#CCCCCC 1px solid;"><input type="text" name="txt4" id="txt4" value="" size="45" /></td>
				<td style="border-right:#CCCCCC 1px solid;"><input type="text" name="txt5" id="txt5" value="" size="15" /></td>
			  </tr>
			</table>		
			<div align="center">
				<br /><input type="button" value="Guardar" onclick="validar()" />
			</div>
			</form>
		</div>
	</div>
<br />
<?php echo $mensaje?><br />

<table width="800" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
  <tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
    <td colspan="6" height="20" > Cat&aacute;logo de Tipo de Productos </td>
  </tr>
  <tr style="background-color:#CCCCCC; text-align:center; font-weight:bold; color:#000000;">
    <td height="20">Id</td>
    <td>Clave tipo </td>
    <td width="47">L&iacute;nea</td>
    <td width="438">Descripci&oacute;n</td>
    <td width="182">Obs</td>
  </tr>
	<?
	$sql="SELECT * FROM cat_tipoprod ORDER BY id";
	$result=mysql_db_query($sql_db,$sql);
	$color=="#D9FFB3";
	while($row=mysql_fetch_array($result)){
	?>
  <tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
    <td width="31" height="20" style="border-right:#CCCCCC 1px solid;text-align:center;">
        <?= $row["id"]; ?>
    </td>
    <td width="88" style="border-right:#CCCCCC 1px solid;">&nbsp;
        <?= $row["clavetipo"]; ?>    </td>
    <td style="border-right:#CCCCCC 1px solid;">&nbsp;
        <?= $row["clavetec"]; ?>
    </td>
    <td align="left" style="border-right:#CCCCCC 1px solid;">&nbsp;
        <?= $row["descr"]; ?>
    </td>
    <td style="border-right:#CCCCCC 1px solid;">&nbsp;
        <?= $row["obs"]; ?>
    </td>
  </tr>
  <?
  			($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
		}
?>
</table>
<?php include("../f.php"); ?>
</body>
</html>
