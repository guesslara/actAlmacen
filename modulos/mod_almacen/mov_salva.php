<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo2 {
	font-size: 20px;
	color: #0000FF;
}
.marcacelda {
	border-top-style: dotted;
	border-right-style: dotted;
	border-bottom-style: dotted;
	border-left-style: dotted;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.Estilo56 {font-size: 10px; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo57 {color: #FF0000}
.Estilo59 {color: #FFFFFF; font-weight: bold; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style8 {font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo61 {color: #000000}
.Estilo62 {color: #000099}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.Estilo63 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo50 {color: #FFFFFF}
.style11 {	font-size: 12px;
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style12 {	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	margin-top: 0px;
}
.style14 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000066;
}
.Estilo11 {	font-size: 9px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
}
-->
</style>
<? 	//		valores generales para el movimiento en Almacen
	 $idtipomov=$_POST['idtipomov2'];
	 $concepto=$_POST['concepto2'];
	 $id_almacen=$_POST['id_almacen2'];
	 $almacen=$_POST['almacen2'];
	 $fecha=$_POST['fecha2'];
	 $referencia=$_POST['referencia2'];
	 $idasociado=$_POST['idasociado2'];
	 $asociado=$_POST['asociado2'];
	 $observ=$_POST['observ2'];
	 $mov=$_POST['mov2'];
	//		Creando consulta de insercion para los movimientos en almacen
	$SQL="INSERT INTO mov_almacen (tipo_mov, almacen, fecha, referencia, asociado, observ) values(".$idtipomov.",".$id_almacen.",'".$fecha."','".$referencia."',".$idasociado.",'".$observ."')";
	//echo $SQL;
	include("../php/conectarbase.php");
	mysql_db_query($sql_db,$SQL);
	/*		Obteniendo el numero de Entrada de almacen para el registro de partidas correspondientes
	**		ya que es un autoincremental y se debe fijar a las entradas de las partidas.
	*/
	$result=mysql_db_query($sql_db,"Select LAST_INSERT_ID() as NumMov");
	$row=mysql_fetch_array($result);	//	$row[0]; variable del ultimo introducido
	$NumMov=$row['NumMov'];
	//echo $id;
	//		Generacion de variables por partida y Guarda en la Base de Datos.
?>
  <table width="100%" border="0" cellspacing="0">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style11"><a href="movalm.php" class="style6">Movimientos</a> | <a href="inventario.php" class="style11">Inventarios</a> | <a href="tipo_alm_listado.php" class="Estilo50">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo50">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo50">Lineas de Producto</a> | <a href="cat_product.php" class="Estilo50">Cat. Productos</a></div></td>
    </tr>
    <tr>
      <td><div align="center"><span class="style12"><a href="movalm.php">Crear movimiento</a></span> | <span class="style12"><a href="mov_list.php">Listar Movimientos</a></span></div></td>
    </tr>
  </table>  
  <table width="63%" border="0" align="center" cellspacing="1">
  <tr>
    <td colspan="2" bgcolor="#333333" class="style8"><div align="center">Movimientos al almacen</div></td>
  </tr>
  <tr>
    <td width="568" class="Estilo56"><div align="right">Numero de Movimiento</div></td>
    <td width="146" bgcolor="#FFFF00"><div align="center"><strong><?=$NumMov;?></strong></div></td>
  </tr>
</table>
    <table width="63%" border="0" align="center" cellspacing="1">
      <tr>
        <td colspan="5"><hr /></td>
      </tr>
      <tr>

        <td width="116" bgcolor="#FFFFFF" class="Estilo56">Tipo de Movimiento:</td>
        <td width="172" bgcolor="#FFFFFF"><span class="Style14"><?= $idtipomov.'.-'.$concepto;?>
        </span></td>
        <td width="82" bgcolor="#FFFFFF" class="Estilo56">De Fecha:</td>
        <td bgcolor="#FFFFFF" class="style14"><?= $fecha;?></td>
      </tr>
      <tr>
        <td class="Estilo56">Almacen Operado:</td>
        <td class="style14"><?= $id_almacen.'.-'.$almacen;?></td>
        <td class="Estilo56">Referencia:</td>
        <td class="style14"><?= $referencia;?></td>
      </tr>
      <tr>
        <td class="Estilo56">Asociado a:</td>
        <td class="style14"><?=$idasociado.'.-'.$asociado;?></td>
        <td class="Estilo56"><span class="style14">
          <?= $mov2;?>
        </span></td>
        <td class="Estilo56">&nbsp;</td>
      </tr>
      <tr>
        <td height="4" colspan="5" class="Estilo56"><hr /></td>
      </tr>
      <tr>
        <td class="Estilo56">Observaciones:</td>
        <td colspan="4" class="style14"><?= $observ;?></td>
      </tr>
    </table>
    <table width="63%" border="0" align="center" cellspacing="1">
	<tr>
    	<td width="51" bgcolor="#333333" class="style8"><div align="center" class="Estilo59">Cant</div></td>
        <td width="62" bgcolor="#333333" class="style8"><div align="center" class="Estilo59">Clave</div></td>
        <td colspan="2" bgcolor="#333333" class="style8"><div align="center" class="Estilo59">Descripcion</div></td>
        <td width="67" bgcolor="#333333" class="style8"><div align="center">CU</div></td>
  </tr>
<?
	for($i=1;$i<=10;$i++)
	{
		$chk="chk$i";
		$$chk=$_POST["chk$i"]; 
		if($$chk==1)
		{
			$ca="ca".$i;
			$cl="cl".$i;
			$id="id".$i;
			$ds="ds".$i;
			$cu="cu".$i;
			$$ca=$_POST["ca$i"];
			$$cl=$_POST["cl$i"];
			$$id=$_POST["id$i"];
			$$ds=$_POST["ds$i"];
			$$cu=$_POST["cu$i"];
			$val="values (".$NumMov.",".$$id.",".$$ca.",'".$$cl."',".$$cu.")";
			$SQL2="INSERT INTO prodxmov (nummov,id_prod,cantidad,clave,cu) ". $val;
			//echo $SQL2."<p>";
			mysql_db_query($sql_db,$SQL2);
			// Consulta de Actualizacion a las existencias del inventario--------
			// Buscando producto en catalogo para obtener existencias actuales
			$sqlProd="SELECT id, existencias, stock_min, stock_max FROM catprod WHERE id=".$$id;
			$resultExist=mysql_db_query($sql_db,$sqlProd);
			$rowExist=mysql_fetch_array($resultExist);
			$exis=$rowExist['1'];
			$min=$rowExist['2'];
			$max=$rowExist['3'];
			if ($mov=="Ent"){
				$t=$exis+$$ca;
				$actInvenSQL="UPDATE catprod SET existencias=$t WHERE id=".$$id;
				//echo $actInvenSQL;
			}
			else{
				$t=$exis-$$ca;
				$actInvenSQL="UPDATE catprod SET existencias=$t WHERE id=".$$id;
				//echo $actInvenSQL;
			}
			mysql_db_query($sql_db,$actInvenSQL);
			if ($t<=$min){
				$aviso="<strong><marquee>Se tiene que Realizar el Punto de Reorden</marquee></strong>";
			}
			if ($t>=$max){
				$aviso="<strong><marquee>Se a Sobrepasado el Stock Maximo</marquee></strong>";
			}
			
			//---------------------------------------------------------fin Act------------
			//Operacion realizada solo en traspaso de salida------------------------------
			//echo $idtipomov;
			if($idtipomov=='15'){
				$sqlExistTras="SELECT * FROM alm_".$asociado." WHERE id_prod='".$$cl."'";
				//echo $sqlExistTras;
				$rExistTras=mysql_db_query($sql_db,$sqlExistTras);
				$rowExistTras=mysql_fetch_array($rExistTras);
				$tt=$rowExistTras['trasferidos']+$$ca;
				$sqltrasf="UPDATE alm_".$asociado." SET trasferidos=$tt WHERE id_prod='".$$cl."'";
				//echo $sqltrasf;
				mysql_db_query($sql_db,$sqltrasf);
			}
			
			//---------------------------------------------------------fin Op trasp Salida
?>
      <tr>
        <td align="center" bgcolor="<?= $color; ?>" class="style10"><span class="Estilo63"><?=$$ca;?></span></td>
        <td bgcolor="<?= $color; ?>" class="style10"><center><span class="Estilo63"><?= $$cl;?></span></center></td>
        <td width="267" bgcolor="<?= $color; ?>" class="style10"><span class="Estilo63"><?= $$ds;?></span></td>
        <td width="221" bgcolor="<?= $color; ?>" class="style10"><?= $aviso;?></td>
        <td bgcolor="<?= $color; ?>" class="style10"><center><span class="Estilo63"><?= $$cu;?></span></center></td>
      </tr>
<?
			if ($color=="#D9FFB3") 
				$color="#FFFFFF";
			else 
				$color="#D9FFB3";
		}
	}


?>
      <tr>
        <td colspan="5"><hr /></td>
      </tr>
    </table>
<hr />
<p align="center" class="Estilo11">IQelectronics SA de CV</p>
<p>&nbsp;</p>
  