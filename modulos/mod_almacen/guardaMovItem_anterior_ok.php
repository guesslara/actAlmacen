<?
	if($_GET['action']=="guardaItem"){
		include("../php/conectarbase.php");
			/******************************/
			$sqlidx="select * from catprod where id_prod='".$_GET['cl1']."'";
				$residx=mysql_db_query($sql_db,$sqlidx);
				$idx=mysql_fetch_array($residx);
				$id=$idx['id'];
			/******************************/
			$NumMov=$_GET["NumMov"];
			$idtipomov=$_GET["idtipomov"];
			$idasociado=$_GET["idasociado"];
			$mov=$_GET['mov2'];
			$ca=$_GET["ca1"];
			$cl=$_GET["cl1"]; 
			//$id=$_GET["cl1"];
			$ds=$_GET["ds1"];
			$cu=$_GET["cu1"];
			$val="values (".$NumMov.",".$id.",".$ca.",'".$cl."',".$cu.")";
			$SQL2="INSERT INTO prodxmov (nummov,id_prod,cantidad,clave,cu) ". $val;
			//echo $SQL2."<p>";
			$guardo=mysql_db_query($sql_db,$SQL2);
			if($guardo==false){
				echo "Error al guardar";
			}else{
				echo "Producto Agregado al movimiento";
			}
			// Consulta de Actualizacion a las existencias del inventario--------
			// Buscando producto en catalogo para obtener existencias actuales
			$sqlProd="SELECT id, existencias, stock_min, stock_max FROM catprod WHERE id=".$id;
			$resultExist=mysql_db_query($sql_db,$sqlProd);
			$rowExist=mysql_fetch_array($resultExist);
			$exis=$rowExist['1'];
			$min=$rowExist['2'];
			$max=$rowExist['3'];
			if ($mov=="Ent"){
				$t=$exis+$ca;
				$actInvenSQL="UPDATE catprod SET existencias=$t WHERE id=".$id;
				//echo $actInvenSQL;
			}
			else{
				$t=$exis-$ca;
				$actInvenSQL="UPDATE catprod SET existencias=$t WHERE id=".$id;
				//echo $actInvenSQL;				
			}
			mysql_db_query($sql_db,$actInvenSQL);
			if ($t<=$min){
				$aviso="<strong><marquee>Se tiene que Realizar el Punto de Reorden</marquee></strong>";
			}
			if ($t>=$max){
				$aviso="<strong><marquee>Se a Sobrepasado el Stock Maximo</marquee></strong>";
			}
			/*se llama al funcion de generacion de numeros de serie*/
			/*******************************************************/
			series($NumMov,$ca,$cl);
			
			
			//---------------------------------------------------------fin Act------------
			//Operacion realizada solo en traspaso de salida------------------------------
			//echo $idtipomov;
			if($idtipomov=='15'){
				$sqlExistTras="SELECT * FROM alm_".$asociado." WHERE id_prod='".$$cl."'";
				echo $sqlExistTras;
				$rExistTras=mysql_db_query($sql_db,$sqlExistTras);
				$rowExistTras=mysql_fetch_array($rExistTras);
				$tt=$rowExistTras['trasferidos']+$$ca;
				$sqltrasf="UPDATE alm_".$asociado." SET trasferidos=$tt WHERE id_prod='".$$cl."'";
				//echo $sqltrasf;
				mysql_db_query($sql_db,$sqltrasf);
			}
	}

function series($numMov,$ca,$cl){
	//echo $numMov;
	$sql11="SELECT * FROM mov_almacen WHERE id_mov='$numMov'";
	$result11=mysql_db_query($sql_db,$sql11);
	$row=mysql_fetch_array($result11);
	$tipo= $row['tipo_mov'];
	$asociado= $row['asociado'];		
		if ($tipo==1 && $asociado==1){				
			//echo $tipo, $asociado;
			for ($j = 1; $j <= $ca; $j++) {
				$con=sprintf('%03s',$j);
				$serie=$cl.date('ymHi').$con;
				$sql4="INSERT INTO num_series (serie,clave_prod,mov) values	('$serie','$cl','$numMov')";
				//echo $sql1;
				//echo $j;
				mysql_db_query($sql_db,$sql4);
						}         //for
					}      ///if ($idm==1 && $ida==1)
}	//funcion	
?>