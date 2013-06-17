<?php 
	include("../php/conectarbase.php"); 
	echo $sql="SELECT prodxmov.*,catprod.id_prod as idp,catprod.id,catprod.descripgral FROM prodxmov,catprod WHERE catprod.id=prodxmov.id_prod ";
	$result=mysql_db_query($sql_db,$sql);
	//$row=mysql_fetch_array($result);
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<!--
<table width="100%" align="center" border="1" style=" font-family:Verdana, Arial, Helvetica, sans-serif;font-size:10px; ">
  <tr>
    <td>ID</td>
    <td bgcolor="#006600">ID_PROD</td>
    <td bgcolor="#FF0000">ID_ PROD ANTERIOR </td>
    <td>DESCRIPCION</td>
    <td>CONTROL ALMACEN</td>
    <td>SQL</td>
  </tr>
<?php 
/*
while ($row=mysql_fetch_array($result)) {
$a0=$row["id_prod"];
$a1=$row["descripgral"];
$a2=trim($row["control_alm"]);

	$sql2="SELECT id_prod,descripgral,control_alm FROM catprod WHERE descripgral = '$a1' AND control_alm = '$a2' ";
	$result2=mysql_db_query($sql_db,$sql2);
	//echo 'NDR"='.$ndr2=mysql_num_rows($result2);
	while ($row2=mysql_fetch_array($result2)){
		$b1=$row2["id_prod"];
	}
	$li=substr($a0,0,2);
	($b1=='')?	$update="" : $update=" UPDATE catprod SET linea='$li' WHERE descripgral='$a1' AND control_alm='$a2'";
	
	if (mysql_db_query($sql_db,$update))
		$c="#006600";
	else 
		$c="#ff0000";*/
	?> 
  <tr>
    <td>&nbsp;<? //$row["id"];?></td>
    <td>&nbsp;<? //$a0;?></td>
    <td bgcolor="<? //$c?>">&nbsp;<? //$b1;?></td>
    <td>&nbsp;<? //$a1;?></td>
    <td>&nbsp;<? //$a2;?></td>
    <td>&nbsp;<? //$update;?></td>
  </tr>
<?php //} ?> 
</table>
//-->
<hr /><br />
<table width="100%" align="center" border="1" style=" font-family:Verdana, Arial, Helvetica, sans-serif;font-size:10px; ">
  <tr>
    <td>ID en MOV </td>
    <td bgcolor="#006600">CLAVE EN MOV </td>
    <td bgcolor="#FF0000">CLAVE EN ALMACEN </td>
    <td>DESCRIPCION</td>
    <td>SQL</td>
  </tr>
<?php while ($row=mysql_fetch_array($result)) {
$a0=$row["id_prod"];
$a1=$row["clave"];
$a2=$row["descripgral"];
$a3=$row["idp"];

	$update=" UPDATE prodxmov SET clave='$a3' WHERE id_prod='$a0' ";
	
	if (mysql_db_query($sql_db,$update))
		$c="#006600";
	else 
		$c="#ff0000";
	?> 
  <tr>
    <td>&nbsp;<?=$a0;?></td>
    <td bgcolor="<?=$c?>">&nbsp;<?=$a1;?></td>
    <td>&nbsp;<?=$a3;?></td>
    <td>&nbsp;<?=$a2;?></td>
    <td>&nbsp;<?=$update;?></td>
  </tr>
<?php } ?> 
</table>


</body>
</html>