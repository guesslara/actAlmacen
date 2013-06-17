<?php 
	include ("../php/conectarbase.php");  
	$id_recibido=$_GET["id"];
	// OBTENER DATOS DEL PRODUCTO ...
		$sql="SELECT cpromedio,stock_min,stock_max FROM catprod WHERE id='$id_recibido'";
		$result=mysql_db_query($sql_db,$sql);
		$row=mysql_fetch_array($result);	
		
	
	if ($_POST)
	{
		//print_r($_POST);
		$sql_modificar="UPDATE catprod SET cpromedio='".$_POST["cp"]."',stock_min='".$_POST["smin"]."',stock_max='".$_POST["smax"]."' WHERE id=".$_POST["id"]." ";
		if ($result=mysql_db_query($sql_db,$sql_modificar))
		{
			$sql_1=true;
		} else {
			$sql_1=false;
			//echo "<br>Error SQL ($sql_modificar): <br> El registro no se modifico.";
		}
// =========================================================================================================
		$sql_modificar2="UPDATE prodxmov SET cu='".$_POST["cp"]."' WHERE id_prod=".$_POST["id"]." ";
		if ($result2=mysql_db_query($sql_db,$sql_modificar2))
		{
			$sql_2=true;
		} else {
			$sql_2=false;
			echo "<br>Error SQL ($sql_modificar): <br> El registro no se modifico.";
		}		
// =========================================================================================================		
		if ($sql_1==true&&$sql_2==true)
		{
			echo "<script language=\"javascript\">alert('El producto se modifico correctamente.'); self.close();</script>";
		} else {
			
			if (!$sql_1==true)
				echo "<br>Error SQL 1: ($sql_modificar): <br> El registro no se modifico.";
			if (!$sql_2==true)
				echo "<br>Error SQL 2: ($sql_modificar2): <br> El registro no se modifico.";
		}
		
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
	.campox{ background-color:#CCCCCC; font-weight:bold;}
</style>
</head>

<body>
<form name="frm1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="400" border="0" align="center">
  <tr>
    <td colspan="2" style="background-color:#333333; color:#FFFFFF; text-align:center; font-weight:bold; ">MODIFICAR PRODUCTO</td>
    </tr>
  <tr>
    <td width="187">ID</td>
    <td width="301">&nbsp;<input type="text" name="id" size="10" value="<?=$id_recibido?>" readonly="1"/></td>
  </tr>
  
  
  <tr>
    <td>COSTO PROMEDIO </td>
    <td>&nbsp;<input type="text" name="cp" size="20" value="<?=$row["cpromedio"]?>"/></td>
  </tr>
  <tr>
    <td>STOCK M&Iacute;NIMO </td>
    <td>&nbsp;<input type="text" name="smin" size="20" value="<?=$row["stock_min"]?>" /></td>
  </tr>
  <tr>
    <td>STOCK M&Aacute;XIMO </td>
    <td>&nbsp;<input type="text" name="smax" size="20" value="<?=$row["stock_max"]?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;<input type="submit" value="MODIFICAR" /></td>
  </tr>  
</table>
</form>
</body>
</html>
