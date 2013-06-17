<?php
class kardex{
	function __construct($id_producto){
		$this->ver_kardex($id_producto);
	}
	function ver_kardex($id_producto){
		//echo "<br>ver_kardex($id_producto)";
		//echo "<br>".
		$sql_cardex="SELECT 
		mov_almacen.id_mov, mov_almacen.oc, concepmov.id_concep, concepmov.concepto,concepmov.tipo,concepmov.asociado as asociado0,mov_almacen.asociado,mov_almacen.almacen, mov_almacen.fecha, prodxmov.id as id_item, prodxmov.cantidad, prodxmov.existen, prodxmov.cu, prodxmov.ubicacion, catprod.id_prod, catprod.descripgral
		FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov = concepmov.id_concep) INNER JOIN (catprod INNER JOIN prodxmov ON catprod.id_prod = prodxmov.clave) ON mov_almacen.id_mov = prodxmov.nummov
		WHERE (((catprod.id)='$id_producto')) 
		ORDER BY mov_almacen.fecha ASC,prodxmov.id ASC";		
		
		include ("../../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql_cardex,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				/*
				while($reg=mysql_fetch_array($res)){
					echo "<br><br>"; 	print_r($reg);
					//return $reg[0];
				}
				*/
			}else{ die("<h3>El producto : $id_producto &rarr; NO presenta movimientos.</h3>"); }
		} else{ die("<h3><br>Error SQL (".mysql_error($link).").</h3>");	}
				
		?>
		<!--<div style="text-align:center; font-weight:bold; padding:5px; font-size:large; ">kardex del producto : <?=$id_producto?></div>//-->
		<div style="position:relative; margin:10px;">
		<h3>kardex del producto : <?=$id_producto?></h3>
		<table width="670" align="center" cellpadding="1" cellspacing="0">
		<tr>
			<!--<th>#</th>//-->
			<th>mov</th>
			<th>fecha</th>
			<th>tipo</th>
			<th>almac&eacute;n</th>
			<th>asociado</th>
			
			<th>ubicaci&oacute;n</th>
			<th>cantidad</th>
			<th>existen</th>
			<th>$ CU</th>
		</tr>
		<?php 
		$suma_subtotal=0;
		while($reg=mysql_fetch_array($res)){ 
			//echo "<br><br>"; 	print_r($reg);
			if ($reg["tipo"]=="Ent"){
				$color="black";
				$simbolo='+';
				$total_entradas+=$reg["cantidad"];
				$total_existen+=$reg["existen"];
				if($reg["existen"]>0){
					$suma_subtotal+=($reg["existen"]*$reg["cu"]);
				}
				$campo_existen=$reg["existen"];
			} elseif ($reg["tipo"]=="Sal"){
				$simbolo='-';
				$campo_existen='&nbsp;';
				$color="red";
			} else {
				$simbolo='';
			}
			$almacen_descripcion=$this->dame_primer_campo("SELECT almacen FROM tipoalmacen WHERE id_almacen='".$reg["almacen"]."' LIMIT 1; ");			
			
			// Controlar los asociados ...
			$campo_oc='';
			if($reg["asociado0"]=='Ninguno'){
				$campo_asociado=" &nbsp; ";
			}elseif($reg["asociado0"]=='Almacenes'){
				$campo_asociado="Almac&eacute;n ".$reg["asociado"];
			}elseif($reg["asociado0"]=='Proveedor'){
				$campo_asociado="Proveedor ".$reg["asociado"];
				$campo_oc=" (OC:".$reg["oc"].")";
								
			}else{
				$campo_asociado=$reg["asociado0"]." ".$reg["asociado"];
			}
			
			// Colocar la OC ...
			//if()
			
		?>
		<tr onMouseOver="this.style.background='#D9FFB3'" onMouseOut="this.style.background='#ffffff'">
			<!--<td align="center"><?=$reg["id_item"]?></td>//-->
			
			<td align="center"><?=$reg["id_mov"]?></td>
			<td align="center"><?=$reg["fecha"]?></td>
			
			<td><?=$reg["concepto"]." ".$campo_oc?></td>
			<td> <a href="#" title="<?=$almacen_descripcion?>"><?=$reg["almacen"]?> <?=substr($almacen_descripcion,0,7)?></a></td>
			<td><?=$campo_asociado?></td>
			
			<td><?=$reg["ubicacion"]?></td>
			<td align="right" style="color:<?=$color?>;"><?=$simbolo.$reg["cantidad"]?></td>
			<td align="right"><?=$campo_existen?></td>
			<td align="right"><?=number_format($reg["cu"],2,'.',',')?></td>
		</tr>	
		<?php } ?>
		<tr style="font-weight:bold; text-align:right; background-color:#efefef;">
		  <td colspan="6">Total &rarr;</td>
		  <td><?=$total_entradas?></td>
		  <td><?=$total_existen?></td>
		  <td>$<?=number_format($suma_subtotal,2,'.',',')?></td>
		  </tr>		
		</table>
		</div>
		<?php
		
	}
	
	// =======================================
	function dame_no_resultados($sql){
		include ("../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql,$link)){ 
			return mysql_num_rows($res);
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}
	function dame_primer_campo($sql){
		include ("../conf/conectarbase.php");
		if ($res=mysql_db_query($sql_db,$sql,$link)){ 
			$ndr=mysql_num_rows($res);
			if($ndr>0){	
				while($reg=mysql_fetch_array($res)){
					//echo "<br>"; 	print_r($reg);
					return $reg[0];
				}
			}else{ return " "; }
		} else{ return "<br>Error SQL (".mysql_error($link).").";	}		
	}	
}
?>
