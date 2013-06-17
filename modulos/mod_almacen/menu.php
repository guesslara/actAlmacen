<?php exit(); ?>
<style type="text/css">
<!--
			body {
				margin: 0px;
				/*padding: 25px;*/
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: small;
			}
			h1 {
				font-family: sans-serif;
				color: #0068B8;
			}
			
			li.LOCKED {
				font-weight: bold;
			}
			/* ======================================================================== */
ul.jd_menu, 
ul.jd_menu_vertical {
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}
ul.jd_menu ul,
ul.jd_menu_vertical ul {
	display: none;
}
ul.jd_menu li {
	float: left; width:auto;
}

/* -- Sub-Menus -- */
ul.jd_menu ul,
ul.jd_menu_vertical ul {
	position: absolute;
	display: none;
	list-style-type: none;
	margin: 0px;
	padding: 0px;
	z-index: 10000;
}
ul.jd_menu ul li,
ul.jd_menu_vertical ul li {
	float: none;
	margin: 0px;
}			
		/* ======================================================================== */
ul.jd_menu_slate {
	height: 19px;
	background-color: #DDF;
	background: url(jdmenu/gradient.png) repeat-x;
	/*border: 1px solid #70777D;
	border-top: 1px solid #A5AFB8;
	border-left: 1px solid #A5AFB8;*/
	clear: both;
}

ul.jd_menu_vertical {
	width: 200px;
	height: auto;
	clear: both;
	background: url(jdmenu/gradient-vertical.png) repeat-x;
	background-color: #A5AFB8;
}


ul.jd_menu_slate a, 
ul.jd_menu_slate a:active,
ul.jd_menu_slate a:link,
ul.jd_menu_slate a:visited {
	text-decoration: none;
	color: #000;
}
ul.jd_menu_slate ul li a,
ul.jd_menu_slate ul li a:active,
ul.jd_menu_slate ul li a:link,
ul.jd_menu_slate ul li a:visited {
	color: #000;
}
ul.jd_menu_slate li {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	padding: 2px 6px 4px 6px;
	cursor: pointer;
	white-space: nowrap;
	color: #000;
}
ul.jd_menu_slate li.jd_menu_active_menubar,
ul.jd_menu_slate li.jd_menu_hover_menubar {
	padding-left: 5px;
	border-left: 1px solid #ABB5BC;
	padding-right: 5px;
	border-right: 1px solid #929AA1;
	border-right: 1px solid #70777D;
	color: #000;
	background: url(jdmenu/gradient-alt.png) repeat-x;
}

ul.jd_menu_vertical li.jd_menu_active_menubar,
ul.jd_menu_vertical li.jd_menu_hover_menubar {
	padding-left: 6px;
	padding-top: 1px;
	border-top: 1px solid #70777D;
	border-left: 0px;
	border-right: 0px;
}

ul.jd_menu_slate ul {
	background: #ABB5BC;
	border: 1px solid #70777D;
}
ul.jd_menu_slate ul li {
	padding: 0px 10px 3px 4px;
	background: #E6E6E6;
	border: none;
	color: #70777D;
}
ul.jd_menu_slate ul li.jd_menu_active,
ul.jd_menu_slate ul li.jd_menu_hover {
	background: url(jdmenu/gradient.png) repeat-x;
	padding-top: 1px;
	border-top: 1px solid #ABB5BC;
	padding-bottom: 2px;
	border-bottom: 1px solid #929AA1;
	color: #FFF;
}
ul.jd_menu_slate ul li.jd_menu_active a.jd_menu_active,
ul.jd_menu_slate ul li.jd_menu_hover a.jd_menu_hover {
	color: #FFF;
}
-->
</style>

		<script src="jdmenu/jquery-1.1.2.js" type="text/javascript"></script>
		<script src="jdmenu/jquery.bgiframe.js" type="text/javascript"></script>
		<script src="jdmenu/jquery.dimensions.js" type="text/javascript"></script>
		<script src="jdmenu/jquery.jdMenu.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function(){
				$('ul.jd_menu').jdMenu({	onShow: loadMenu	});
				$('ul.jd_menu_vertical').jdMenu({onShow: loadMenu, onHide: unloadMenu, offset: 1, onAnimate: onAnimate});
			});

			function onAnimate(show) {
				//$(this).fadeIn('slow').show();
				if (show) {
					$(this)
						.css('visibility', 'hidden').show()
							.css('width', $(this).innerWidth())
						.hide().css('visibility', 'visible')
					.fadeIn('normal');
				} else {
					$(this).fadeOut('fast');
				}
			}

			var MENU_COUNTER = 1;
			function loadMenu() {
				if (this.id == 'dynamicMenu') {
					$('> ul > li', this).remove();
			
					var ul = $('<ul></ul>');
					var t = MENU_COUNTER + 10;
					for (; MENU_COUNTER < t; MENU_COUNTER++) {
						$('> ul', this).append('<li>Item ' + MENU_COUNTER + '</li>');
					}
				}
			}
			function unloadMenu() {
				if (MENU_COUNTER >= 30) {
					MENU_COUNTER = 1;
				}
			}
			// We're passed a UL
			function onHideCheckMenu() {
				return !$(this).parent().is('.LOCKED');
			}
			// We're passed a LI
			function onClickMenu() {
				$(this).toggleClass('LOCKED');
				return true;
			}
		</script>
<div style="background-image:URL(jdmenu/gradient.png); height:23px; z-index:4; display:block; position:relative; ">&nbsp;
<ul class="jd_menu jd_menu_slate" style="position: absolute; left:50%; top:0px; margin-top:0px; margin-left:-195px; padding:0px; width: 390px; height:auto;">
	<li>Inventarios &raquo;
		<ul>
			<li><a href="inventario.php?op=1">Buscar Productos</a></li>
			<li><a href="inventario.php">Listar Productos</a></li>
		</ul>
	</li>
	<li>Movimientos &raquo;
		<ul>
			<li><a href="movalm.php">Nuevo Movimiento</a></li>
			<li><a href="mov_list.php">Listar movimientos</a></li>
			<li><a href="editar_movimientos.php">Editar movimientos</a></li>
		</ul>
	</li>
	<?php if ($_SESSION['usuario_nivel']<=1){ ?>	
	<li>Administracion &raquo;
		<ul>
			<li><a href="../login/aut_gestion_usuarios.php">Usuarios</a></li>
			<li> <a href="tipo_alm_listado.php">Almacenes</a></li>
			<li><a href="conc_mov_listado.php">Conceptos de E/S</a></li>
			<li>Lineas de Productos &raquo;
				<ul>
					<li><a href="cat_line_prod.php?op=1">Nuevo Linea</a></li>
					<li><a href="cat_line_prod.php?op=3">Listar Lineas</a></li>
				</ul>			
			</li>
			<li>Cat&aacute;logo de Productos &raquo;
				<ul>
					<li><a href="alta_producto2.php">Alta de Productos</a></li>
					<li><a href="cat_product_buscar.php">B&uacute;squeda</a></li>
					<li><a href="cat_product1.php">Listar Productos</a></li>
				</ul>			
			</li>
			<li><a href="kardex.php">Kardex</a></li>
			<li><a href="p_reorden.php">Punto de Reorden</a></li>
						
		</ul>
	</li>
	<?php } ?>
	<li>Sistema &raquo;
		<ul>
			<li><a href="#">Ayuda</a></li>			

			<?php if ($_SESSION['usuario_nivel']<=1){ ?>
			<li>M&oacute;dulos&raquo;	
				<ul>
					<li><a href="../../compras/modulos/mod_OCAlmacen">Ordenes de Compra</a></li>
					<li><a href="../../compras/modulos/mod_requisiciones">Requisiciones de Compras</a></li>	
					<li><a href="../../compras/modulos/mod_busca">Buscar Requisiciones de Compras</a></li>	
					<li><a href="../../ingresosAlmacen/almacen/almacen.php">Solicitud de Productos Nuevos</a></li>
				</ul>
			</li>
			<?php } ?>	



			<li><a href="../salir.php" target="_parent">Salir</a></li>
		</ul>
	</li>				
</ul>
</div>

