<?php 
class traspaso{
var $nummov; 						var $mov; 							var $idtipomov;
var $idasociado; 					var $cantidad; 						var $clave;
var $descripcion; 					var $cu;							var $idalmacen;
var $almacen; 						var $asociado;

var $st_min; 						var $st_max; 						var $exist_1;
var $exist_2; 						var $trans_1; 						var $trans_2;
var $existencias_1; 				var $existencias_2; 				var $campo_almacen_origen;
var $campo_existencias_origen; 		var $campo_tranferencia_origen;		var $campo_almacen_destino;
var $campo_existencias_destino;   	var $campo_tranferencia_destino; 	var $valores_traspaso=array(); // ceo, ctd ...
// -----------------------------------------------------------------------------------
	function __construct($nummov,$mov,$idtipomov,$idasociado,$cantidad,$clave,$descripcion,$cu,$idalmacen,$almacen,$asociado)
	{
	$this->nummov=$nummov;				$this->mov=$mov;			$this->idtipomov=$idtipomov;
	$this->idasociado=$idasociado; 		$this->cantidad=$cantidad;	$this->clave=$clave;
	$this->descripcion=$descripcion;	$this->cu=$cu;				$this->idalmacen=$idalmacen;	
	$this->almacen=$almacen;			$this->asociado=$asociado;	
	
	$this->campo_almacen_origen="a_".$this->idalmacen."_".$this->almacen;  		$this->campo_existencias_origen="exist_".$this->idalmacen;
	$this->campo_tranferencia_origen="trans_".$this->idalmacen; 				$this->campo_almacen_destino="a_".$this->idasociado."_".$this->asociado;
	$this->campo_existencias_destino="exist_".$this->idasociado;				$this->campo_tranferencia_destino="trans_".$this->idasociado;
	}
// -----------------------------------------------------------------------------------	
	protected function comprobar_alamacenes_asociados()
	{ //echo '<br><br>Comprobar si los almacenes estan asociados:<br><br>';
		$id_prod=$this->clave;												$campo_almacen_origen="a_".$this->idalmacen."_".$this->almacen;
		$campo_existencias_origen="exist_".$this->idalmacen;				$campo_tranferencia_origen="trans_".$this->idalmacen;
		$campo_almacen_destino="a_".$this->idasociado."_".$this->asociado;	$campo_existencias_destino="exist_".$this->idasociado;
		$campo_tranferencia_destino="trans_".$this->idasociado;
include("../php/conectarbase.php");
$result = mysql_db_query($sql_db,"select id_prod,$campo_almacen_origen,$campo_existencias_origen,$campo_tranferencia_origen,$campo_almacen_destino,$campo_existencias_destino,$campo_tranferencia_destino,stock_min,stock_max
from catprod where id_prod='$id_prod'
");
		if (!$result) {
     	echo 'Error SQL: ' . mysql_error();
     	exit;
 		}
 		
		if (mysql_num_rows($result) > 0) {
    	 	while ($row = mysql_fetch_array($result)) {
         	$alm_1=$row["$campo_almacen_origen"];
			$this->exist_1=$row["$campo_existencias_origen"];
			$this->trans_1=$row["$campo_tranferencia_origen"];
			$alm_2=$row["$campo_almacen_destino"];
			$this->exist_2=$row["$campo_existencias_destino"];
			$this->trans_2=$row["$campo_tranferencia_destino"];
			$this->st_min=$row["stock_min"];
			$this->st_max=$row["stock_max"];
			$this->existencias_1=($this->exist_1)-($this->cantidad);
	 		}
		
			if ($alm_1==1&&$alm_2==1)
				$stop1=true;
			else { 
				echo "<br>Error: El Almacen origen y Almacen Destino NO estan asociados.";
				exit();
				return false;
			} 
				
			if ($this->cantidad<=$this->exist_1)
			{ 
				$stop2=true;
				//echo "<br>b) La cantidad a traspasar existe en el almacen"; 
			} else { 
echo "<img src='img/s_warn.png' border='0'>&nbsp;Error: La cantidad a traspasar es mayor a las existencias en almacen (".$this->almacen.")";
				//exit();
				return false;
			}
		//echo "<br>SMIN [".$this->st_min."] SMAX [".$this->st_max."]<br>EXIST1 [".$this->exist_1."] TRANS 2 [".$this->trans_2."] CANTIDAD [".$this->cantidad."]";	
		if (($this->exist_1)-($this->cantidad)<$this->st_min)
			echo "<img src='img/icon-error.gif' border='0'>&nbsp;Alerta: Se ha superado el nivel de Stock Minimo del producto (".$this->clave.") en el almacen: <b>".$this->almacen."</b> "; 
		if  (($this->exist_1)-($this->cantidad)==$this->st_min) 
			echo "<br><br><img src='img/icon-error.gif' border='0'>&nbsp;Alerta: Esta proximo a superar el nivel de Stock Minimo del producto (".$this->clave.") en el almacen: <b>".$this->almacen."</b>"; 
				
		if (($this->exist_2+$this->trans_2+$this->cantidad)==$this->st_max)
			echo "<br><br><img src='img/icon-error.gif' border='0'>&nbsp;Alerta: Esta proximo a superar el nivel de Stock Maximo del producto (".$this->clave.") en el almacen: <b>".$this->asociado."</b> "; 
		if (($this->exist_2+$this->trans_2+$this->cantidad)>$this->st_max) 
			echo "<br><br><img src='img/icon-error.gif' border='0'>&nbsp;Alerta: Se ha superado el nivel de Stock Maximo del producto (".$this->clave.") en el almacen: <b>".$this->asociado."</b>"; 
			
		if ($stop1==true&&$stop2==true)
			return true;
		} // termina if >0
	} // termina function --------------------------------------------------------------------
	
	public function traferir_producto()
	{
    	$tof=$this->comprobar_alamacenes_asociados();
		if ($tof)
		{
		$n_trans_destino=$this->trans_2+$this->cantidad;
		$n_exist_origen=($this->exist_1)-($this->cantidad);
		$c_exi_ori=$this->campo_existencias_origen;
		$c_tra_des=$this->campo_tranferencia_destino;	
			array_push($this->valores_traspaso,$c_exi_ori); 
			array_push($this->valores_traspaso,$n_exist_origen);
			array_push($this->valores_traspaso,$c_tra_des);
			array_push($this->valores_traspaso,$n_trans_destino);	
		return $this->valores_traspaso;
		} 
		
	} // termina function --------------------------------- 
} // Termina la clase =============================================================================================
if ($_POST['action']=='traspaso')
{
//print_r($_POST);
$nummov=$_POST['NumMov']; 				$mov=$_POST['mov'];			$idtipomov=$_POST['idtipomov'];
$idasociado=$_POST['idasociado'];		$cantidad=$_POST['can'];	$clave=$_POST['clave'];
$descripcion=$_POST['des'];				$cu=$_POST['cu'];			$idalmacen=$_POST['idalmacen'];
$almacen=$_POST['almacen'];				$asociado=$_POST['asociado'];
	$traspaso1=new traspaso($nummov,$mov,$idtipomov,$idasociado,$cantidad,$clave,$descripcion,$cu,$idalmacen,$almacen,$asociado);
	$valores_traspaso=$traspaso1->traferir_producto();
	//print_r($valores_traspaso);
	//echo "<hr>";
	if (count($valores_traspaso)>0) {
		//echo "<br><hr><br>"; //print_r($valores_traspaso);
		//echo "<br>E Origen [".$valores_traspaso[0]."] valor [".$valores_traspaso[1]."] <br> T Destino [".$valores_traspaso[2]."] valor [".$valores_traspaso[3]."]";
		include("../php/conectarbase.php");
		$sql_tr="UPDATE catprod SET ".$valores_traspaso[0]." ='".$valores_traspaso[1]."',".$valores_traspaso[2]."='".$valores_traspaso[3]."' where id_prod='".$clave."' ";
			//echo "<br>SQL [$sql_tr] ***<br>";
		if (mysql_db_query($sql_db,$sql_tr)) 
		{
			echo '<br><br>El TRASPASO del producto ('.$clave.') se realizo correctamente.<input type="hidden" name="resultado_traspaso" value="1" />';
			//----------------------------------------------------------------------------------------------------------------
			$sqlidx="select * from catprod where id_prod='".$clave."'";
			$residx=mysql_db_query($sql_db,$sqlidx);
			$idx=mysql_fetch_array($residx);
			$id=$idx['id'];
			$val="values ('".$nummov."','".$id."','".$cantidad."','".$clave."','".$cu."')";
			$SQL2="INSERT INTO prodxmov (nummov,id_prod,cantidad,clave,cu) ". $val;
			//echo "<br>SQL prodxmov [$SQL2]<BR>";
			if(!mysql_db_query($sql_db,$SQL2))
				echo "<br>Error al guardar";
			else
				echo "<br><br>Producto Agregado al movimiento";
			// ---------------------------------------------------------------------------------------------------------------
		} else
			echo '<br>Error SQL: Error de sintaxis. <input type="hidden" name="resultado_traspaso" value="0" />';
	} else {
	echo '<br><br><img src="img/s_warn.png" border="0">&nbsp;Error: El traspaso no se realizo. <input type="hidden" name="resultado_traspaso" value="0" />';
	}		
} ?>
