<?
//print_r($_GET);
	if($_GET['action']=="guardaItem"){
	include("../php/conectarbase.php");
		$NumMov=$_GET['NumMov'];
		
		//$mov2=$_GET['mov2'];
		$idtipomov=$_GET['idtipomov'];
		$idasociado=$_GET['idasociado'];
		$asociado=$_GET['asociado'];
		$id_alm=$_GET['id_alm'];
		$alm=$_GET['alm'];
		$ca1=$_GET['ca1'];
		$cl1=$_GET['cl1'];
		$cu1=$_GET['cu1'];
		$ds1=$_GET['ds1'];
		
		$campo_existencias1="exist_".$id_alm;
		$campo_transferencias1="trans_".$id_alm;
		//echo "<br>CEA: $campo_existencias1";
		//print_r($_GET);
			
			
			//*****************************
			$sqlidx="select * from catprod where id_prod='".$_GET['cl1']."'";
				$residx=mysql_db_query($sql_db,$sqlidx);
				$idx=mysql_fetch_array($residx);
				$id=$idx['id'];
				$stock_min=$idx['stock_min'];
				$stock_max=$idx['stock_max'];
			//**************************** 
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

			// Consulta de Actualizacion a las existencias del inventario--------
			// Buscando producto en catalogo para obtener existencias actuales
			//echo "<br><br>";
			$sqlProd="SELECT id, ".$campo_existencias1.",".$campo_transferencias1.",existencias, stock_min, stock_max FROM catprod WHERE id=".$id;
			$resultExist=mysql_db_query($sql_db,$sqlProd);
			$rowExist=mysql_fetch_array($resultExist);
				$exis=$rowExist[$campo_existencias1];
				$tran=$rowExist[$campo_transferencias1];
				$min=$rowExist['2'];
				$max=$rowExist['3'];
				
			if ($mov=="Ent"){
				$t=$exis+$ca;
				if ($idtipomov=='4') // Si es entrada y el tipo de mov es 4 (Entrada x traspaso)...
				{
					$ntransferencias=$tran-$ca;
					if ($ca>$tran)
					{	
						echo "<br><img src='img/icon-error.gif' border='0'>&nbsp;Error: La cantidad de entrada es mayor a las transferencias del producto ($cl).";
						exit();	
					} 
					$actInvenSQL="UPDATE catprod SET ".$campo_existencias1."='$t',".$campo_transferencias1."='".$ntransferencias."' WHERE id='$id'";	
					//echo "<br>Entrada x Traspaso ...<br>";
				} else {
					$actInvenSQL="UPDATE catprod SET ".$campo_existencias1."= '".$t."' WHERE id= '$id' ";
					//echo "<br>NO Entrada x Traspaso ...<br>";
				}	
			} else{ //  Salida ...
				$t=$exis-$ca;
				if ($ca>$exis)
				{	
					echo "<br><img src='img/icon-error.gif' border='0'>&nbsp;Error: La cantidad de salida es mayor a las existencias del producto ($cl).";
					exit();	
				} 
				
				$actInvenSQL="UPDATE `catprod` SET ".$campo_existencias1."= '$t' WHERE id= '$id' ";
				//UPDATE catprod SET exist_1 =  '130' WHERE id =  '2'
				//echo $actInvenSQL;				
			}
			//echo "SQL UPDATE (".$actInvenSQL.")<p>";
			//echo "<br>SQL [$actInvenSQL] <br>Stock Min [$stock_min]     Stock Maximo [$stock_max] campo T [$t]<br>";
			
			if (!mysql_db_query($sql_db,$actInvenSQL))
			{
				echo "<br>Error SQL: No se inserto el registro ($campo_existencias1=$t).";
			}
			
			if ($t<=$stock_min){
				$aviso="Se tiene que Realizar el Punto de Reorden";
				echo "<br><img src='img/icon-error.gif' border='0'>&nbsp;".$aviso;
			}
			if ($t>=$stock_max){
				$aviso="Se a Sobrepasado el Stock Maximo";
				echo "<br><img src='img/icon-error.gif' border='0'>&nbsp;".$aviso;
			}
			
			
			// SI SE REALIZA EL TRASPASO, INSERTAR EL MOVIMIENTO...
			$guardo=mysql_db_query($sql_db,$SQL2);
			if($guardo==false){
				echo "<br>Error al guardar el movimiento";
			}else{
				echo "<br>Producto Agregado al movimiento";
				// ==============================================================
				if ($idtipomov==1||$idtipomov==10){
					//echo '<br>'.$sql_cpy="SELECT cpromedio FROM catprod WHERE id_prod='$cl' ";
					//echo 
					$sql_cpy="SELECT cpromedio FROM catprod WHERE `id_prod`='$cl' ";
					$r_cpy=mysql_db_query($sql_db,$sql_cpy);
					//echo "<br>NDR: ".mysql_num_rows($r_cpy);
					if($r_cpy)
					{
						while($r1_cpy=mysql_fetch_array($r_cpy))
						{
							$cpy=$r1_cpy["cpromedio"];
						}
					} else {
						echo "<br>Error SQL [$sql_cpy]<br>";
					}
					
					// CALCULAR EL COSTO PROMEDIO :
						if ($cpy>0)
						{
							$cp=($cpy+$cu)/2;
						} else {
							$cp=$cu;
						}
					// ACTUALIZAR EL CAMPO COSTO PROMEDIO ...	
						$sql_upd="UPDATE catprod SET cpromedio='$cp' WHERE `id_prod`='$cl'";
						if (!mysql_db_query($sql_db,$sql_upd))
							echo "<br>Error SQL: El Costo promedio no se actualizo.<br>$sql_upd";
				?>
				<p><br /><table align="center" cellspacing="0" style="border:#000000 1PX solid;">
				<tr style="background-color:#FFFFFF; text-align:center; color:#000000; padding:2px; font-weight:bold; ">
				  <td colspan="4">COSTO PROMEDIO </td>
				  </tr>
				<tr style="background-color:#333333; text-align:center; color:#FFFFFF; padding:2px; ">
				  <td>CLAVE DEL PRODUCTO</td>
					<td>C. P. ANTERIOR </td>
					<td>C. U.</td><td>C. PROMEDIO</td>
				</tr>
				<tr style="padding:1px; text-align:center;">
				  	<td style="border-right:#333333 1px solid;">&nbsp;<?=$cl;?></td>
					<td style="border-right:#333333 1px solid;">&nbsp;<?=$cpy;?></td>
					<td style="border-right:#333333 1px solid;">&nbsp;<?=$cu;?></td>
					<td>&nbsp;<?=$cp;?></td>
				</tr>				
				</table>
				<br />
				<?php
				}
				// ==============================================================
			}			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			// se llama al funcion de generacion de numeros de serie
			// *****************************************************
			//series($NumMov,$ca,$cl);
			
	//
			
	
	}



function series($numMov,$ca,$cl){
	//echo $numMov;
	$sql11="SELECT * FROM mov_almacen WHERE id_mov='$numMov'";
	//echo "<br>SQL ($sql11)<br>";
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