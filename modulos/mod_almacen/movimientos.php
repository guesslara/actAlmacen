<?php 
session_start();
include("../php/conectarbase.php");
//print_r($_POST);
//echo '<hr>';
// =================================================================================================
	$NumMov=$_POST['ndm'];			$idtipomov=$_POST["itm"];		$id_alm=$_POST['ial'];
	$idp=$_POST["idp"]; 			$mov=$_POST['mov'];				$alm=$_POST['alm'];
	$can=$_POST["can"];				$con=$_POST['con'];				$idasociado=$_POST["ias"];
	$des=$_POST["des"];												$asociado=$_POST["aso"];
	$cu=$_POST["cun"];				$ref=$_POST['ref'];
echo "<br>MOVIMIENTO: $con <BR><hr align=center width=50%>";

	//	VERIFICAR SI EL PRODUCTO YA EXISTE EN EL MOVIMIENTO.
	$sql_yex="SELECT id FROM prodxmov WHERE nummov=$NumMov AND clave='$idp' ";
	$result=mysql_db_query($sql_db,$sql_yex);
	if (($ndr=mysql_num_rows($result))>0) { echo "<br><center>Error: El producto ($idp) ya esta registrado en el movimiento ($NumMov).</center>"; exit(); }



// ================================================================================================	
	$campo_existencias1="exist_".$id_alm;
	$campo_transferencias1="trans_".$id_alm;

	$alm_destino="a_$idasociado_$asociado";
	$campo_existencias2="exist_".$idasociado;
	$campo_transferencias2="trans_".$idasociado;

	if ($idtipomov=='9'){
		$sqlidx="SELECT `$campo_transferencias2` FROM catprod WHERE id_prod='".$idp."'";
		$residx=mysql_db_query($sql_db,$sqlidx);
		$idx=mysql_fetch_array($residx);
			$tran2=$idx[$campo_transferencias2];
	}		
// ================================================================================================	
	// OBTENER VALORES DEL PRODUCTOS ...
	$sqlidx="SELECT `id`,`stock_min`,`stock_max`,`$campo_existencias1`,`$campo_transferencias1`,`cpromedio`,`descripgral`,`especificacion` FROM catprod WHERE id_prod='".$idp."'";
	$residx=mysql_db_query($sql_db,$sqlidx);
	$idx=mysql_fetch_array($residx);
		$id=$idx['id'];
		$stock_min=$idx['stock_min'];
		$stock_max=$idx['stock_max'];
		$exis=$idx[$campo_existencias1];
		$tran=$idx[$campo_transferencias1];	
		
		$cpr=$idx["cpromedio"];	
		$dgr=$idx["descripgral"];	
		$esp=$idx["especificacion"];
			
	//echo "<br><br>ID: $id<br>Id PRODUCTO: $idp <br>DESCRIPCION: $des<br>STOCK MINIMO: $stock_min <br>STOCK MAXIMO: $stock_max<br>ALMACEN: $alm <br>EXISTENCIAS: $exis <br>TRANSFERENCIAS: $tran <br>";		
// ================================================================================================		
			// echo '<br>'.
			if ($mov=="Ent"){
				$t=$exis+$can;
				if ($idtipomov=='4') // Si es entrada y el tipo de mov es 4 (Entrada x traspaso)...
				{
					$ntransferencias=$tran-$can;
					if ($can>$tran)
					{	
						echo "<br><img src='../img/icon-error.gif' border='0'>&nbsp;Error: La cantidad de entrada es mayor a las transferencias del producto ($idp).";
						exit();	
					} 
					$actInvenSQL="UPDATE catprod SET `".$campo_existencias1."`='$t',`".$campo_transferencias1."`='".$ntransferencias."' WHERE id='$id'";	
					//echo "<br>Entrada x Traspaso ...<br>";
				} else {
					$actInvenSQL="UPDATE catprod SET `".$campo_existencias1."`= '".$t."' WHERE id= '$id' ";
					//echo "<br>NO Entrada x Traspaso ...<br>";
				}	
			} else{ //  Salida ...
				$t=$exis-$can;
				if ($idtipomov=='9'){
					$t2=$tran2+$can;
					$actInvenSQL="UPDATE `catprod` SET `".$campo_existencias1."`= '".$t."',`$campo_transferencias2`='$t2' WHERE id= '$id' ";
				} else {
					$actInvenSQL="UPDATE `catprod` SET `".$campo_existencias1."`= '$t' WHERE id= '$id' ";
				}
				
				if ($can>$exis)
				{	
					echo '<br>'."<br><img src='../img/icon-error.gif' border='0'>&nbsp;Error: La cantidad de salida es mayor a las existencias del producto ($idp).";
					exit();	
				} 
			}
// ================================================================================================		  
			if (!mysql_db_query($sql_db,$actInvenSQL))
			{
				echo "<br>Error SQL: No se inserto el registro ($actInvenSQL).";
			}
			
			if ($t<=$stock_min){
				$aviso="<br>Se tiene que Realizar el Punto de Reorden del producto ($idp).<br>";
				echo "<br><img src='../img/icon-error.gif' border='0'>&nbsp;".$aviso;
			}
			if ($t>=$stock_max){
				$aviso="Se a Sobrepasado el Stock Maximo del producto ($idp).<br>";
				echo "<br><img src='../img/icon-error.gif' border='0'>&nbsp;".$aviso;
			}
// ================================================================================================		  			
		$val="VALUES (".$NumMov.",".$id.",".$can.",'".$idp."',".$cu.")";
		
		$SQL2="INSERT INTO prodxmov (nummov,id_prod,cantidad,clave,cu) ". $val;
		$guardo=mysql_db_query($sql_db,$SQL2,$link);
		if($guardo==false){
			echo "<br>Error al guardar el Movimiento.";
		}else{
			$ult_insert=mysql_insert_id($link);
			echo "<br>Producto Agregado al Movimiento.";
			
// ================================================================================================	
			// SI SE REALIZA EL TRASPASO, INSERTAR EL MOVIMIENTO...
			if ($idtipomov==1||$idtipomov==10){
				//echo '<br>'.$sql_cpy="SELECT cpromedio FROM catprod WHERE id_prod='$cl' ";
				$sql_cpy="SELECT cpromedio FROM catprod WHERE `id_prod`='$idp' ";
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
				if ($cpr>0)
				{
					$cp=($cpr+$cu)/2;
				} else {
					$cp=$cu;
				}
				// ACTUALIZAR EL CAMPO COSTO PROMEDIO ...	
				$sql_upd="UPDATE catprod SET cpromedio='$cp' WHERE `id_prod`='$idp'";
				if (!mysql_db_query($sql_db,$sql_upd))
					echo "<br>Error SQL: El Costo promedio no se actualizo.<br>$sql_upd";
			}
		}
// ================================================================================================			
$sqlidx3="SELECT `$campo_existencias1`,`$campo_transferencias1`,`cpromedio` FROM catprod WHERE id_prod='".$idp."'";
	$residx3=mysql_db_query($sql_db,$sqlidx3);
	$idx3=mysql_fetch_array($residx3);
		$exis3=$idx3[$campo_existencias1];
		$tran3=$idx3[$campo_transferencias1];
		$cpro3=$idx3["cpromedio"];

?>
<style type="text/css">
.td1{ background-color:#CCCCCC; font-weight:bold; text-align:left; padding:1px; border-bottom:#333333 1px solid;}
.td2{ background-color:#ffffff; font-weight:normal; text-align:left; border-bottom:#333333 1px solid; padding:1px;border-left:#333333 1px solid; padding:1px;}
.tdx1{ text-align:center; font-weight:bold; padding:2px;border-right:#333333 1px solid;}
</style>
<div id="detallep" style="display:none;">
<BR /><table width="500" align="center" cellspacing="0" style="border:#333333 1px solid;">
    <td width="190" class="td1">CLAVE DEL PRODUCTO </td>
    <td width="304" class="td2">&nbsp;<?=$idp;?></td>
  </tr>
  <tr>
    <td class="td1">DESCRIPCION</td>
    <td class="td2">&nbsp;<?=$des;?></td>
  </tr>
  <tr>
    <td class="td1">ESPECIFICACION</td>
    <td class="td2">&nbsp;<?=$esp;?></td>
  </tr>
  <tr>
    <td class="td1">STOCK MINIMO </td>
    <td class="td2">&nbsp;<?=$stock_min;?></td>
  </tr>
  <tr>
    <td class="td1">STOCK MAXIMO </td>
    <td class="td2">&nbsp;<?=$stock_max;?></td>
  </tr>
  <tr>
    <td class="td1">ALMACEN</td>
    <td class="td2">&nbsp;<?=$alm;?></td>
  </tr>
  <tr>
    <td class="td1">EXISTENCIAS</td>
    <td class="td2">&nbsp;<?=$exis3;?></td>
  </tr>
  <tr>
    <td class="td1">TRANSFERENCIAS</td>
    <td class="td2">&nbsp;<?=$tran3;?></td>
  </tr>
  <tr>
    <td class="td1">COSTO UNITARIO </td>
    <td class="td2">&nbsp;<?=$cu;?></td>
  </tr>
 <?php if ($idtipomov==1||$idtipomov==10){ ?> 
  <tr>
    <td colspan="2" height="30px" valign="bottom" style="text-align:center; font-weight:bold; color:#0000FF; border-bottom:#333333 1px solid; padding:1px;">COSTO PROMEDIO (C.P.) </td>
  </tr>
  <tr>
    <td class="td1">C.P. ANTERIOR </td>
    <td class="td2">&nbsp;<?=$cpr;?></td>
  </tr>
  <tr>
    <td class="td1">C.P. ACTUAL </td>
    <td class="td2">&nbsp;<?=$cp;?></td>
  </tr>
<?php } ?>  
</table></div>
<?php
	$color="#D9FFB3";
	$sqlidy0="SELECT `id`,`clave`,`cantidad`,`cu` FROM `prodxmov`  WHERE nummov='".$NumMov."' ORDER BY id";
	$residy0=mysql_db_query($sql_db,$sqlidy0);
	$ndpamx=mysql_num_rows($residy0);		?>
	<p><br /><table align="center" cellspacing="0" style="border:#000000 1PX solid;">
	<tr style="background-color:#ffffff; text-align:right; padding-right:2px;">
	  <td colspan="5" style="padding:2px; border-left:#FFFFFF 1px solid;border-top:#FFFFFF 1px solid;border-right:#FFFFFF 1px solid; " >
	  	<a href="javascript:ver_detallep();">Ver detalle</a> 
	  </td>
	  </tr>
	<tr style="background-color:#333333; text-align:center; color:#ffffff; padding:2px; font-weight:bold; ">
  	<td colspan="5" style="padding:2px;" >Productos asociados al movimiento de <u><?=$con.' ('.$ndpamx.')';?></u></td>
	</tr>
	<tr style="background-color:#cccccc; text-align:center; color:#000000; padding:2px; border-bottom:#333333 1px solid; ">
	<td class="tdx1">CLAVE DEL PRODUCTO</td>
	<td class="tdx1">DESCRIPCION </td>
	<td class="tdx1">ESPECIFICACION</td>
	<td class="tdx1">CANTIDAD</td>
	<td class="tdx1">C.U.</td>
	</tr>
	<?php
	while ($idy0=mysql_fetch_array($residy0))
		{
			$cdp=$idy0["clave"];
			$can0=$idy0["cantidad"];
			$cu0=$idy0["cu"];	
				
			$sqlidy="SELECT `descripgral`,`especificacion` FROM catprod WHERE id_prod='".$cdp."'";
			$residy=mysql_db_query($sql_db,$sqlidy);
			$idy=mysql_fetch_array($residy);
				$dgr2=$idy["descripgral"];	
				$esp2=$idy["especificacion"];				
				 ?>
				<tr style="padding:1px; text-align:center; background-color:<?=$color;?>;">
				  	<td style="border-right:#333333 1px solid; border-top:#333333 1px solid;">&nbsp;<span style="border-right:#333333 1px solid; border-top:#333333 1px solid; text-align:right;">
				  	  <?=$cdp?>
				  	</span></td>
					<td style="border-right:#333333 1px solid; border-top:#333333 1px solid; text-align:left;">&nbsp;<?=$dgr2;?></td>
					<td style="border-right:#333333 1px solid; border-top:#333333 1px solid; text-align:left;">&nbsp;<?=$esp2;?></td>
					<td style="border-right:#333333 1px solid; border-top:#333333 1px solid; text-align:right;">&nbsp;<?=$can0;?></td>
					<td style="border-right:#333333 1px solid; border-top:#333333 1px solid; text-align:right;">&nbsp;<?=$cu0;?></td>
	  </tr>	
				  <?php 
				  ($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
				  }?>			
	</table>
	<br />