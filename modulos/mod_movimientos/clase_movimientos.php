<?php 
class movimientos{
	var $idm;
	var $id_tipo_mov; 					var $con_mov; 						var $fec_mov;
	var $idasociado; 					var $cantidad; 						var $clave;
	var $descripcion; 					var $cu;							var $idalmacen;		var $tipo;
	var $almacen; 						var $asociado0;						var $id_p;			var $clavep;
	var $sql_prodxmov;					var $sistema_costeo; 	// 1=CP, 2=PEPS, 3=UEPS
	//=====================================================================================================================
	function __construct($idm,$id_producto,$cantidad,$clave,$cu){
		$this->idm=$idm;
		$this->id_p=$id_producto;
		$this->cantidad=$cantidad;
		$this->clavep=$clave;
		$this->cu=$cu;		
		include ("../conf/conectarbase.php");
		//$this->sistema_costeo=$sistema_costeoX;
		$this->sistema_costeo="PEPS";
		//echo "<br><br>Has instanciado la clase movimientos (".$this->idm.")<br><hr>"; 
		$sql1="SELECT mov_almacen.*,concepmov.id_concep,concepmov.concepto,concepmov.cuenta,concepmov.asociado as asociado0,concepmov.tipo FROM mov_almacen,concepmov WHERE mov_almacen.tipo_mov=concepmov.id_concep AND mov_almacen.id_mov='".$this->idm."'";
		$r1=mysql_db_query($sql_db,$sql1);
		while ($ro1=mysql_fetch_array($r1)){
			//echo "<br>"; 			print_r($ro1); 				echo "<hr><br>";
			$this->id_tipo_mov=$ro1["tipo_mov"];
			$this->con_mov=trim($ro1["concepto"]);
			$this->id_almacen=$ro1["almacen"];
			$this->asociado0=$ro1["asociado0"];
			$this->id_asociado=$ro1["asociado"];
			$this->tipo=$ro1["tipo"];
			//echo "<br>TIPO MOV [".$this->id_tipo_mov."] CONCEPTO [".$this->con_mov."] ID ALMACEN [".$this->id_almacen."] ID ASOCIADO [".$this->id_asociado."] ASOCIADO 0 [".$this->asociado0."][]<BR>";

		}		
	}
	//=====================================================================================================================
	public function mueve_producto($sql_prodxmov){
		//echo "<br>Recibo sentencia sql [".
		$this->sql_prodxmov=$sql_prodxmov;
		//echo "<br>Movimiento de (".$this->con_mov."): <br>Mov ($idm) Producto ($id_producto) Cantidad ($cantidad) Clave ($clave) CU ($cu)<br>"; 
		//if ($idm!==$this->idm) exit();
		switch ($this->con_mov){
			case "Compras":
				if ($resultado=$this->m_compras()){
					echo "<li>El movimiento de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(1);
					return false;
				}				
				break;
			case "Inventario Inicial":
				if ($resultado=$this->m_i_inv()){
					echo "<li>El movimiento de Inventario Inicial del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(2);
					return false;
				}				
				break;
			case "Dev venta":
				if ($resultado=$this->m_dev_ventas()){
					echo "<li>El movimiento de Devolucion sobre Ventas del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(3);
					return false;
				}				
				break;
			case "Ajuste":
				if ($resultado=$this->m_ajuste()){
					echo "<li>El movimiento de Ajuste del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(4);
					return false;
				}				
				break;
			case "Refurbish":
				if ($resultado=$this->m_refurbish()){
					echo "<li>El movimiento de Refurbish del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(30);
					return false;
				}				
				break;
			//Rechazo Refurbish	
			case "Rechazo Refurbish":
				if ($resultado=$this->m_rechazo_refurbish()){
					echo "<li>El movimiento de Rechazo Refurbish del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(35);
					return false;
				}				
				break;				
				
				
			case "Entrada x Traspaso":
				if ($resultado=$this->m_ext()){
					echo "<li>El movimiento de Entrada x Traspaso del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(6);
					return false;
				}				
				break;
			case "Canc de Compra":
				if ($resultado=$this->m_cdc()){
					echo "<li>El movimiento de Canc de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();
					return true;
				} else {
					$this->error(7);
					return false;
				}				
				break;
			case "Dev Compras":
				if ($resultado=$this->m_ddc()){
					echo "<li>El movimiento de Devoluci&oacute;n de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(10);
					return false;
				}				
				break;
			case "Ventas":
				if ($resultado=$this->m_ven()){
					echo "<li>El movimiento de Ventas del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(11);
					return false;
				}				
				break;
			case "Merma":
				if ($resultado=$this->m_mer()){
					echo "<li>El movimiento de Merma del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(12);
					return false;
				}					
				break;
			case "Ajuste Menos":
				if ($resultado=$this->m_Ajuste_menos()){
					echo "<li>El movimiento de Ajuste (-) del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(36);
					return false;
				}					
				break;				
			case "Salida x Trasp":
				if ($resultado=$this->m_sxt()){
					echo "<li>El movimiento de Salida x Traspaso del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(13);
					return false;
				}					
				break;
			case "Sal. x Asignacion":
				if ($resultado=$this->m_sx_asignacion()){
					echo "<li>El movimiento de Salida x Asignacion del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(33);
					return false;
				}					
				break;				
			case "Reposicion por Rechazo":
				if ($resultado=$this->m_rxr()){
					echo "<li>El movimiento de Reposicion por Rechazo del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(31);
					return false;
				}					
				break;
			case "Rechazo a Proveedor":
				if ($resultado=$this->m_rap()){
					echo "<li>El movimiento de Rechazo a Proveedor del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(32);
					return false;
				}					
				break;
			case "Entrada x Resguardo":
				if ($resultado=$this->m_ent_resguardo()){
					echo "<li>El movimiento de Entrada x Resguardo del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(31);
					return false;
				}					
				break;
			case "Dev. de Asignacion":
				if ($resultado=$this->m_ent_dev_asignacion()){
					echo "<li>El movimiento de Entrada x Devolucion de Asignacion del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(31);
					return false;
				}					
				break;				
			case "Salida x Resguardo":
				if ($resultado=$this->m_sal_resguardo()){
					echo "<li>El movimiento de Rechazo a Proveedor del Producto (".$this->id_p.") se realizo correctamente.</li>";
					$this->m_validar_stock();
					$this->m_costeo();
					$this->m_inserta_producto();				
					return true;
				} else {
					$this->error(32);
					return false;
				}					
				break;
			default:
				echo "<br>&nbsp;Concepto desconocido.";
				break;																					
		}
		/*
		if ($this->con_mov=="Compras"){
			if ($resultado=$this->m_compras()){
				echo "<li>El movimiento de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(1);
				return false;
			}
		}elseif($this->con_mov=="Inventario Inicial"){
			//echo  "<br>Inventario Inicial ***";
			if ($resultado=$this->m_i_inv()){
				echo "<li>El movimiento de Inventario Inicial del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(2);
				return false;
			}			
		}elseif($this->con_mov=="Dev venta"){
			//echo  "<br>Inventario Inicial ***";
			if ($resultado=$this->m_dev_ventas()){
				echo "<li>El movimiento de Devolucion sobre Ventas del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(3);
				return false;
			}			
		}elseif($this->con_mov=="Ajuste"){
			//echo  "<br>Inventario Inicial ***";
			if ($resultado=$this->m_ajuste()){
				echo "<li>El movimiento de Ajuste del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(4);
				return false;
			}
		}elseif($this->con_mov=="Refurbish"){
			//echo  "<br>Refurbish ***";
			if ($resultado=$this->m_refurbish()){
				echo "<li>El movimiento de Refurbish del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(30);
				return false;
			}
		}elseif($this->con_mov=="Entrada x Traspaso"){
			if ($resultado=$this->m_ext()){
				echo "<li>El movimiento de Entrada x Traspaso del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(6);
				return false;
			}			
		}elseif($this->con_mov=="Canc de Compra"){
			if ($resultado=$this->m_cdc()){
				echo "<li>El movimiento de Canc de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();
				return true;
			} else {
				$this->error(7);
				return false;
			}			
		}elseif($this->con_mov=="Dev Compras"){
			if ($resultado=$this->m_ddc()){
				echo "<li>El movimiento de Devoluci&oacute;n de Compra del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(10);
				return false;
			}			
		}elseif($this->con_mov=="Ventas"){
			if ($resultado=$this->m_ven()){
				echo "<li>El movimiento de Ventas del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(11);
				return false;
			}			
		}elseif($this->con_mov=="Merma"){
			if ($resultado=$this->m_mer()){
				echo "<li>El movimiento de Merma del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(12);
				return false;
			}			
		}elseif($this->con_mov=="Salida x Trasp"){
			if ($resultado=$this->m_sxt()){
				echo "<li>El movimiento de Salida x Traspaso del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(13);
				return false;
			}			
		}elseif($this->con_mov=="Reposicion por Rechazo"){
			if ($resultado=$this->m_rxr()){
				echo "<li>El movimiento de Reposicion por Rechazo del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(31);
				return false;
			}			
		}elseif($this->con_mov=="Rechazo a Proveedor"){
			if ($resultado=$this->m_rap()){
				echo "<li>El movimiento de Rechazo a Proveedor del Producto (".$this->id_p.") se realizo correctamente.</li>";
				$this->m_validar_stock();
				$this->m_costeo();
				$this->m_inserta_producto();				
				return true;
			} else {
				$this->error(32);
				return false;
			}			
		}
		*/
	}
	//=====================================================================================================================
	protected function m_compras(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_venta="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_venta)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_i_inv(){
		include ("../conf/conectarbase.php");
		//echo "<hr>Movimiento de II Valores(Almacen [".$this->id_almacen."]  Producto [".$this->id_p."] Cantidad [".$this->cantidad."] Asociado0 [".$this->asociado0."])<hr><br>";
		$c_eX="exist_".$this->id_almacen;
		$sql_ii="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_ii)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_dev_ventas(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_dsv="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_dsv)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_ajuste(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_aju="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_aju)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_refurbish(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_aju="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_aju)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_rechazo_refurbish(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if ($this->m_validar_existencias()){
			$sql_aju="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_aju)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}			
	}	
	//------------------------------------------------------------------------------------------------	
	protected function m_ext(){
		include ("../conf/conectarbase.php");
		$c_tX="trans_".$this->id_almacen;
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto())	{ 	$this->error(9);	}		
		if ($this->m_validar_transferencias()){
			echo $sql_ext="UPDATE catprod SET $c_tX=$c_tX-".$this->cantidad.",$c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_ext)){
				echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Transferencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(5);
				return false;
			}
		} else {
			$this->error(14);
			exit();
		}		
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_ent_dev_asignacion(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto())	{ 	$this->error(9);	}		
		//if ($this->m_validar_transferencias()){
			echo $sql_ext="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_ext)){
				echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(5);
				return false;
			}
		/*
		} else {
			$this->error(14);
			exit();
		}
		*/		
	}	
	//=====================================================================================================================	
	protected function m_cdc(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto())	{ 	$this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}			
	//------------------------------------------------------------------------------------------------	
	protected function m_ddc(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ 	$this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_ven(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ $this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_mer(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ $this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_Ajuste_menos(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ $this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}	
	//$this->m_Ajuste_menos()	
	//------------------------------------------------------------------------------------------------	
	protected function m_sxt(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$c_tX="trans_".$this->id_asociado;
		if (!$this->m_validar_almacen_producto()){ 	$this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad.",$c_tX=$c_tX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.") en el Almacen (".$this->id_almacen.") y se agrego dicha cantidad a las Transferencias del Almacen (".$this->id_asociado.") .</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_sx_asignacion(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$c_tX="trans_".$this->id_asociado;
		if (!$this->m_validar_almacen_producto()){ 	$this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.") en el Almacen (".$this->id_almacen.") .</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}	
	//------------------------------------------------------------------------------------------------	
	protected function m_rxr(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_aju="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_aju)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_rap(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ $this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}	
	//------------------------------------------------------------------------------------------------	
	protected function m_ent_resguardo(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_aju="UPDATE catprod SET $c_eX=$c_eX+".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
		if (mysql_db_query($sql_db,$sql_aju)){
			echo "<br><li>Se agrego la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
			return true;
		} else {
			$this->error(0);
			return false;
		}	
	}
	//------------------------------------------------------------------------------------------------	
	protected function m_sal_resguardo(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		if (!$this->m_validar_almacen_producto()){ $this->error(9);	}
		if ($this->m_validar_existencias()){
			$sql_cdc="UPDATE catprod SET $c_eX=$c_eX-".$this->cantidad." WHERE id='".$this->id_p."' LIMIT 1";
			if (mysql_db_query($sql_db,$sql_cdc)){
				echo "<br><li>Se resto la cantidad (".$this->cantidad.") a las Existencias del Producto (".$this->id_p.").</li>";
				return true;
			} else {
				$this->error(0);
				return false;
			}
		} else {
			$this->error(8);
			exit();
		}	
	}		
	//=====================================================================================================================	
	protected function m_validar_almacen_producto(){
		include ("../conf/conectarbase.php");
		$sql_vap0="SELECT almacen from tipoalmacen WHERE id_almacen='".$this->id_almacen."' LIMIT 1";
		$r_vap0=mysql_db_query($sql_db,$sql_vap0);
		while ($ro_vap0=mysql_fetch_array($r_vap0)){
			$almacen=$ro_vap0["almacen"];
			$nc_almacen="a_".$this->id_almacen."_".$almacen;
		}
		$sql_vap1="SELECT $nc_almacen FROM catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vap1=mysql_db_query($sql_db,$sql_vap1);
		while ($ro_vap1=mysql_fetch_array($r_vap1)){
			$almacen_asociado=trim($ro_vap1["$nc_almacen"]);
		}		
		if ($almacen_asociado==1) return true; else return false;
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_existencias(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_vep="SELECT $c_eX from catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vep=mysql_db_query($sql_db,$sql_vep);
		while ($ro_vep=mysql_fetch_array($r_vep)){	$existencias=$ro_vep["$c_eX"];	}			
		if ($existencias>=$this->cantidad) return true; else return false;
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_transferencias(){
		include ("../conf/conectarbase.php");
		$c_tX="trans_".$this->id_almacen;
		$sql_vep="SELECT $c_tX from catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_vep=mysql_db_query($sql_db,$sql_vep);
		while ($ro_vep=mysql_fetch_array($r_vep)){	$transferencias=$ro_vep["$c_tX"];	}			
		if ($this->cantidad<=$transferencias) return true; else return false;
	}	
	//------------------------------------------------------------------------------------------------		
	protected function m_validar_stock(){
		include ("../conf/conectarbase.php");
		$c_eX="exist_".$this->id_almacen;
		$sql_sto="SELECT $c_eX,stock_min,stock_max FROM catprod WHERE id=".$this->id_p." LIMIT 1";
		$r_sto=mysql_db_query($sql_db,$sql_sto);
		while ($ro_sto=mysql_fetch_array($r_sto)){
			$exi=$ro_sto["$c_eX"];
			$smi=$ro_sto["stock_min"];
			$sma=$ro_sto["stock_max"];
			//echo "<br>Producto ".$this->id_p." existencias [$c_eX]=[$exi] Stock Min ($smi) Stock Max ($sma)";
		}			
		if ($exi<$smi) {
			echo "<b>&nbsp;Error 15: Las EXISTENCIAS ($exi) del producto (".$this->id_p.") son menores al STOCK MINIMO establecido ($smi).</b>";
		}
		if ($exi>$sma) {
			echo "<b>&nbsp;Error 16: Las EXISTENCIAS ($exi) del producto (".$this->id_p.") son mayores al STOCK MAXIMO establecido ($sma).</b>";
		}		
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_inserta_producto(){
		include ("../conf/conectarbase.php");
		//echo "<br>***...*** Insertar producto: [".$this->sql_prodxmov."]<br>";
		if ($this->sistema_costeo=="CP"){ 
			$sql_prodxmov2=$this->sql_prodxmov;
		} elseif ($this->sistema_costeo=="PEPS") {
			// La insercion Se ejecuta en el metodo: m_costeo()
			return true;
		} else {
			$this->error(20);
		}
		if (mysql_db_query($sql_db,$sql_prodxmov2)){
			echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
			?><script language="javascript">
				//document.frm1.reset();
			</script><?php
		} else {	$this->error(19);	}
	}
	//------------------------------------------------------------------------------------------------		
	protected function m_costeo(){
		include ("../conf/conectarbase.php");
		//$c_eX="exist_".$this->id_almacen;
		if ($this->sistema_costeo=="CP"){
			//echo "<b>&nbsp;SISTEMA DE COSTEO: $sistema_costeo.</b>";
			$sql_cp="SELECT cpromedio FROM catprod WHERE id=".$this->id_p." LIMIT 1";
			$r_cp=mysql_db_query($sql_db,$sql_cp);
			while ($ro_cp=mysql_fetch_array($r_cp)){
				$pcp=$ro_cp["cpromedio"];
			}
			($pcp>0)? $nvo_cp=($pcp+$this->cu)/2 : $nvo_cp=$this->cu;
			//echo "<br>Producto ".$this->id_p." cp [$pcp] nuevo cp [$nvo_cp]";
			$sql_actualiza_cp="UPDATE catprod SET cpromedio='$nvo_cp' WHERE id=".$this->id_p."  LIMIT 1";
			if (!mysql_db_query($sql_db,$sql_actualiza_cp)){	$this->error(0);	}
		} elseif ($this->sistema_costeo=="PEPS") {
			// ******************************************************************************************************************
			if ($this->tipo=="Ent"){ //AGREGAR $this->con_mov!=="Entrada x Traspaso"
				

				if ($this->con_mov=="Entrada x Traspaso"){
					//echo  "<br>vas a hacer una entrada x traspso con el metodo PEPS (Registrar las entradas a X costo.)<br>Consultar los movimientos de SXT del producto X y rellenar los costos.";
					$cantidades=array();
					$existen=array();
					$cus=array();
					$items=array();					
					//echo "<br><br>".
					$sql_cardex="SELECT mov_almacen.id_mov, concepmov.id_concep, concepmov.concepto,concepmov.tipo,concepmov.asociado as asociado0,mov_almacen.asociado,mov_almacen.almacen, mov_almacen.fecha, prodxmov.id as id_item, prodxmov.cantidad, prodxmov.existen, prodxmov.cu, catprod.id_prod, catprod.descripgral
					FROM (mov_almacen INNER JOIN concepmov ON mov_almacen.tipo_mov = concepmov.id_concep) INNER JOIN (catprod INNER JOIN prodxmov ON catprod.id_prod = prodxmov.clave) ON mov_almacen.id_mov = prodxmov.nummov
					WHERE (((catprod.id)='".$this->id_p."')) AND concepmov.concepto='Salida x Trasp' AND prodxmov.existen>0 AND mov_almacen.asociado=".$this->id_almacen." ORDER BY mov_almacen.fecha ASC,prodxmov.id ASC";
					$result2=mysql_db_query($sql_db,$sql_cardex);
					$ndrr=mysql_num_rows($result2);					
					if ($ndrr>0){
						while ($row2=mysql_fetch_array($result2)){
							/*
							echo "<hr>";
							print_r($row2);
							echo "<hr>";
							echo "<br> SXT DEL ALMACEN [".$row2["almacen"]."] AL [".$row2["asociado"]."] por la Cantidad [".$row2["cantidad"]."] a un costo de [".$row2["cu"]."] en el ITEM [".$row2["id_item"]."] ";
							*/
							/* Si es EXT revisar que el asociado de la destino de la SXT del producto sea el mismo que el almacen al que se agregan las existencias */
							//if ($row2==""){
							array_push($items,$row2["id_item"]);
							array_push($cantidades,$row2["cantidad"]);
							array_push($existen,$row2["existen"]);
							array_push($cus,$row2["cu"]);
							//echo "<hr>";
						}
						/*
						echo "<br>ITEMS: "; 	print_r($items);
						echo "<br>CANTI: "; 	print_r($cantidades);
						echo "<br>EXIST: "; 	print_r($existen);
						echo "<br>CUNIT: "; 	print_r($cus);
						*/
						$cont=0;
						while ($cont<count($items)){
							//echo "<br>CONTADOR [".$cont."] ITEM [".$items[$cont]."] PRODUCTO [".$this->id_p."] CANTIDAD [".$cantidades[$cont]."] EXISTEN [".$existen[$cont]."]  CU [".$cus[$cont]."] ";
							if ($this->cantidad<=$existen[$cont]){
								//echo "<br><br>La cantidad  [".$this->cantidad."] del EXT es menor a EXISTEN[".$existen[$cont]."] ";
								//echo "<br>".
								$sql_registrar1="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$this->cantidad."','".$this->cantidad."','".$this->clavep."','".$cus[$cont]."',NULL,'')";
								if (!mysql_db_query($sql_db,$sql_registrar1)){
									$this->error(19);
								} else {
									echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
									$ins_mov=true;
									//echo " [[[[[OK 1]]]]]]";
								}
								$diferencia=$existen[$cont]-$this->cantidad;
								//echo "<br>".
								$sql_actualizar1="UPDATE prodxmov SET existen='$diferencia' WHERE id='".$items[$cont]."' ";								
								if (!mysql_db_query($sql_db,$sql_actualizar1)){
									$this->error(22);
								} else {
									$act_mov=true;
									//echo " [[[[[OK 2]]]]]]";
								}								
								if ($ins_mov=true&&$act_mov=true) break;
							} else {
								//echo "<br>La cantidad  [".$this->cantidad."] del EXT es MAYOR a EXISTEN[".$existen[$cont]."] <br> ";
								//echo "<br><br> FALTAN=".
								$faltan2=$this->cantidad;	
								//echo " DEPOSITO=".
								$dep2=$existen[$cont];    
								//echo " DIFERENCIA=".
								$dif2=$this->cantidad-$existen[$cont];
								//echo "AHORA FALTAN=".
								$faltan2=$faltan2-$dep2;
								//echo " existen update=".
								$eu2=$existen[$cont]-$dep2;
								//echo "<br>".
								$sql_registrar1="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$existen[$cont]."','".$existen[$cont]."','".$this->clavep."','".$cus[$cont]."',NULL,'')";
								if (!mysql_db_query($sql_db,$sql_registrar1)){
									$this->error(19);
								} else {
									echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
									$ins_mov=true;
									//echo " [[[[[OK 1]]]]]]";
								}
								//echo "<br>".
								$sql_actualizar1="UPDATE prodxmov SET existen='$eu2' WHERE id='".$items[$cont]."' ";	
								if (!mysql_db_query($sql_db,$sql_actualizar1)){
									$this->error(22);
								} else {
									$act_mov=true;
									//echo " [[[[[OK 2]]]]]]";
								}								
								while ($faltan2>0){
									$cont++;
									//echo "<br><br> FALTAN=".$faltan2;	
									if ($faltan2<=$existen[$cont]){
										//echo " faltan es <= a existen[] () DEPOSITO=".
										$dep2=$faltan2;
									} else {
										//echo " faltan es > a existen[] () DEPOSITO=".
										$dep2=$existen[$cont];
									}	    
									//echo " DIFERENCIA=".
									$dif2=$existen[$cont]-$faltan2;
									//echo "<br>".
									$sql_registrar1="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$dep2."','".$dep2."','".$this->clavep."','".$cus[$cont]."',NULL,'')";
									if (!mysql_db_query($sql_db,$sql_registrar1)){
										$this->error(19);
									} else {
										echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
										$ins_mov=true;
										//echo " [[[[[OK 1]]]]]]";
									}
									//echo "AHORA FALTAN=".
									$faltan2=$faltan2-$dep2;
									//echo " existen update existen (".$existen[$cont].")  - deposito ($dep2)".
									$eu2=$existen[$cont]-$dep2;
									//echo "<br>".
									$sql_actualizar1="UPDATE prodxmov SET existen='$eu2' WHERE id='".$items[$cont]."' ";	
									if (!mysql_db_query($sql_db,$sql_actualizar1)){
										$this->error(22);
									} else {
										$act_mov=true;
										//echo " [[[[[OK 2]]]]]]";
									}									
								}
								if ($faltan2<=0) break;
							}
							++$cont;
						}
						echo "<hr>";
					} else {
						$this->error(21);
					}					
					exit();
				}
				

				

				//echo "<br>INSERTAR: [".$this->sql_prodxmov."]<br>";
				if (mysql_db_query($sql_db,$this->sql_prodxmov)){
					echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
					?><script language="javascript">
						//document.frm1.reset();
					</script><?php
				} else {	$this->error(19);	}			
			} else {
				// SALIDAS...
				//echo "<br>PEPS : SALIDAS  <br>";
				$entradas=array();			$cus=array();		$id_prodxmov=array();
				$no_entradas=0;
				?>
				<!--
				<br /><table width="98%" align="center" cellspacing="0" style="border:#333333 2px solid;">
				  <tr>
					<td colspan="8" height="20" style="background-color:#333333; color:#FFFFFF; font-weight:bold; text-align:center;">KARDEX DEL PRODUCTO
					  <?//$this->id_p?> ANTES DEL MOVIMIENTO. </td>
				  </tr>
				  <tr style="background-color:#cccccc; font-weight:bold; font-size:12px; text-align:center;">
					<td width="38" height="20">MOV.</td>
					<td width="156">CONCEPTO</td>
					<td width="109">FECHA</td>
					<td width="199">ALMACEN</td>
					<td width="111">ASOCIADO</td>
					<td width="70">CANTIDAD</td>
					<td width="56">EXISTEN</td>
					<td width="41">C.U.</td>
				  </tr>
				  //-->
				  <?php 
					$color="#D9FFB3";
					$sql_movimientos ="
					SELECT prodxmov.*,mov_almacen.*,concepmov.concepto,concepmov.asociado,concepmov.tipo,tipoalmacen.almacen 
					FROM prodxmov,mov_almacen,concepmov,tipoalmacen 
					WHERE tipoalmacen.id_almacen=mov_almacen.almacen AND concepmov.id_concep=mov_almacen.tipo_mov AND prodxmov.nummov=mov_almacen.id_mov AND prodxmov.id_prod=".$this->id_p." AND mov_almacen.almacen=".$this->id_almacen." 
					ORDER BY mov_almacen.fecha ASC,prodxmov.id ASC";
					$result_movimientos=mysql_db_query($sql_db,$sql_movimientos,$link);					
					while ($row_movimientos=mysql_fetch_array($result_movimientos)){ 
					/*
					echo "<hr>";
					print_r($row_movimientos);
					echo "<hr>";
					*/
						if ($row_movimientos["tipo"]=='Ent'&&$row_movimientos["existen"]>0){
							$simbolo="+";
							$total_existencias+=$row_movimientos["cantidad"];
							/* Si es SXT revisar que el asociado de la entrada del producto sea el mismo que el almacen al que se restan las existencias */
							//if ($this->con_mov=="Salida x Trasp"&&$this->con_mov=="Salida x Trasp")
							array_push($id_prodxmov,$row_movimientos["id"]);
							array_push($entradas,$row_movimientos["existen"]);
							array_push($cus,$row_movimientos["cu"]);
							++$no_entradas;
						} else { 
							$simbolo="-";
							$total_existencias-=$row_movimientos["cantidad"];	
						}
					}		
				  ?>
				  <!--<tr bgcolor="<?//$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? //echo $color; ?>'">
					<td align="right" height="20" style="border-right:#CCCCCC 1px solid;"><?//$row_movimientos["nummov"]?></td>
					<td align="left">&nbsp;<?//$row_movimientos["tipo_mov"]." - ".$row_movimientos["concepto"]?></td>
					<td style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid; text-align:left">&nbsp;<?//$row_movimientos["fecha"]?></td>
					<td align="left">&nbsp;<?//$row_movimientos["almacen"]?></td>
					<td style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;">&nbsp;
						<?//$row_movimientos["asociado"]?></td>
					<td align="right"><?//$simbolo.$row_movimientos["cantidad"]?>
					  &nbsp;</td>
					<td align="right" style="border-left:#CCCCCC 1px solid;border-right:#CCCCCC 1px solid;"><?//$row_movimientos["existen"]?>&nbsp;</td>
					<td align="right"><?//$row_movimientos["cu"]?>
					  &nbsp;</td>
				  </tr>
				  <?php// ($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; } ?>
				  <tr style="background-color:#333333; text-align:right; color:#FFFFFF; font-weight:bold;">
					<td height="20" colspan="5">TOTAL&nbsp;&nbsp;</td>
					<td align="right"><?//$total_existencias?>
					  &nbsp;</td>
					<td colspan="2">&nbsp;</td>
				  </tr>
				</table><br /><br />
				//-->
				<?php
				/*
				echo "<hr>ID PRODXMOV: ";
				print_r($id_prodxmov);					
				echo "<hr>Entradas: ";
				print_r($entradas);	
				echo "<hr>Costos U: ";
				print_r($cus);	
				echo "<hr>";
				*/		
				$contador=0;
				$cantidad_depositada=0;
				//echo "<br>Comparacion 1 si [".$entradas[$contador]."] <= [0]";
				//if ($entradas[$contador]<=0) ++$contador;
				while ($entradas[$contador]<=0) { 	++$contador; 	}				
				//echo "<br>Comparacion 2 si [".$this->cantidad."] <= [".$entradas[$contador]."]";
				if ($this->cantidad<=$entradas[$contador]){
					//echo "<br><div align=left>.:::::::. La cantidad solicitada [".$this->cantidad."] se cubre con la entrada $contador [+".$entradas[$contador]."] a un CU [".$cus[$contador]."] .:::::::.<br>";
					if ($this->con_mov=="Salida x Trasp") { 
						//echo "<BR>SXT (convepto=[".$this->con_mov."]) existen=".
						$xe=$this->cantidad; } else { 
						//echo "<BR>NO ES SXT (convepto=[".$this->con_mov."]) existen=".
						$xe=0;  }
					//echo "<br>".
					$sql_registrar1="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$this->cantidad."','$xe','".$this->clavep."','".$cus[$contador]."',NULL,'')";
					if (!mysql_db_query($sql_db,$sql_registrar1)){
						$this->error(19);
					} else {
						echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
						?><script language="javascript">
							//document.frm1.reset();
						</script><?php
					}
					$diferencia=$entradas[$contador]-$this->cantidad;
					//echo "<br>".
					$sql_actualizar1="UPDATE prodxmov SET existen='$diferencia' WHERE id='".$id_prodxmov[0]."' ";
					if (!mysql_db_query($sql_db,$sql_actualizar1)){
						echo "<br>Error SQL: No se inserto el registro ($sql_actualizar1).";
						exit();
					}
					//echo "<br>&nbsp;&nbsp; CANTIDAD DEPOSITADA [".$this->cantidad."], DIFERENCIA [$diferencia]= [".$entradas[$contador]."] - [".$this->cantidad."] ";					
					echo "</div>";
				} else {
					//echo "<br>La cantidad solicitada [".$this->cantidad."] es mayor a la entrada 1 [".$entradas[0]."]";
					//if ($entradas[$contador]<=0) ++$contador;
					while ($entradas[$contador]<=0)	{	++$contador; 	}
					//echo "<br><div align=left>.:::::::. La entrada 1 [".$entradas[0]."] es menor que la cantidad solicitada [".$this->cantidad."].:::::::.<br>";
						$faltan=$this->cantidad;
						while ($faltan>0){
							//echo "<br><br>&nbsp;&nbsp;FALTAN  [$faltan]";							
							$entrada_actual=$entradas[$contador];
							if ($faltan<=$entradas[$contador]){
								//echo "<br>Faltan es menor = a entradas[contador] [".$entradas[$contador]."]";
								if ($this->con_mov=="Salida x Trasp") { 
									//echo "<BR>SXT (convepto=[".$this->con_mov."]) existen=".
									$xe=$faltan; 
								} else { 
									//echo "<BR>NO ES SXT (convepto=[".$this->con_mov."]) existen=".
									$xe=0;
								}
								//echo "<br>".
								$sql_registrar2="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$faltan."','$xe','".$this->clavep."','".$cus[$contador]."',NULL,'')";
								if (!mysql_db_query($sql_db,$sql_registrar2)){
									$this->error(19);
								} else {
									echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
									?><script language="javascript">
										//document.frm1.reset();
									</script><?php								
								}
								$cantidad_depositada+=$faltan;
								$cantidad_exiten=$entradas[$contador]-$faltan;
								$faltan=$this->cantidad-$cantidad_depositada;
								//echo "<br>".
								$sql_actualizar2="UPDATE prodxmov SET existen='$cantidad_exiten' WHERE id='".$id_prodxmov[$contador]."' ";								
								if (!mysql_db_query($sql_db,$sql_actualizar2)){
									echo "<br>Error SQL: No se inserto el registro ($sql_actualizar2).";
									exit();
								}
								//echo "<br>&nbsp;&nbsp;CONTADOR [$contador], CANTIDAD DEPOSITADA [$cantidad_depositada], ENTRADA$contador [$entrada_actual], FALTAN [$faltan],  EXISTEN [$cantidad_exiten] ";
								if ($contador>=$no_entradas) break;
							}else{
								//echo "<br>Faltan es MAyor a entradas[contador] [".$entradas[$contador]."]";
								if ($this->con_mov=="Salida x Trasp") { 
									//echo "<BR>SXT (convepto=[".$this->con_mov."]) existen=".
									$xe=$entradas[$contador]; 
								} else { 
									//echo "<BR>NO ES SXT (convepto=[".$this->con_mov."]) existen=".
									$xe=0;
								}
								//echo "<br>".
								$sql_registrar2="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,cu,id,nseries) VALUES ('".$this->idm."','".$this->id_p."','".$entradas[$contador]."','$xe','".$this->clavep."','".$cus[$contador]."',NULL,'')";
								if (!mysql_db_query($sql_db,$sql_registrar2)){
									$this->error(19);
								} else {
									echo "<li>El producto (".$this->id_p.") se agrego al movimiento (".$this->idm.") correctamente.</li>";
									?><script language="javascript">
										//document.frm1.reset();
									</script><?php								
								}
								$cantidad_depositada+=$entradas[$contador];
								$cantidad_exiten=$entradas[$contador]-$entradas[$contador];
								$faltan=$this->cantidad-$cantidad_depositada;
								//echo "<br>".
								$sql_actualizar2="UPDATE prodxmov SET existen='$cantidad_exiten' WHERE id='".$id_prodxmov[$contador]."' ";
								if (!mysql_db_query($sql_db,$sql_actualizar2)){
									echo "<br>Error SQL: No se inserto el registro ($sql_actualizar2).";
									exit();
								}
								//echo "<br>&nbsp;&nbsp;CONTADOR [$contador], CANTIDAD DEPOSITADA [$cantidad_depositada], ENTRADA$contador [$entrada_actual], FALTAN [$faltan],  EXISTEN [$cantidad_exiten] ";
								if ($contador>=$no_entradas) break;
							}
							++$contador;
							if ($contador>=$no_entradas) break;	
						}
					}
				return true;
			}	
		// ******************************************************************************************************************		
		} else {
			echo "<b>&nbsp;Error 17: El metodo de costeo no esta definido. El sistema necesita obtener el metodo de costeo. Consulte el Administrador del Sistema.</b>";
			exit();
		}
	}	
	//=====================================================================================================================
	protected function error($n){
		$errores=array();
			$errores[0]="&nbsp;Error 1: Las existencias del productos (".$this->id_p.") no se afectaron.";
			$errores[1]="&nbsp;Error 2: El Movimiento de compras NO se realizo.";
			$errores[2]="&nbsp;Error 3: El Movimiento de Inventario Inicial NO se realizo.";
			$errores[3]="&nbsp;Error 4: El Movimiento de Devolucion sobre Ventas NO se realizo.";
			$errores[4]="&nbsp;Error 5: El Movimiento de Ajuste NO se realizo.";
			$errores[5]="&nbsp;Error 6: Las Transferencias del productos (".$this->id_p.") no se afectaron.";
			$errores[6]="&nbsp;Error 6: El Movimiento de Entrada x Traspaso NO se realizo.";
			$errores[7]="&nbsp;Error 7: El Movimiento de Cancelacion de Compra NO se realizo.";
			$errores[8]="&nbsp;Error 8: Las Existencias del Producto (".$this->id_p.") son menores a la cantidad solicitada (".$this->cantidad.").";
			$errores[9]="&nbsp;Error 9: El producto (".$this->id_p.") NO esta asociado al Almacen (".$this->id_almacen.").";
			$errores[10]="&nbsp;Error 10: El Movimiento de Devoluci&oacute;n de Compra NO se realizo.";
			$errores[11]="&nbsp;Error 11: El Movimiento de Ventas NO se realizo.";
			$errores[12]="&nbsp;Error 12: El Movimiento de Merma NO se realizo.";
			$errores[13]="&nbsp;Error 13: El Movimiento de Salida x Traspaso NO se realizo.";
			$errores[14]="&nbsp;Error 14: Las Transferencias del Producto (".$this->id_p.") son menores a la cantidad solicitada (".$this->cantidad.").";
			// 15 y 16 stock
			$errores[18]="&nbsp;Error 18: No se actualizo el COSTO PROMEDIO del Producto (".$this->id_p.").";
			$errores[19]="&nbsp;Error 19: El producto (".$this->id_p.") NO se agrego al movimiento (".$this->idm.").";
			$errores[20]="&nbsp;Error 20: No esta definido el sistema de costeo en el Almacen. Imposible continuar.";
			$errores[21]="&nbsp;Error 21: No hay resultados que mostrar del producto ".$this->id_p.".";
			$errores[22]="&nbsp;Error 22: No se actualizo las existencias en el movimiento.";
			$errores[30]="&nbsp;Error 30: El Movimiento de Refurbish NO se realizo.";
			$errores[31]="&nbsp;Error 31: El Movimiento de Reposicion por Rechazo NO se realizo.";
			$errores[32]="&nbsp;Error 32: El Movimiento de Rechazo a Proveedor NO se realizo.";
			
			$errores[33]="&nbsp;Error 33: El Movimiento de Salida x Asignacion NO se realizo.";
			$errores[34]="&nbsp;Error 34: El Movimiento de Devolucion de Asignacion NO se realizo.";
			$errores[35]="&nbsp;Error 35: El Movimiento de Rechazo Refurbish NO se realizo.";
			$errores[36]="&nbsp;Error 36: El Movimiento de Ajuste Menos NO se realizo.";
		echo "<br>".$errores[$n];
		exit();
	}
}
?>