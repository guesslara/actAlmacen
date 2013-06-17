<?php 
	session_start();	
	include("../conf/conectarbase.php");
	
	//print_r($_POST);
	if ($_POST["accion"]=="guardar_usuario"){
		$sql_nuevo="INSERT INTO usuarios_inventarioiq(id_usuario,f_alta,activo,nivel_usuario,grupo,usuario,password,dp_nombre,de_proyecto,de_noempleadoiq,obs) 
		VALUES (NULL,'".date("Y-m-d")."','1','".$_POST["nivel"]."','".$_POST["grupo"]."','".$_POST["usuario"]."','".md5($_POST["password"])."','".$_POST["nombre"]."','".$_POST["area"]."','".$_POST["noemp"]."','".$_POST["obs"]."')";
		if (!mysql_db_query($sql_db,$sql_nuevo,$link)){
			echo "<br>Error SQL.";
		} else {
			echo "<br><center>El usuario se inserto correctamente.</center>";
			$u_id=mysql_insert_id($link);
		}
		//echo "<hr>$sql_campos<hr>$sql_valores";
				// ==========================================================================================
				if (isset($_FILES["foto"])) {
					$tot = count($_FILES["foto"]["name"]);
					 //este for recorre el arreglo
					 for ($i = 0; $i < $tot; $i++){
						$tmp_name = $_FILES["foto"]["tmp_name"][$i];
						$name = $_FILES["foto"]["name"][$i];
						//echo("<b>el nombre original:</b> "); //echo($name);
						$newfile = "fotos/".$u_id."_".$name;
							// Validar el archivo...
							//echo "<br>Nuevo archivo [$newfile]<br>";
								$extensiones_permitidos=array("gif","jpg","jpeg","png");
								$partes_ruta = pathinfo($newfile);
								$extension_archivo=strtolower($partes_ruta['extension']);
								if (!in_array($extension_archivo,$extensiones_permitidos)) 
								{ 
									echo "<br><div align=center>Error: La extension del archivo no coincide con los farmatos de imagen<br> permitidos por el sistema.</div>";
									exit();
								}	
						if (file_exists($newfile)){	
							echo "<br>El archivo ya existe"; 
						} else {
						
							if (is_uploaded_file($tmp_name)) {
								if (!move_uploaded_file($tmp_name,"$newfile")) {
									print "<br>Error en transferencia de archivo.";
									exit();
								} else {
									$sql_usuario_foto="UPDATE usuarios_inventarioiq SET foto='$newfile' WHERE id_usuario=$u_id";
									if (!mysql_db_query($sql_db,$sql_usuario_foto))
									{
										echo "<br><center>Error: La foto no se subio correctamente al sistema.</center>";
										exit();
									}								
									
									?><script language="javascript">
										alert("El archivo subio correctamente.");
										
										//self.close();
									</script><?php
								} 			   
							} // if is_up...
						} // si existe o no	
					} // for ...
				}
				// ==========================================================================================================				
		
		
		
		
		
	} else {
	
	
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	

	$color="#FFFFFF";	
	//print_r($_POST);
	//exit();
	$ac=$_POST["accion"];
	$fecha=date("Y-m-d");	
	// -------------------------------------------------------------------------------------------------------
	
	if ($ac=="listar")
	{
		//echo md5("123");
		$sql_usuario1="SELECT * FROM usuarios_inventarioiq WHERE activo=1 AND nivel_usuario<=10 ORDER BY id_usuario";
		$result_usuario1=mysql_db_query($sql_db,$sql_usuario1);
		$ndr1=mysql_num_rows($result_usuario1);
		if ($ndr1>0)
		{
			
			?>
				<form name="frm1" id="frm1" method="post" style="margin:0px;" action="<?=$_SERVER['PHP_SELF']?>">
				<h3 align="center">Cat&aacute;logo de Usuarios </h3>
				<table width="800" align="center" cellpadding="1" cellspacing="0" class="tabla1">
				  <tr>
					<th>&nbsp;</th>
					<th>id</th>
					<th>usuario</th>
					<th>nombre completo</th>
					<th>grupo</th>
					<th>nivel</th>
					<th>puesto</th>
					<th>obs</th>
				  </tr>
				  <?php 
				  /*
				  <a href="javascript:ver_usuario('<?=$row_usuario1["id_usuario"]?>');" title="Ver detalles del usuario <?=$row_usuario1["id_usuario"]?>">
				  </a>
				  */
				  while ($row_usuario1=mysql_fetch_array($result_usuario1)) { ?>
					  <tr onmouseover="this.style.background='#D9FFB3';" onmouseout="this.style.background='#ffffff'">
						<td align="center"><input type="checkbox" name="chb<?=$row_usuario1["id_usuario"]?>" id="<?=$row_usuario1["id_usuario"]?>" value="<?=$row_usuario1["id_usuario"]?>" /></td>
						<td align="center"><?=$row_usuario1["id_usuario"]?></td>
						<td><?=$row_usuario1["usuario"]?></td>
						<td>&nbsp;<?=$row_usuario1["dp_nombre"]." ".$row_usuario1["dp_apaterno"]." ".$row_usuario1["dp_amaterno"]?></td>
						<td>&nbsp;<?=$row_usuario1["grupo"]?></td>
						<td align="center">&nbsp;<?=$row_usuario1["nivel_usuario"]?></td>
						<td>&nbsp;<?=$row_usuario1["de_puesto"]?></td>
						<td align="center"><a href="#" title="<?=$row_usuario1["obs"]?>">&laquo;&loz;&raquo;</a></td>
					  </tr>
				  <?php } ?>
				</table>
				</form>			
			<?php
		} else {
			?>
			<div style="text-align:center; border:#333333 2px solid; background-color:#FFFF99; margin:10px 20px 10px 20px; padding:5px 5px 5px 5px; font-size:18px; color:#000000;">
				No se encontraron resultados.			</div>			
			<?php		
		}	
	}
	
	
	if ($ac=="nuevo")
	{	
	?>			
            <form name="frm0" id="frm0" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
			<br /><table width="800" align="center" style="border:#333333 2px solid;" cellspacing="0">
              <tr>
                <td height="23" colspan="4"  style="font-weight:bold; text-align:center; background-color:#333333; color: #ffffff;">NUEVO USUARIO</td>
              </tr>
              
              <tr>
                <td width="146" class="cv">Usuario</td>
                <td width="212"><input type="text" name="usuario" id="usuario" class="txtoi" /></td>
                <td width="180" class="cv">Password</td>
                <td width="242"><input type="password" name="password" id="password" class="txtoi"  /></td>
              </tr>
              
              <tr>
                <td class="cv">Grupo</td>
                <td><input type="text" name="grupo" id="grupo" class="txtoi"></td>
                <td class="cv">Nivel de Acceso </td>
                <td><input type="text" name="nivel_usuario" id="nivel_usuario" class="txtoi"></td>
              </tr>
              <tr>
                <td class="cv">Nombre Completo </td>
                <td><input type="text" name="dp_nombre" id="dp_nombre" class="txtoi" /></td>
                <td class="cv">Correo Electr&oacute;nico </td>
                <td><input type="text" name="dp_email" id="dp_email" class="txtvi" /></td>
              </tr>
              
              <tr>
                <td class="cv">Area / Proyecto</td>
                <td><input type="text" name="de_proyecto" id="de_proyecto" class="txtoi" /></td>
                <td class="cv">No. empleadoIQ</td>
                <td><input type="text" name="de_noempleadoiq" id="de_noempleadoiq" class="txtoi" /></td>
              </tr>
              
              <tr>
                <td class="cv">Observaciones</td>
                <td colspan="3"><input type="text" name="obs" id="obs" class="txtvi" /></td>
              </tr>
              
              <tr>
                <td height="33" colspan="4" align="center">
					<input type="reset" value="Limpiar" />
					<input type="button" value="Guardar" onclick="validar_frm0()" />
					<!--<input type="submit" value="Guardar" />//-->				</td>
              </tr>
              
            </table>
			</form>
<?php }

	}
	
	
	if ($ac=="eliminar"){
		$ids_recibidas=$_POST["ids"];
		$ids_split=split(',',$ids_recibidas);
		foreach ($ids_split as $id_eliminar)
		{
			//echo "<br>$id_eliminar";
			$sql_eliminar="UPDATE usuarios_inventarioiq SET activo=0 WHERE id_usuario=$id_eliminar LIMIT 1";
			if (!mysql_db_query($sql_db,$sql_eliminar))
			{
				echo "<br><center>Error del sistema. El usuario ($id_eliminar) no se elimino. Consulte el Administrador del Sistema.</center>";
			} else {
				echo "<br><center>El usuario ($id_eliminar) se elimino correctamente.</center>";
			}
		}
	}
	
	if ($ac=="ver_usuario"){
		$id_usuario=$_POST["id_usuario"];
		$sql_usuario="SELECT * FROM usuarios_inventarioiq WHERE id_usuario=$id_usuario";
		$result_usuario=mysql_db_query($sql_db,$sql_usuario);
		while ($row_usuario=mysql_fetch_array($result_usuario)){ 
			print_r($row_usuario);
		}		
	}	
		
?>