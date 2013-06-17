<?php
class comportamiento{
	var $year;
	var $meses;
	
	var $bd_x;
	var $linkC;
	function __construct($id_producto){
		/*
		$this->year='2011';
		$this->bd_x='2011_iqe_inv';
		
		$this->year='2010';
		$this->bd_x='iqe_inv_2010';
		

		*/

		/*
		$this->meses=array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');
		
		
		$this->meses=array('01'=>'En','02'=>'Fe','03'=>'Ma','04'=>'Ab','05'=>'Ma','06'=>'Jn','07'=>'Jl','08'=>'Ag','09'=>'Se','10'=>'Oc','11'=>'No','12'=>'Di');		
		*/
		$this->meses=array('01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic');		
		$this->year='2013';
		$this->g1($id_producto);
	}
	function g1($id_producto){
		//echo "<hr>g1($id_producto)";
		$producto_clave=$this->dame_primer_campo("SELECT id_prod FROM catprod WHERE id='$id_producto' LIMIT 1; ");
		$producto_descripcion=$this->dame_primer_campo("SELECT descripgral FROM catprod WHERE id='$id_producto' LIMIT 1; ");
		$producto_especificacion=$this->dame_primer_campo("SELECT especificacion FROM catprod WHERE id='$id_producto' LIMIT 1; ");
		$stock_minimo=$this->dame_primer_campo("SELECT stock_min FROM catprod WHERE id='$id_producto' LIMIT 1; ");
		$stock_maximo=$this->dame_primer_campo("SELECT stock_max FROM catprod WHERE id='$id_producto' LIMIT 1; ");
		
		$xml_mi_grafica.='<chart caption="Comportamiento : '.$id_producto.' &quot;'.$producto_descripcion.'&quot; en '.$this->year.' " palette="1" showValues="0" yAxisValuesPadding="10">';		
		$xml_categorias='<categories>';
			
				$xml_mi_grafica.='<trendlines><line startValue="'.$stock_maximo.'" endValue="'.$stock_maximo.'" color="ff0000" displayValue="St. Max" dashed="1" thickness="1" dashGap="6" alpha="100" showOnTop="1" parentYAxis="S" /></trendlines>';
							
			$xml_entradas='<dataset seriesname="Entradas" color="009900" alpha="60">';
			$xml_salidas='<dataset seriesname="Salidas" color="FF3300" alpha="60">';
			
			$xml_existencias='<dataset seriesName="Existencias" renderAs="Line" color="0000FF" >';
			
		?>
		<div id="div_graficaX" align="center" style="margin-top:7px;">&nbsp;</div>
		<?php
		
		$acumulado_mes_anterior=0;
		foreach($this->meses as $mes_ind => $mes_desc){
			//echo "<br>$mes_ind => $mes_desc";
			$sql_entradas="SELECT
				sum(prodxmov.cantidad) AS cantidad_total
			FROM mov_almacen, prodxmov, concepmov 
			WHERE 
				prodxmov.id_prod='$id_producto'
				
				AND  mov_almacen.id_mov=prodxmov.nummov
				AND mov_almacen.tipo_mov=concepmov.id_concep
				AND concepmov.tipo='Ent'
				AND mov_almacen.almacen=1
				
				AND mov_almacen.fecha BETWEEN '".$this->year."-$mes_ind-01' AND '".$this->year."-$mes_ind-31'
			; ";

			$sql_salidas="SELECT
				sum(prodxmov.cantidad) AS cantidad_total
			FROM mov_almacen, prodxmov, concepmov 
			WHERE 
				prodxmov.id_prod='$id_producto'
				
				AND  mov_almacen.id_mov=prodxmov.nummov
				AND mov_almacen.tipo_mov=concepmov.id_concep
				AND concepmov.tipo='Sal'
				AND mov_almacen.almacen=1
				
				AND mov_almacen.fecha BETWEEN '".$this->year."-$mes_ind-01' AND '".$this->year."-$mes_ind-31'
			; ";
			$total_entradas=$this->dame_primer_campo($sql_entradas);
			$total_absoluto_entradas=$total_entradas+$acumulado_mes_anterior;
			
			$total_salidas=$this->dame_primer_campo($sql_salidas);						
			$total_existencias=$total_absoluto_entradas-$total_salidas;
			
			if(date("m")<$mes_ind){
				$acumulado_mes_anterior=0;
				$total_absoluto_entradas=0;
				$total_existencias=0;
						
				$xml_categorias.='<category label="'.$mes_desc.'" />';
				$xml_entradas.='<set value="" />';			
				$xml_salidas.='<set value="" />';			
				$xml_existencias.='<set value="" />';
			}else{
				$xml_categorias.='<category label="'.$mes_desc.'" />';
				$xml_entradas.='<set value="'.$total_entradas.'" />';			
				$xml_salidas.='<set value="'.$total_salidas.'" />';			
				$xml_existencias.='<set value="'.$total_existencias.'" />';
			}
			
				/*
				$xml_categorias.='<category label="'.$mes_desc.'" />';
				$xml_entradas.='<set value="'.$total_absoluto_entradas.'" />';			
				$xml_salidas.='<set value="'.$total_salidas.'" />';			
				$xml_existencias.='<set value="'.$total_existencias.'" />';
				*/

			/*
			if(date("m")>$mes_ind){
				$total_existencias=0;
				$total_absoluto_entradas=0;
			}
			*/			
			/*
			<br /><?="[".date("m")."][$mes_ind]"?>
			*/
			$acumulado_mes_anterior=$total_existencias;
		}

			$xml_categorias.="</categories>";
			$xml_existencias.="</dataset>";
			$xml_entradas.="</dataset>";
			$xml_salidas.="</dataset>";
				// Agregar las categorias ...
				$xml_mi_grafica.=$xml_categorias;
				$xml_mi_grafica.=$xml_entradas;
				$xml_mi_grafica.=$xml_salidas;
				$xml_mi_grafica.=$xml_existencias;
				$xml_mi_grafica.='<trendlines><line startValue="'.$stock_minimo.'" endValue="'.$stock_minimo.'" color="333333" displayValue="St. Min" dashed="1" thickness="1" dashGap="6" alpha="100" showOnTop="1" parentYAxis="S" /></trendlines>';
			$xml_mi_grafica.="</chart>";
			//echo "<br>(".htmlentities($xml_mi_grafica).")";
			?>
			<script type="text/javascript">
			  var myChart = new FusionCharts("../comportamiento/swf/MSColumnLine3D.swf", "div_graficaX", "600", "385", "0", "0");
			  myChart.setDataXML('<?=$xml_mi_grafica?>');
			  myChart.setTransparent(true);
			  myChart.render("div_graficaX");
			</script>				
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