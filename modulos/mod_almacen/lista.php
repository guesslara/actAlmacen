<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:21px;
	top:59px;
	width:331px;
	height:304px;
	z-index:1;
	background-color: #FFFFFF;
	visibility: inherit;
	overflow: auto;
}
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
	<?
	if(!$_POST){
	include("../php/conectarbase.php");
	$sql="Select * from catprod";
	$resultado=mysql_db_query($sql_db,$sql);
	?>
<form id="form1" name="form1" method="post" action="lista.php">
<p><br /><div id="Layer1" >
	<?
	$i=0;
	while($fila=mysql_fetch_array($resultado)){
	?>
<label><input type="checkbox" name="<?='x'.$i;?>" value="<?=$fila[0];?>"/><?=$i."=>".$fila[0].".-".$fila[1];?></label></br>
	<?
		$i=$i+1;
		}
	?>
</div> </p><p>&nbsp;</p><p>
............................................................................................ 
<input type="submit" name="Submit" value="Enviar" />
<br />
</label>
</p>
</form>
<?
	}
	else{
		
			$chk="x$i";
			$$chk=$_POST["x$i"]; 
		

	}
?>
</body>
</html>