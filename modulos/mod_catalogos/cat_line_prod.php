<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
	include("../conf/conectarbase.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
	include("../menu/menu.php"); 
 	$op=$_GET["op"];
	switch ($op){
		case 1:  //Altas de lineas de productos
			if(!$_POST){
				validar_usuarios(0,1);
				?>
				<form id="form1" name="form1" method="post" action="cat_line_prod.php?op=1"><div align="center">
 				<p> <table width="360px" height="129" border="0" align="center" cellspacing="1">
					<tr>
          				<td height="20" colspan="3" bgcolor="#333333" align="center"><span class="Estilo2">Alta de  L&iacute;nea de Productos </span></td>
    				</tr>
      				<tr>
        				<td width="146" height="11" align="left" bgcolor="#CCCCCC" class="Estilo4"><strong>L&iacute;nea</strong></td>
        				<td width="207" colspan="2" valign="top" align="left"><input name="linea2" type="text" id="linea2" size="15" /></td>
   					</tr>
      				<tr>
        				<td height="12" align="left" bgcolor="#CCCCCC"><span class="Estilo4"><strong>Descripci&oacute;n</strong></span></td>
        				<td colspan="2" valign="top" align="left"><input name="descripcion" type="text" id="descripcion" size="30" /></td>
      				</tr>
					<tr>
						<td height="24" align="left" bgcolor="#CCCCCC"><span class="Estilo4"><strong>Cuenta Contable</strong></span></td>
        				<td colspan="2" align="left">
          					<input name="cuenta" type="text" id="cuenta" size="30" />
						</td>
      				</tr>
     				<tr>
        				<td height="26" colspan="3" bgcolor="#333333" align="center">
          					<input type="submit" name="Submit" value="Enviar" />
        				</td>
    				</tr>
  					</table>
				</form>
				<?
			} else {
				validar_usuarios(0,1);
				$linea=$_POST["linea2"];
				$deslinea=$_POST["descripcion"];
				$cuenta=$_POST["cuenta"];
				$sql="INSERT INTO lineas (linea, descripcion, cuenta) values ('$linea','$deslinea','$cuenta')";
				if (!mysql_db_query($sql_db,$sql))
				{
					echo "<div align='center' class='style17'>Error: Los datos no se guardaron.</div>";
				} else {
					echo "<div align='center' class='style17'>Datos guardados correctamente.</div>";
				}
			}
			break;
		case 2:		//Busqueda
			if(!$_POST){
				?>
				</center>
				<form id="form1" name="form1" method="post" action="cat_line_prod.php?op=2">
    			<p><table width="323" border="0" cellspacing="1" align="center">
				<tr>
        			<td colspan="2" valign="top" bgcolor="#333333" align="center" height="20"><span class="Estilo2">Buscar Linea </span></td>
     			</tr>
      			<tr>
        			<td width="99" valign="top" bgcolor="#CCCCCC" align="center"><strong>Linea </strong></td>
       				<td width="160" valign="top"><input name="linea" type="text" id="linea" size="15" /></td>
      			</tr>
      			<tr>
        			<td colspan="2" valign="top" bgcolor="#333333" align="right">
          				<input type="submit" name="Submit2" value="Buscar" />
					</td>
      			</tr>
    			</table>
				</form>
				<?
			} else { ?>
				<table width="652" border="0" align="center" cellspacing="1">
  				<tr>
    				<td colspan="4" bgcolor="#333333"><div align="center"><span class="Estilo2"> Datos encontrados:</span></div></td>
  				</tr>
  				<tr>
    				<td bgcolor="#CCCCCC" class="Estilo4"><center><strong>Linea</strong></center></td>
    				<td bgcolor="#CCCCCC" class="Estilo4"><center><strong>Descripcion</strong></center></td>
    				<td width="50" bgcolor="#CCCCCC" class="Estilo4"><center><strong>Cuenta</strong></center></td>
  				</tr>
				<?
				$linea=$_POST['linea'];
				$sql="SELECT * FROM lineas WHERE linea='$linea'";
				$result=mysql_db_query($sql_db,$sql);
				while($row=mysql_fetch_array($result)){ ?>
  					<tr>
    					<td width="66" bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3"><?= $row["linea"]; ?></font></td>
    					<td width="357" bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3"><?= $row["descripcion"]; ?></font></td>
    					<td width="166" bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3"><?= $row["cuenta"]; ?></font></td>
  					</tr>
					<?
				}
				?></table><?php
			}
			break;
		case 3: 
		
				$linea=$_POST['linea'];
				$sql="SELECT * FROM lineas";
				$result=mysql_db_query($sql_db,$sql);
				$ndr=mysql_num_rows($result);
				$color=="#D9FFB3";		
		
		?>
			<p>
			<table width="652" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
  			<tr style="background-color:#333333; font-weight:bold; text-align:center; color:#FFFFFF;">
    			<td colspan="4" height="23" >L&iacute;neas de Productos (<small><?=$ndr?> resultados</small>) </td>
  			</tr>
  			<tr style="background-color:#cccccc; font-weight:bold; text-align:center; color:#333333;">
    			<td height="20">Id</td>
    			<td>L&iacute;nea</td>
    			<td width="136">Cuenta</td>
  			</tr>
  			<?
				while($row=mysql_fetch_array($result)){ ?>
  					<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
    					<td width="57" height="20" style="border-right:#CCCCCC 1px solid; text-align:center;">&nbsp;<?= $row["linea"] ?></td>
    					<td width="449" style="border-right:#CCCCCC 1px solid;">&nbsp;<?= $row["descripcion"] ?></td>
    					<td width="136" style="border-right:#CCCCCC 1px solid; text-align:center;">&nbsp;<?= $row["cuenta"]; ?></td>
  					</tr>
  					<?
					($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
				}
			?></table><?php	
			break;
		}
	include("../f.php"); ?>
</body>
</html>