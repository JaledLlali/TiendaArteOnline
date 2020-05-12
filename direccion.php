<?php
require "php/sesion.php";
require "php/conn.php";
require "php/laterales.php";
if(!isset($_SESSION["usuario"])){
	header("location:login.php");
	exit;
}
if(isset($_POST["nombre"])){
	//Recuperamos el identificador
	$id = $_SESSION["usuario"]["id"];
	//Recogemos la información que esté en los formularios por si el usuario cambia algo
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
		//Leemos el registro del usuario
		$sql = "SELECT * FROM usuarios WHERE id=".$id;
		$r = mysqli_query($conn, $sql);
		//pasamos los datos a un objeto
		$usuario = mysqli_fetch_assoc($r);
		//Actualizamos la variable de sesion
		$_SESSION["usuario"]=$usuario;
		//Saltamos a la página de pago
		header("location:pago.php");
		exit;
	}

}
//Variables de trabajo que recuperamos del registro del usuario
$nombre = $_SESSION["usuario"]["nombre"];
$apellido = $_SESSION["usuario"]["apellido"];
$correo = $_SESSION["usuario"]["email"];
$direccion = $_SESSION["usuario"]["direccion"];
$ciudad = $_SESSION["usuario"]["ciudad"];
$codpos = $_SESSION["usuario"]["codpos"];
$pais = $_SESSION["usuario"]["pais"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/main.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<title>Checkout</title>
</head>

<body>
	<header class="d-flex justify-content-center align-items-center">
			<a href="index.php" class=" justify-content-center "><img src="img/Logotipo_All.png" alt="logo" style="max-width: 50px;"></a>
			<a href="index.php" style="font-family: 'Major Mono Display', monospace; text-decoration: none; color:black">AnA LeAL</a>
	</header>
	<div class="navbar-container">
		<ul>
			<li class="nav-link">
				<a href="index.php">Inicio
				</a>
				<div class="underline"></div>
			</li>
			<li class="nav-link active-link">
				<a href="productos.php">Productos</a>
				<div class="underline"></div>
			</li>
			<li class="nav-link">
				<a href="sobremi.php">Sobre mi</a>
				<div class="underline"></div>
			</li>
			<li class="nav-link">
				<a href="contacto.php">Contacto</a>
				<div class="underline"></div>
			</li>
			
		</ul>
		<ul class="nav-link">
			<?php require "php/navbar.php"; ?>
		</ul>
	</div>
	<div class="container-fluid mt-5">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb d-flex justify-content-center">
				<li class="breadcrumb-item">Iniciar sesion</li>
				<li class=" breadcrumb-item active ">Datos de envío</li>
				<li class=" breadcrumb-item ">Forma de pago</li>
				<li class=" breadcrumb-item ">Revisar</li>
			</ol>
		</nav>
		<p>Verifique los siguientes datos para su envío:</p>
		<form action="direccion.php" method="post">
			<div class="form-group text-left">
				<label for="nombre">* Nombre:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Escriba su nombre" value="<?php print $nombre; ?>"/>
			</div>

			<div class="form-group text-left">
				<label for="apellido">* Apellidos:</label>
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

			<div class="form-group text-left">
				<label for="enviar"></label>
				<input type="submit" name="enviar" value="Enviar" class="btn btn-outline-info" role="button"/>
			</div>
		</form>
	</div>
	
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>
