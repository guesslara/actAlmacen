<?php 
class asociacion_producto_almacen {
var $id_producto; var $id_almacenes=array(); var $existencias; var $transferencias; // ----------------------------------

	function __construct($id_producto){
	$this->id_producto=$id_producto;
		// conectar a BD y extraer valores...
		include("../php/conectarbase.php");
		$sql="SHOW COLUMNS FROM catprod FROM ".$sql_db." LIKE 'a_%' ";
		$result=mysql_query($sql);
		$i2 = 1;
  		while ($row=mysql_fetch_array($result)) 
		{	//determinando almacenes asociados
			$alm7=$row[0];
			$sql_alm7="SELECT count(id_prod) as existe FROM catprod WHERE id_prod='".$this->id_producto."' and `$alm7`='1'";
			$res7=mysql_db_query($sql_db,$sql_alm7);
			$row7=mysql_fetch_array($res7);
			if($row7[0]=='1')
				array_push($this->id_almacenes,$i2);
		$i2++;
		} 		// conectar a BD y extraer valores...		
	} // ------------------------------------------------------------------------
	public function get_almacenes_asociados()
	{
	return $this->id_almacenes;
	}
	
	//---------------------------------------------------------------------------
	public function get_existencias()
	{
		include("../php/conectarbase.php");
		$aaso=$this->get_almacenes_asociados();
		//print_r($aaso);
		$array1=array();	
			foreach ($aaso as $id_almacen)
			{
			$c_exist='exist_'.$id_almacen;
			$c_trans='trans_'.$id_almacen;
				$result=mysql_query("SELECT $c_exist,$c_trans FROM catprod WHERE id_prod='".$this->id_producto."' ");
  				while ($row=mysql_fetch_array($result)) 
				{
				$this->existencias+=$row[$c_exist];
				$this->transferencias+=$row[$c_trans];
				
				}
			}
	//echo "<BR>[".$this->id_producto."] Exist:(".$this->existencias.") Transf: (".$this->transferencias.")";
	array_push($array1,$this->existencias);
	array_push($array1,$this->transferencias);
	
	//print_r($array);
	return $array1;
	}
	
	
} // ****************************************************************************
 ?>