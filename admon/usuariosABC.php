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
//B - borrar
//C - cambiar
$errores = array();
if (isset($_GET["m"])) {
	$m = $_GET["m"];
} else {
	$m = "S";
}
//lee la tabla usuarios
if ($m=="B") {
	$id = $_GET["id"];
	//Verificar que el usuario no tenga ningún registro en la tabla "carrito"
	$sql = "SELECT count(*) as num FROM carrito WHERE idUsuario=".$id;
	$r = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($r);
	$n = (mysqli_num_rows($r)==1)? $data["num"] : 0;
	if($n>0){
		$errores = array("Este usuario tiene ".$n." registros en el carrito de compras.");
		$m = "S";
	} else {
		//Borramos el registro
		$sql = "DELETE FROM usuarios WHERE id=".$id;
		if(mysqli_query($conn, $sql)){
			header("location:usuariosABC.php");
		}
		$errores = array("Error al borrar el registro");
	}
	
}
//Detectamos si se envía la información
if(isset($_POST["nombre"])){
	//Recuperamos el identificador
	$id = $_POST["usuario"]["id"];
	//Recuperamos la información del usuario
	$nombre = $_POST["nombre"];
	$apellido = $_POST["apellido"];
	$correo = $_POST["correo"];
	$direccion = $_POST["direccion"];
	$ciudad = $_POST["ciudad"];
	$codpos = $_POST["codpos"];
	$pais = $_POST["pais"];
	//Armamos el SQL
	$sql = "UPDATE usuarios SET ";
	$sql .= "nombre='".$nombre."', ";
	$sql .= "apellido='".$apellido."', ";
	$sql .= "email='".$correo."', ";
	$sql .= "direccion='".$direccion."', ";
	$sql .= "ciudad='".$ciudad."', ";
	$sql .= "codpos='".$codpos."', ";
	$sql .= "pais='".$pais."' ";
	$sql .= "WHERE id=".$id;
	//Ejecutamos el sql
	if(mysqli_query($conn, $sql)){
		//Saltamos a la página de pago
		header("location:usuariosABC.php");
		exit;
	}
}
//lee la tabla usuarios
if ($m=="S") {
	$sql = "SELECT * FROM usuarios";
	$r = mysqli_query($conn, $sql);
	$usuarios = array();
	while($data = mysqli_fetch_assoc($r)){
		array_push($usuarios, $data);
	}
}
//lee un usuario
if ($m=="C") {
	$id = $_GET["id"];
	//Leemos el registro del usuario
	$sql = "SELECT * FROM usuarios WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	//pasamos los datos a un objeto
	$data = mysqli_fetch_assoc($r);
	//Variables de trabajo
	$nombre = $data["nombre"];
	$apellido = $data["apellido"];
	$correo = $data["email"];
	$direccion = $data["direccion"];
	$ciudad = $data["ciudad"];
	$codpos = $data["codpos"];
	$pais = $data["pais"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ABC usuarios</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
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
				<li><a href="librosABC.php">Libros</a></li>
				<li class="active"><a href="usuariosABC.php">Usuarios</a></li>
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
		</div>
		<div class="col-sm-8 text-left">
			<div class="well" id="contenedor">
				<h2 class="text-center">ABC tabla usuarios</h2>
				<?php
				if(count($errores)>0){
					print '<div class="alert alert-danger">';
					foreach ($errores as $key => $valor) {
						print "<strong>* ".$valor."</strong>";
					}
					print '</div>';
				}
				if($m=="C"){
					
				?>
				<form action="usuariosABC.php" method="post">
					<div class="form-group text-left">
						<label for="nombre">* Nombre:</label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Escriba su nombre" value="<?php print $nombre; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="apellidoPaterno">* Apellido:</label>
						<input type="text" name="apellidoPaterno" id="apellido" class="form-control" required placeholder="Escriba su apellido"  value="<?php print $apellido; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="correo">* Correo electrónico:</label>
						<input type="email" name="correo" id="correo" class="form-control" placeholder="Escriba su correo electrónico"  value="<?php print $correo; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="direccion">* Dirección:</label>
						<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Escriba su dirección"  value="<?php print $direccion; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="ciudad">* Ciudad:</label>
						<input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Escriba su ciudad"  value="<?php print $ciudad; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="codpos">* Código Postal:</label>
						<input type="text" name="codpos" id="codpos" class="form-control" placeholder="Escriba su código postal"  value="<?php print $codpos; ?>"/>
					</div>

					<div class="form-group text-left">
						<label for="pais">* País:</label>
						<input type="text" name="pais" id="pais" class="form-control" placeholder="Escriba su país"  value="<?php print $pais; ?>"/>
					</div>

					<input type="hidden" id="id" name="id" value="<?php print $id; ?>">

					<div class="form-group text-left">
						<label for="enviar"></label>
						<input type="submit" name="enviar" value="Enviar" class="btn btn-success" role="button"/>
					</div>

				</form>
				<?php } 
				if ($m=="S") {
					print "<table class='table table-striped' width='100%'>";
					print "<tr>";
					print "<th>id</th>";
					print "<th>Nombre</th>";
					print "<th>Apellido</th>";
					print "<th>Modificar</th>";
					print "<th>Borrar</th>";
					print "</tr>";
					for ($i=0; $i < count($usuarios) ; $i++) { 
						print "<tr>";
						print "<td>".$usuarios[$i]["id"]."</td>";
						print "<td>".$usuarios[$i]["nombre"]."</td>";
						print "<td>".$usuarios[$i]["apellido"]."</td>";
						print "<td><a class='btn btn-info' href='usuariosABC.php?m=C&id=".$usuarios[$i]["id"]."'>Modificar</a></td>";
						print "<td><a class='btn btn-danger' href='usuariosABC.php?m=B&id=".$usuarios[$i]["id"]."'>Borrar</a></td>";
						print "</tr>";
					}
					print "</table>";
				}
				?>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
		
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
</footer>
</body>
</html>