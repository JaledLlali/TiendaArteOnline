<?php

require "php/sesion.php";
require "php/conn.php";
require "php/laterales.php";
require "php/carrito.php";
//la m nos indica que se va a borrar
if (isset($_GET["m"])) {
	//Recuperamos el identificador
	$id = $_GET["id"];
	//Borramos de la base de datos
	$sql = "DELETE FROM carrito WHERE idProducto=".$id." AND num='".$carrito."'";
	if(!mysqli_query($conn, $sql)) print "Error al borrar el registro";
} else if (isset($_GET["id"])) {
	//El usuario nos envía un producto
	//Recuperamos los datos de los productos
	$id = $_GET["id"];
	$sql = "SELECT * FROM productos WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($r);
	//Si existe ya el carrito, lo recuperamos
	if(isset($_SESSION['carrito'])){
		$carrito = $_SESSION['carrito'];
	} else {
		//Si no existe el carrito, lo creamos
		//y lo almacenamos en una variable de sesión
		$carrito = llaveCarrito(30);
		$_SESSION['carrito']=$carrito;
	}
	
	//Agregamos el producto en el carrito
	agregaProducto($carrito,$id, $data["precio"], $data["descuento"], $data["envio"],$conn);
}
//Actualizamos carrito si el usuario añade más de una unidad de un producto
if(isset($_POST["num"])){
	$num = $_POST["num"];
	for ($i=0; $i < $num; $i++) { 
		$producto = $_POST["i".$i];
		$cantidad = $_POST["c".$i];
		actualizaProducto($carrito, $producto, $cantidad, $conn);
	}
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
<title>Carrito</title>
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
				<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
				<li class=" breadcrumb-item active"> Carrito</li>
			</ol>
		</nav>
		<?php despliegaCarritoCompleto($carrito, false, $conn); ?>
	</div>
	
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>
