<?php 
	session_start();
	include ("../conf/validar_usuarios.php");
	validar_usuarios(0,1);
	include("../conf/conectarbase.php");
	$sql="SELECT * FROM catprovee";
	$result=mysql_db_query($dbcompras,$sql);
	$ndr=mysql_num_rows($result);
	$color=="#D9FFB3";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title></title>

<link href="../css/style.css" rel="stylesheet" type="text/css">

</head>



<body>

<?php include("../menu/menu.php"); ?>

<br />

<table width="652" align="center" cellspacing="0" style="border:#333333 2px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">

    <tr style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;">

      <td colspan="3" height="20">Cat&aacute;logo de Proveedores (<small><?=$ndr?> resultados</small>)</td>
    </tr>

    <tr style="text-align:center; font-weight:bold;">

      <td bgcolor="#CCCCCC" class="style17" height="20">Id</td>
	  <td bgcolor="#CCCCCC" class="style17">Proveedor</td>
    </tr>

<? 	while($row=mysql_fetch_array($result)){ ?>

    <tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">

      <td align="center" width="25" height="20" style=" border-right:#CCCCCC 1px solid;">

        <?= $row["id_prov"]; ?>      </td>

      <td width="421" style=" border-right:#CCCCCC 1px solid;">

	  &nbsp;<?= $row["nr"]; ?>      </td>
    </tr>

    <?

  			if ($color=="#D9FFB3") 

				$color="#ffffff";

			else 

				$color="#D9FFB3";

			//	}

			//break;

		}

?>
  </table>

  <p>&nbsp;</p>

	<? include("../f.php"); ?>

</body>

</html>