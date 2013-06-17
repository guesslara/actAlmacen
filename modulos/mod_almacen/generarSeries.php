<?
	$idmov=$_GET['numMov'];
	series($idmov);
	
	function series($idmov){
		set_time_limit(0);
		$sGen=0;
		$err=0;
		include("../php/conectarbase.php");		
		//se consulta si ya se generaron los numeros de serie
		$sqlGen="select seriesGen from mov_almacen where id_mov='".$idmov."'";
		$resGen=mysql_db_query($sql_db,$sqlGen);
		$rowGen=mysql_fetch_array($resGen);
		
		if($rowGen['seriesGen']=="No Generado"){
			$sql11="SELECT * FROM prodxmov WHERE nummov='$idmov'";
			$result11=mysql_db_query($sql_db,$sql11);
			$row=mysql_fetch_array($result11);
			do{
				$ca=$row['cantidad'];
				$clv=$row['clave'];
				for ($j = 1; $j <= $ca; $j++) {
					$con=sprintf('%03s',$j);
					$serie=$clv.date('ymHi').$con;
					$sql4="INSERT INTO num_series (serie,clave_prod,mov) values	('$serie','$clv','$idmov')";
					$res=mysql_db_query($sql_db,$sql4);
					if($res==true){
						$sGen+=1;	
					}else{
						$err+=1;
					}
				}
				echo "---------------------------------------------------<br>";
				echo "Se han Generado: ".$sGen." numero(s) de serie.<br>";
				echo "Errores Notificados: ".$err."<br>";
				echo "---------------------------------------------------<br>";
				$sGen=0;
				$err=0;
			}while($row=mysql_fetch_array($result11));
			$sqlGen1="update mov_almacen set seriesGen='Generado' where id_mov='".$idmov."'";
			$resGen1=mysql_db_query($sql_db,$sqlGen1);
			if($resGen1==false){
				echo "Ocurrieron errores en la aplicacion.";	
			}
			//$rowGen1=mysql_fetch_array($resGen1);
		}else{
			echo "-----------------------------------------------------------------<br>";
			echo "Los numeros de serie de este movimiento ya han sido creados<br>";
			echo "-----------------------------------------------------------------<br>";
		}
		echo "<br><a href='mov_list.php'>Regresar al listado de Movimientos</a>";		
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
</body>
</html>
