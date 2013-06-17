<?php
$sql =$_GET['sql'];
stripcslashes($sql);

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=0>\n";
echo "<tr>\n";
echo "<th colspan='5'>Productos con existencias menores a su Stock Minimo</th>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<th >ID Producto</th>\n";
echo "<th >Descripcion</th>\n";
echo "<th >Stock Minimo</th>\n";
echo "<th >Existencias_1</th>\n";
echo "<th >Diferencia</th>\n";
echo "</tr>\n";

include('../conf/conectarbase.php');
//echo "<br>".
$sql = str_replace("\\",'', $sql); 
$result=mysql_db_query($sql_db,$sql);
while($fila = mysql_fetch_array($result)) 
{
			//echo 'equipoID:'.$row["responsable"].' id'.$fila["id"].$fila["nombre"].'<br>';
		$shtml = $shtml.'<tr>';
		$shtml = $shtml.'<td>&nbsp;'.$fila["id_prod"].'</td>';
		$shtml = $shtml.'<td>&nbsp;'.$fila["descripgral"].'</td>';
		$shtml = $shtml.'<td>'.$fila["stock_min"].'</td>';
		$shtml = $shtml.'<td>'.$fila["exist_1"].'</td>';
		$shtml = $shtml.'<td>'.$fila["diferencia"].'</td>';
  $shtml = $shtml.'</tr>';
}

echo $shtml;	
echo "</table>\n";

?>