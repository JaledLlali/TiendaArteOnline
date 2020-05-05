<?php
//Iniciar la sesion
session_start();
//
if(!isset($_SESSION["admon"])){
	header("location:index.php");
}
require "../php/conn.php";
require "../php/funciones.php";
//Modo de la página
//S - consulta
//A - alta
//B - borrar
//C - cambiar
if (isset($_GET["m"])) {
	$m = $_GET["m"];
} else {
	$m = "S";
}
//lee la tabla productos
if ($m=="B") {
	$id = $_GET["id"];
	//Recuperamos el nombre de la imagen
	$sql = "SELECT imagen FROM productos WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($r);
	$imagen = $row["imagen"];
	unlink("../img/".$imagen);
	//Borramos el registro
	$sql = "DELETE FROM productos WHERE id=".$id;
	if(mysqli_query($conn, $sql)){
		header("location:librosABC.php");
	}
	$errores = array("Error al borrar el registro");
}
//Detectamos si se envía la información
if(isset($_POST["nombre"])){
	//Variables de trabajo
	$errores = array();
	//Validación
	//Recuperamos el id
	$id = (isset($_POST["id"]))?$_POST["id"]:"";
	$nombre = $_POST["nombre"];
	$descripcion = $_POST["descripcion"];
	$autor = $_POST["autor"];
	$editorial = $_POST["editorial"];
	$pag = $_POST["pag"];
	$publico = "";
	$objetivos = "";
	$necesario = "";
	//Validacion de los numeros
	$precio = ($_POST["precio"]=="")?0:$_POST["precio"];
	$descuento = ($_POST["descuento"]=="")?0:$_POST["descuento"];
	$envio = ($_POST["envio"]=="")?0:$_POST["envio"];
	$imagen = $_POST["imagen"];
	$fecha = $_POST["fecha"];
	//
	$relacion1 = "";
	$relacion2 = "";
	$relacion3 = "";
	$masvendido = "0";
	$nuevos = "0";
	//validación
	if ($nombre=="") {
		array_push($errores, "El título es requerido");
	} else if ($descripcion=="") {
		array_push($errores, "El resumen es requerido");
	} else if ($autor=="") {
		array_push($errores, "El autor es requerido");
	} else if ($editorial=="") {
		array_push($errores, "La editorial es requerida");
	} else if (is_numeric($precio)==false) {
		array_push($errores, "Error en el precio, debe ser numérico");
	} else if (is_numeric($descuento)==false) {
		array_push($errores, "Error en el descuento debe ser numérico");
	} else if (is_numeric($envio)==false) {
		array_push($errores, "Error en el monto del envío, debe ser numérico");
	} else if ($precio<=0 || $precio>9999.99) {
		array_push($errores, "El precio está fuera de rango");
	} else if ($precio<$descuento) {
		array_push($errores, "El precio no puede ser menor al descuento");
	} else if ($fecha=="") {
		array_push($errores, "La fecha es requerida");
	} else if (validaFecha($fecha)==false) {
		array_push($errores, "Fecha errónea");
	} else {
		//Verificamos que el archivo haya sido enviado
		//Remplazamos caracteres especiales
		$buscar  = array(' ', '*', '!', '@', '?','á','é', 'í', 'ó','ú','Á','É','Í','Ó','Ú','Ñ','ñ','Ü','ü');
		$reemplazar = array('-', '', '', '', '', 'a','e', 'i', 'o','u','A','E','I','O','U','N','n','U','u');
		$imagen = str_replace($buscar, $reemplazar, $nombre);
		$imagen = $imagen.".jpg";
		$imagen = strtolower($imagen);
		if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
			//Copiamos del area temporal a nuestra carpeta
			copy($_FILES['imagen']['tmp_name'], "../img/".$imagen);
			//Optimizar el archivo
			validaImagen($imagen, 240);
		} else {
			array_push($errores, "Error en la carga de archivos");
		}
		//
		$desc_escapado = escapaCadena($descripcion);
 		//
 		if ($id=="") {
 			$sql = "INSERT INTO productos VALUES(0,'1','".$nombre."', ";
			$sql .= "'".$desc_escapado."', ";
			$sql .= "'".$publico."', ";
			$sql .= "'".$objetivos."', ";
			$sql .= "'".$necesario."', ";
			$sql .= $precio.", ";
			$sql .= $descuento.", ";
			$sql .= $envio.", ";
			$sql .= "'".$imagen."', ";
			$sql .= "'".$fecha."', ";
			$sql .= "'".$relacion1."', ";
			$sql .= "'".$relacion2."', ";
			$sql .= "'".$relacion3."', ";
			$sql .= "'".$masvendido."', ";
			$sql .= "'".$nuevos."', ";
			$sql .= "'".$autor."', ";
			$sql .= "'".$editorial."', ";
			$sql .= $pag.")";
 		} else {
 			$sql = "UPDATE productos SET ";
 			$sql .= "nombre = '".$nombre."', ";
 			$sql .= "descripcion = '".$desc_escapado."', ";
			$sql .= "autor = '".$autor."', ";
			$sql .= "editorial = '".$editorial."', ";
			$sql .= "pag = ".$pag.", ";
			$sql .= "precio = ".$precio.", ";
			$sql .= "envio = ".$envio.", ";
			$sql .= "imagen = '".$imagen."', ";
			$sql .= "fecha = '".$fecha."' ";
			$sql .= "WHERE id=".$id;
 		}
		//
		if(!mysqli_query($conn, $sql)){
			array_push($errores,"Error al insertar el registro ");
		}
	}
}
//lee la tabla productos
if ($m=="S") {
	//tipo 1 son libros
	$sql = "SELECT * FROM productos WHERE tipo='1'";
	$r = mysqli_query($conn, $sql);
	$productos = array();
	while($row = mysqli_fetch_assoc($r)){
		array_push($productos, $row);
	}
}
//lee un producto
if ($m=="C") {
	$id = $_GET["id"];
	$sql = "SELECT * FROM productos WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($r);
	//Variables de trabajo
	$nombre = $data["nombre"];
	$descripcion = $data["descripcion"];
	$autor = $data["autor"];
	$editorial = $data["editorial"];
	$pag = $data["pag"];
	$precio = $data["precio"];
	$descuento = $data["descuento"];
	$envio = $data["envio"];
	$imagen = $data["imagen"];
	$fecha = $data["fecha"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ABC libros</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		window.onload = function() {
			<?php if($m=="C") { ?>
			document.getElementById("borrar").onclick = function() {
				if (confirm("¿Desea borrar el producto?\nUna vez borrado el registro NO podrá ser recuperado.")) {
					var id = <?php print $id; ?>;
					window.open("librosABC.php?m=B&id="+id,"_self");
				}
			}
			<?php } ?>

			<?php if($m=="S") { ?>
				document.getElementById("alta").onclick = function() {
				window.open("librosABC.php?m=A","_self");
			}
			<?php } else { ?>
				document.getElementById("regresar").onclick = function() {
					window.open("librosABC.php","_self");
				}
			<?php } ?>
		}
	</script>
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand">Admon</a>
		</div>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="nav navbar-nav">
				<li><a href="productosABC.php">Cursos</a></li>
				<li class="active"><a href="librosABC.php">Libros</a></li>
				<li><a href="usuariosABC.php">Usuarios</a></li>
				<li><a href="pedidosABC.php">Pedidos</a></li>
				<li><a href="cambiaClave.php">Cambia clave</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php require "php/navbar.php"; ?>
			</ul>
		</div>
	</div>
</nav>

<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-sm-2 sidenav">
		<?php if($m=="S") { ?>
			<label for="alta"></label>
			<input type="button" name="alta" value="Dar de alta un libro" class="btn btn-info" role="button" id="alta" />
		<?php } ?>
		</div>
		<div class="col-sm-8 text-left">
			<div class="well" id="contenedor">
				<h2 class="text-center">ABC tabla libros</h2>
				<?php
				if($m=="A" || $m=="C"){
					if(count($errores)>0){
						print '<div class="alert alert-danger">';
						foreach ($errores as $key => $valor) {
							print "<strong>* ".$valor."</strong>";
						}
						print '</div>';
					}
				?>
				<form action="librosABC.php" method="post" enctype="multipart/form-data">
					<div class="form-group text-left">
						<label for="nombre">* Título:</label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Escriba su nombre" value="<?php print $nombre; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="autor">* Autor:</label>
						<input type="text" name="autor" id="autor" class="form-control" required placeholder="Escriba el autor" value="<?php print $autor; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="editorial">* Editorial:</label>
						<input type="text" name="editorial" id="editorial" class="form-control" required placeholder="Escriba la editorial" value="<?php print $editorial; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="descripcion">* Resumen:</label>
						<textarea class="form-control" name="descripcion" id="descripcion"><?php print $descripcion; ?></textarea>
					</div>

					<div class="form-group text-left">
						<label for="precio">* Precio:</label>
						<input type="text" name="precio" id="precio" class="form-control" placeholder="Escriba el precio" pattern="^(\d|-)?(\d|,)*\.?\d*$" value="<?php print $precio; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="descuento">* Descuento:</label>
						<input type="text" name="descuento" id="descuento" class="form-control" placeholder="Escriba el descuento" pattern="^(\d|-)?(\d|,)*\.?\d*$" value="<?php print $descuento; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="envio">* Costo de envío:</label>
						<input type="text" name="envio" id="envio" class="form-control" placeholder="Escriba el costo de envio" pattern="^(\d|-)?(\d|,)*\.?\d*$" value="<?php print $envio; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="imagen">* Imagen:</label>
						<input type="file" name="imagen" id="imagen" accept="image/jpeg" />
						<?php
							if(isset($imagen)){
								print "<img src='../img/".$imagen."' width='150'/>";
								print "<p>".$imagen."</p>";
							}
						?>
					</div>

					<div class="form-group text-left">
						<label for="fecha">* Fecha:</label>
						<input type="date" name="fecha" id="fecha" class="form-control" placeholder="Fecha de creación" value="<?php print $fecha; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="pag">* Número de páginas:</label>
						<input type="text" name="pag" id="pag" class="form-control" placeholder="Escriba el descuento" pattern="^(\d|-)?(\d|,)*\.?\d*$" value="<?php print $pag; ?>"/>
					</div>

					<input type="hidden" name="id" id="id" value="<?php print $id; ?>">
						
					<div class="form-group text-left">
						<label for="enviar"></label>
						<input type="submit" name="enviar" value="Enviar" class="btn btn-success" role="button"/>

						<label for="regresar"></label>
						<input type="button" name="regresar" value="Regresar" class="btn btn-info" role="button" id="regresar" />

						<?php if($m=="C"){ ?>
						<label for="borrar"></label>
						<input type="button" name="borrar" value="Borrar" class="btn btn-danger" role="button" id="borrar" />
						<?php } ?>

					</div>

				</form>
				<?php } 
				if ($m=="S") {
					$ren = 0;
					for ($i=0; $i < count($productos) ; $i++) { 
						if ($ren==0) {
							print '<div class="row">';
						}
						print '<div class="col-sm-3">';
						print '<img src="../img/'.$productos[$i]["imagen"].'" class="img-responsive img-rounded" style="width:100%" alt="'.$productos[$i]["nombre"].'">';
						print '<p><a href="librosABC.php?m=C&id='.$productos[$i]["id"].'">'.$productos[$i]["nombre"].'</a></p>';
						print '</div>';
						$ren++;
						if ($ren==4) {
							$ren = 0;
							print "</div>";
						}
					}
				}
				?>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
		
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
<a href="aviso.php">Aviso de privacidad</a>
</footer>
</body>
</html>