<?php 
include("../php/conectarbase.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script language="javascript" src="js/asistente.js"></script>
<SCRIPT LANGUAGE="JavaScript">
var win1var; 
var n;	
<!-- 
function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400');");
	}
function verificaOS(form){
	var numorder=form.numorder.value;
	if(numorder==""){
		alert("No hay un numero de orden a para ver");
		return false;
	}
	else{
		alert(numorder);
	}
}
function validar(form)
	{
		var numorder=form.numorder.value;
    	var fecha=form.fecha.value;
    	if (numorder=="" ){				//Fecha
			alert("falta Numero de Orden");
			form.numorder.focus();
			return false;}
		if (fecha==""){				//fecha
			alert("Falta fecha de Orden de Servicio");
			return false;}
		//form.submit();
	}
// -->
</script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo2 {	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
	color: #666666;
}
.Estilo6 {color: #FFFFFF}
.style6 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #333333}
.Estilo7 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo8 {font-size: 12px}
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style15 {font-size: 9}
.style17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style18 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.style11 {font-size: 12px; color: #FFFFFF; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
.style19 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.style20 {font-size: 9px}
.style21 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.ancho1{
	width:80%;
}	
.Estilo11 {font-size: xx-small}
-->
</style>
</head>

<body>
<center>
<table width="100%" border="0" align="center" cellspacing="0">
  <tr>
    <td bgcolor="#333333"><div align="center" class="style6"><a href="mov_list.php" class="style6">Movimientos</a> |<a href="inventario.php" class="style6"> Inventarios</a>  | <a href="tipo_alm_listado.php" class="Estilo50">Tipos de Almacen</a> | <a href="conc_mov_listado.php" class="Estilo50">Conceptos de E/S</a> | <a href="cat_line_prod.php?op=3" class="Estilo50">Lineas de Producto</a> | <a href="cat_product1.php" class="Estilo50">Cat. Productos</a></div></td>
  </tr>
  <tr>
    <td><div align="center" class="style6 style7"><a href="alta_producto.php" class="Estilo1"><span class="Estilo7">Alta de Productos </span></a> | <a href="cat_product_buscar.php">Buscar Productos </a><a href="tipo_alm_buscar.php"></a> |<a href="cat_product1.php" class="Estilo7"> Listar Productos </a><a href="tipo_alm_listado.php"></a></div></td>
  </tr>
</table>
<? 	
	$op=$_GET["op"];
	switch ($op){
		case 1:{ 
			if(!$_POST)
			{
?>
</center>
<form id="form1" name="form1" method="post" action="cat_product.php?op=1">
  <table width="742" border="0" align="center" cellspacing="0">
    <tr>
      <td colspan="3" bgcolor="#333333"><div align="center"><span class="Estilo2 Estilo1 Estilo8"><strong>Catalogo de Productos</strong></span></div></td>
    </tr>
    <tr>
      <td width="116" bgcolor="#EFEFEF" class="Estilo1"><div align="right">Clave del Producto</div></td>
      <td width="300" bgcolor="#EFEFEF"><input name="id_prod" type="text" id="id_prod" size="15" />
      <span class="style17"><a href="javascript:abreAsistente()">Asistente Prod. Reproceso</a></span></td>
      <td width="320" rowspan="11" bgcolor="#EFEFEF"><table width="320" border="0" align="center">
          <tr>
            <td><!---->
              <fieldset>
              <legend class="Estilo1">Almacen Asociado:</legend>
                <table width="200" border="0" align="center" cellpadding="1" cellspacing="0">
                  <tr>
                    <td colspan="2" bgcolor="#333333" class="Estilo11">&nbsp;</td>
                  </tr>
                  <?
				  //se listan los almacenes
				  $sql="Select * from tipoalmacen";
				  $resultado=mysql_db_query($sql_db,$sql);
				  while($fila=mysql_fetch_array($resultado)){
				  ?>
                  <tr>
                    <td width="25"><input name="<?="a_".$fila['id_almacen']."_".$fila['almacen'];?>" type="checkbox" value="1" /></td>
                    <td width="171" class="Estilo1"><?=$fila['almacen'];?>                  </td>
                  </tr>
                  <?
				  //echo "a_".$fila['id_almacen']."_".$fila['almacen'];
				  }
				  ?>
                </table>
              </fieldset>
            <!---->          </td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right"><span class="Estilo1">Descripcion</span></div></td>
      <td bgcolor="#EFEFEF"><span class="Estilo1">
        <input name="descripgral" type="text" id="descripgral" size="50" />
      </span></td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right"><span class="Estilo1">Especificacion</span></div></td>
      <td bgcolor="#EFEFEF"><span class="Estilo1">
        <input name="especificacion" type="text" id="especificacion" size="15" />
        <span class="Estilo11">(Modelo,Matricula,otro)</span></span></td>
    </tr>
	 <tr>
      <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Control de Almacen       </div></td>
      <td bgcolor="#EFEFEF" class="Estilo1"><input name="control_alm" type="text" id="control_alm" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Linea de Producto       </div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="linea" type="text" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Ubicacion       </div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="ubicacion" type="text" id="ubicacion" size="15" /></td>
    </tr>
	 <tr>
	   <td bgcolor="#EFEFEF" class="Estilo1"><div align="right">Marca</div></td>
       <td bgcolor="#EFEFEF" class="Estilo1"><input name="marca" type="text" size="15" /></td>
    </tr>	
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">
	  	<span class="Estilo1">
			<fieldset><legend>Unidades de:</legend>
			<table width="348" border="0" align="center">
			  <tr>
				<td width="50">Entrada</td>
				<td width="90"><span class="style15">
				  <input name="uni_entrada" type="text" id="uni_entrada" size="15" />
				</span></td>
				<td width="38">Salida</td>
				<td width="150"><input name="uni_salida" type="text" id="uni_salida" size="15" /></td>
			  </tr>
			</table>
			</fieldset>
		</span>	  </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EFEFEF" class="Estilo1">
	  <fieldset><legend>Stock:</legend>
		<table width="389" border="0" align="center">
		  <tr>
			<td width="66">Min</td>
			<td width="96"><span class="style15">
			  <input name="stock_min" type="text" id="stock_min" size="15" />
			</span></td>
			<td width="43">Max</td>
			<td width="156"><span class="style15">
			  <input name="stock_max" type="text" id="stock_max" size="15" />
			</span></td>
		  </tr>
		</table>
		</fieldset>	  </td>
    </tr>
    <tr>
      <td bgcolor="#EFEFEF" class="Estilo1">Observaciones</td>
      <td bgcolor="#EFEFEF" class="Estilo1">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#EFEFEF">
        <div align="center">
          <textarea name="observa" cols="80" rows="5" wrap="virtual" id="observa"></textarea>
        </div></td>
    </tr>   
    <tr>
      <td colspan="3" bgcolor="#333333"><div align="right">
        <input type="submit" name="button" id="button" value="Guardar" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<center>
  <p>
    <?
			}
			else
			{
				/*include("../php/conectarbase.php");
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				/*   Generando Dinamicamente la consulta de insercion 
				/*   en catalogo de productos y asociacion con almacenes --Dispercion de productos
				/*    --------------------------------PRIMERA PARTE---------------------------------
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
				$S="INSERT INTO catprod (";
				foreach($_POST as $i=> $v) {
					$Q=$Q.$i.", ";
					$L=$L.$v."', '";
				}
				//Generando consulta-----------------------------------------
				$lgQ=strlen($Q);
				$lgL=strlen($vv);
				$nQ= substr($Q, 0,$long-2);
				$nL= substr($L, 0,$long-3);
				/*echo "<script languaje='javascript'>alert('$SQL=$S.$nQ.) values (.\'$nL.\'');</script>";*/
				//include("../php/conectarbase.php");
				mysql_db_query($sql_db,$SQL);
				//redireccionando a si misma opcion 3
				$id_prod=$_POST['id_prod'];
				$descrip=$_POST['descripgral'];
				echo "<script languaje='javascript'> window.location.href='cat_product.php?op=3&id=".$id_prod."&des=".$descrip."';</script>";
			}
		}
			break;
		case 2:{		//
			if(!$_POST)
			{
?>
</center>
<form id="form1" name="form1" method="get" action="cat_product_buscar.php">
  <table width="555" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="3" valign="top" bgcolor="#333333"><div align="center" class="Estilo2">Criterio de Busqueda</div></td>
    </tr>
    <tr>
      <td width="186" valign="top" bgcolor="#CCCCCC" class="style17"><strong><input name="radio" type="radio" id="clave" value="Id_prod" checked="checked" />
      Clave del Producto </strong></td>
      <td width="300" rowspan="5" valign="middle" bgcolor="#FFFFFF"><input name="criterio" type="text" id="criterio" size="50" /></td>
      <td width="59" rowspan="5" valign="middle" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Buscar" /></td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bdesc" value="descripgral" />
      Descripcion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bespecif" value="especificacion" />
      Especificacion</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Blinea" value="linea" />
      Linea de prod.</td>
    </tr>
    <tr class="style17">
      <td valign="top" bgcolor="#CCCCCC">
        <input type="radio" name="radio" id="Bcontrol_alm" value="control_alm" />
      Control de almacen</td>
    </tr>
    <tr>
      <td colspan="3" valign="top" bgcolor="#333333">&nbsp;</td>
    </tr>
  </table>
</form>
  <?	
			}
			else
			{
				//include("../php/conectarbase.php");
				$criterio=$_POST["criterio"];
				$radio=$_POST["radio"];
				$sql="SELECT * FROM catprod WHERE $radio LIKE '%$criterio%' ORDER BY id_prod";
				$result=mysql_db_query($sql_db,$sql);
				//echo $sql;
				//echo $criterio;
?>
<form id="form1" name="form1" method="post" action="">
  <table width="802" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#333333" class="style6"><div align="center"><span class="Estilo4">Datos encontrados:</span></div></td>
    </tr>
    <tr>
      <td width="46" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>#</strong></div></td>
      <td width="102" bgcolor="#CCCCCC" class="style17"><div align="center">NumParte Almacen</div></td>
      <td width="292" bgcolor="#CCCCCC" class="style17"><strong>Descripcion</strong></td>
      <td width="91" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Especificacion</strong></div></td>
      <td width="86" bgcolor="#CCCCCC" class="style17"><div align="center">Linea</div></td>
      <td width="166" bgcolor="#CCCCCC" class="style17"><div align="center">Asociar</div></td>
    </tr>
    <?
		$color=="#D9FFB3";
		$i=1;
		while($row=mysql_fetch_array($result)){
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
<? 
		$inferior++;
		echo $row['id'];
?>
      </font>
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?= $row['id'];?>" />
      </div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["id_prod"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["descripgral"]; ?>
      </font> </div></td>
      <td bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["especificacion"]; ?>
      </font></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["linea"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>">
      		<div align="center">
            	<font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
                	<a href="javascript:popUp('prodxprov.php?id=<?=$row["id"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=2";?>')">ver</a> | 
      				<!--<a href="javascript:popUp('prodxalm.php?id=<?=$row["id"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=100";?>')">-->
					<a href="javascript:popUp('cat_prov1.php?id_prod=<?=$row["id_prod"];?>&action=asignar_a_proveedor')">proveedor</a>
					
					<!--</a>--> | 
				</font>
	  				<span class="style19">
						<a href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a>
					</span>
			</div>
	  </td>
    </tr>
    <?
			if ($color=="#D9FFB3") 
				$color="#FFFFFF";
			else 
				$color="#D9FFB3";
		$i=$i+1;
		}
?>
  </table>
</form>
  <?
			}
		}
		break;
		default:{	//Asocia producto con proveedor
			//include("../php/conectarbase.php");
			$result3=mysql_db_query($sql_db,"SELECT count(id)as n FROM catprod");//numero de registros de BD
			$result2=mysql_db_query($sql_db,"SELECT ((count(id)) DIV (100))+1 as m FROM catprod");// numero de paginas DB
			$row3=mysql_fetch_array($result3); // numero de reg
			$row2=mysql_fetch_array($result2); // numero de pag
			$paginas=$row2["m"];
			echo "<div align='left'>Numero de Registros: ".$row3["n"]."</div><br>";
			$k=1;
			while($k<=$paginas){
				$limsup[$k]=$k*100;
				$liminf[$k]=$limsup[$k]-99;
				//echo "|".$liminf[$k];
				//echo "<->".$limsup[$k];
				echo "<span class='Estilo2'><a href='cat_product.php?op=100&pag=$k'>".$k."</a></span> | ";
				$k=$k+1;
			}
			$numpag=$_GET["pag"];
			if($numpag=="") $numpag=1;
			//echo $liminf[$numpag]."<-->".$limsup[$numpag];
			$inferior=($liminf[$numpag])-1;
			$sql="SELECT catprod.id, catprod.id_prod, catprod.descripgral, catprod.especificacion, lineas.descripcion FROM catprod, lineas WHERE lineas.linea=catprod.linea ORDER BY catprod.id LIMIT ".$inferior.",100";
			//$sql_alm="SELECT * FROM tipoalmacen";
			//$liminf[$numpag] 
			//echo $sql;
			$result=mysql_db_query($sql_db,$sql);
			//$r_alm=mysql_db_query($sql_db,$sql_alm);
?>
  <br /><br /><table width="801" border="0" align="center" cellspacing="1">
    <tr>
      <td colspan="6" bgcolor="#333333" class="style6"><div align="center"><strong>Listado de Items Almacen</strong></div></td>
    </tr>
    <tr>
      <td width="37" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>#</strong></div></td>
      <td width="89" bgcolor="#CCCCCC" class="style17"><div align="center">NumParte Almacen</div></td>
      <td width="317" bgcolor="#CCCCCC" class="style17"><strong>Descripcion</strong></td>
      <td width="91" bgcolor="#CCCCCC" class="style17"><div align="center"><strong>Especificacion</strong></div></td>
      <td width="83" bgcolor="#CCCCCC" class="style17"><div align="center">linea</div></td>
      <td width="165" bgcolor="#CCCCCC" class="style17"><div align="center">asociar</div></td>
    </tr>
<?
			$color=="#D9FFB3";
			$i=1;
			while($row=mysql_fetch_array($result)){
?>
    <tr>
      <td height="20" bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
<?
		echo $inferior++; //."--".$row[0];
		
?>			</font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
          <?= $row["id_prod"]; ?></font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["descripgral"]; ?></font> </div></td>
      <td bgcolor="<? echo $color; ?>"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["especificacion"]; ?></font></td>
      <td bgcolor="<? echo $color; ?>"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
        <?= $row["descripcion"]; ?>
      </font></div></td>
      <td bgcolor="<? echo $color; ?>"><div align="center" class="style21"><font face="Verdana, Arial, Helvetica, sans-serif"><span class="style20"><a href="javascript:popUp('prodxprov.php?id=<?=$row["id_prod"]."&id_prod=".$row["id_prod"]."&desc=".$row['descripgral']."&op=2";?>')">ver</a> | 
	  <a href="javascript:popUp('cat_prov1.php?id_prod=<?=$row["id_prod"];?>&action=asignar_a_proveedor')">proveedor</a>
	  </span></font><span class="style20"> | </span><span class="style19"><a href="javascript:popUp('prodxalm.php?id=<?=$row["id_prod"]."&desc=".$row['descripgral'];?>')">almacen</a></span></div></td>
    </tr>
<?
				if ($color=="#D9FFB3") 
					$color="#FFFFFF";
				else 
					$color="#D9FFB3";
					$i=$i+1;
			}	
?>
  </table>
  <p>
<?
		}
		break;
		case 3:{
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				/*   Asociando Proveedores con pruductos---Dispercion de productos por proveedor
				/* ----------------------------------Segunda Parte ------------------------------------
				/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
				$id_prod=$_GET['id'];
				$descrip=$_GET['des'];
				if(!$_POST){
?>
				<form id="form2" name="form2" method="post" action="cat_product.php?op=3">
    				<table width="474" height="241" border="0" align="center">
      					<tr>
        					<td bgcolor="#CCCCCC"><!---->
            					<fieldset>
            						<legend class="Estilo1">Asociar Proveedor con Producto: <?= $id_prod.".-".$descrip;?></legend>
              							<input type="hidden" name="id_prod" value="<?=$id_prod;?>" />
										<table width="200" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF">
              								<tr>
               									<td bgcolor="#333333" class="Estilo11">&nbsp;</td>
              								</tr>
<?
									  		//se listan los almacenes
				  							//include("../php/conectarbase.php");
				  							$sql="Select * from catprovee";
				  							$resultado=mysql_db_query($sql_db,$sql);
?>
											<tr>
                								<td><select name="select" size="8" multiple="multiple">
<?
													while($fila=mysql_fetch_array($resultado)){
?>
														<option value="<?=$fila[0];?>" id=""<?=$fila[0];?>""><?=$fila[0].".-".$fila[1];?></option>
<?
													}
?>
													</select>
												</td>
											</tr>
										</table>
									<input type="submit" name="Submit2" value="Asociar" />
           						</fieldset>
							</td>
						</tr>
    				</table>
				</form>
<?
				}
				else{
//print_r($_POST);
// ........ Asignar a proveedor ................................................
		$id_prod=$_POST["id_prod"];
		$id_prov=$_POST["select"];
			// verificar si el prov ya ha sido aignado al producto ...
			$sql_ya_asignado="SELECT * FROM prodxprov where id_prod='$id_prod' and id_prov='$id_prov' ";
			$result7=mysql_db_query($sql_db,$sql_ya_asignado);
			//$row7=mysql_fetch_array($result0);
			$numeroRegistros7=mysql_num_rows($result7);
			mysql_free_result($result7);
				if ($numeroRegistros7>0)
				{ // si existe, enviar mensaje al usuario que el pro ya ha sido asignado ...
				//$mensaje="El Producto ya esta asignado al Proveedor";
				} else {
				// Insertamos el registro en la tabla prodxprov ...
				$sql_insertar_asignacion="INSERT INTO prodxprov (id_prod,id_prov) VALUES ('$id_prod','$id_prov')";
					if (mysql_db_query($sql_db,$sql_insertar_asignacion))
					$mensaje="El producto fue asignado al proveedor correctamente";
					else
					$mensaje="Error de Sintaxis SQL: El Producto no fue asignado al Proveedor";
					
				}
					echo '<table width="228" border="0" align="center" cellspacing="0">
    				<tr><td width="226" bgcolor="#333333">&nbsp;</td></tr>
					<tr><td><div align="center" class="style18">Datos Guardados Correctamente</div></td></tr>
    				<tr><td bgcolor="#333333">&nbsp;</td>
    				</tr></table>';

		echo "<script language=\"javascript\" type=\"text/javascript\">
		alert(\"$mensaje\");
		window.location.href='cat_product1.php'; 
		</script>";

// ........ Asignar a proveedor ................................................											
					}	
					//echo $valores;
				//}// fin if else
		}// fin case 3
	}//fin switch
?>
  </p>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
<hr align="center" />
<p align="center" class="Estilo5">IQelectronics 2008</p>
</body>
</html>