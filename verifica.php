<?php
require "php/sesion.php";
require "php/conn.php";
require "php/laterales.php";
require "php/carrito.php";
if(!isset($_SESSION["usuario"])){
	header("location:login.php");
	exit;
}
if(isset($_POST["pago"])){
	$pago = $_POST["pago"];
}
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
				<li class=" breadcrumb-item  ">Datos de envío</li>
				<li class=" breadcrumb-item  ">Forma de pago</li>
				<li class=" breadcrumb-item active ">Revisar</li>
			</ol>
		</nav>
		<p class="text-center">Valide sus datos</p>
				<p>Modo de págo: <?php print $pago; ?></p>
				<p>Nombre: <?php print $_SESSION["usuario"]["nombre"]." ".$_SESSION["usuario"]["apellido"]; ?></p>
				<p>Dirección:<?php print $_SESSION["usuario"]["direccion"]."  ".$_SESSION["usuario"]["ciudad"].", ".$_SESSION["usuario"]["pais"]; ?></p>
				<p>Código postal: <?php print $_SESSION["usuario"]["codpos"]; ?></p>
				<br><br>
				<p><?php despliegaCarritoPago($carrito, true, $conn) ?></p>
	</div>
	
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>
