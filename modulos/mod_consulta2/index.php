<?
	session_start();
	include("../../includes/cabecera.php");
	include("../../includes/txtApp.php");
	$proceso="Empaque";
	$procesoEnvio="Marcado como ENVIADO";
	//echo $_SESSION['id_usuario_nx'];
	/*if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}else{
		//se extrae el proceso
		$sqlProc="SELECT * FROM cat_procesos WHERE descripcion='".$proceso."'";
		$resProc=mysql_query($sqlProc,conectarBd());
		$rowProc=mysql_fetch_array($resProc);
		$proceso=$rowProc['id_proc'];
		$sqlProc1="SELECT * FROM cat_procesos WHERE descripcion='".$procesoEnvio."'";
		$resProc1=mysql_query($sqlProc1,conectarBd());
		$rowProc1=mysql_fetch_array($resProc1);
		$proceso1=$rowProc1['id_proc'];
	}*/
	
	function conectarBd(){
		require("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db($db);
			return $link;
		}				
	  }
?>
<link rel="stylesheet" type="text/css" href="css/estilosEmpaque.css" />
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<!--se incluyen los recursos para el grid-->
<script type="text/javascript" src="../../recursos/grid/grid.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/grid/grid.css" />
<!--fin inclusion grid-->
<!--se incluyen los recursos para las ventanas-->
<script type="text/javascript" src="../../clases/jquery.dragndrop.js"></script>
<script type="text/javascript" src="../../recursos/dragdrop/dragdrop.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/dragdrop/estilosDragDrop.css" />
<!--fin de las ventanas-->
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
  <!-- librería principal del calendario -->
<script type="text/javascript" src="js/calendar.js"></script>
  <!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="js/calendar-es.js"></script>
   <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="js/calendar-setup.js"></script>
<!--<link  type="text/css" rel="stylesheet" href="../../css/main.css" />-->
<style type="text/css">

</style>
<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();
		$("#txt_buscador_criterio").focus();
		listar_default();
		ajax('div_D','ac=obtener_lineas');
	});
	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();		
		$("#detalleEmpaque").css("height",(altoDiv-50)+"px");
		$("#ventanaEnsambleContenido2").css("height",(altoDiv-30)+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-3)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#div_ventana2").css("height",90+"%");
	}
	
	window.onresize=redimensionar;

	document.onkeypress=function(elEvento){
		var evento=elEvento || window.event;
		var codigo=evento.charCode || evento.keyCode;
		var caracter=String.fromCharCode(codigo);
		if(codigo==27){
			cerrarVentanaValidacion();
		}
	}
//setInterval("procesarDatosGrid()",5000);
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtProcesoEmpaqueEnvio" id="txtProcesoEmpaqueEnvio" value="<?=$proceso1;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION[$txtApp['session']['idUsuario']];?>" />
<div id="div_transparente" onclick="cancelar()" style="position: absolute;top: 0px;width: 100%;height: 100%; background: url(../../img/transparente2.png) repeat;border: 0px solid #FF0000;"></div>
<div id="div_ventana1">
	<!-- //-->
	<div align="center">
		<input type="hidden" id="txt_id_producto_seleccionado" />
		<p><br /><br />
		<img src="../../img/btn_1.png" class="icono_01" title="Propiedades" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=propiedades')">		</p>
		<p><br /><br />
		<img src="../../img/btn_2.png" class="icono_01" title="Existencias" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=existencias')">		</p>
		<p><br /><br /><br /><br />
		<img src="../../img/btn_3.png" class="icono_01" title="Kardex" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=kardex')">		</p>
		<p><br /><br />
		<img src="../../img/btn_4.png" class="icono_01" title="Comportamiento" onClick="ajax('div_ventana2','ac=ver_producto_detalle&id_producto='+$('#txt_id_producto_seleccionado').val()+'&que=comportamiento')">		</p>
		<!--<img src="img/btn_5.png" class="icono_01" title="Editar">//-->
	</div>
</div>
<div id="div_ventana2"></div>
<div id="div_ventana4"></div>
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<div style="float: left;border: 0px solid #FF0000;">
				Producto <input type="text" id="txt_buscador_criterio" onkeyup="busca_producto1(1985,'<?=$linea?>','<?=$operador?>','<?=$orden?>','<?=$ascdes?>')" style="font-size: 22px;height: 25px;width: 300px;" />
			</div>
			<div id="cargadorEmpaque" style="float:left;margin-left: 10px;width:auto;height:24px;padding:5px;background:#FFF;border:1px solid #CCC;font-size:13px;text-align:left;">
				<div onclick="listar_default()" class="estilosBotones">Listar Productos</div>
				<div onclick="buscar_nextel()" class="estilosBotones">Listar Productos NX</div>
				<div id="div_ventana3"></div>
				<div onclick="buscar()" class="estilosBotones">Buscar</div>
				<div onclick="exportar()" class="estilosBotones">Exportar</div>				
			</div>
		</div>		
		<div id="detalleEmpaque" class="ventanaEnsambleContenido"></div>
		<div id="ventanaEnsambleContenido2" class="ventanaEnsambleContenido" style="display:none;"></div>
		<div style="clear:both;"></div>		
	</div>
</div>
<div id="div_D"></div>
<?
include ("../../includes/pie.php");
?>