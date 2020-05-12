<?php
require "php/sesion.php";
require "php/conn.php";
$sql = "SELECT * FROM productos WHERE tipo='0' ORDER BY fecha DESC";
$r = mysqli_query($conn, $sql);
$productos = array();
while($row = mysqli_fetch_array($r)){
	array_push($productos, $row);
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
<title>Productos</title>
</head>

<body>
	<header class="d-flex justify-content-center align-items-center">
			<a href="index.php" class=" justify-content-center "><img src="img/Logotipo_All.png" alt="logo" style="max-width: 50px;"></a>
			<a href="index.php" style="font-family: 'Major Mono Display', monospace; text-decoration: none; color:black">AnA LeAL</a>
	</header>
	<div class="navbar-container">
		<ul>
			<li class="nav-link ">
				<a href="index.php">Inicio</a>
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
	<div class="container-fluid">
		<div class="jumbotron">
			<div class="container text-center">
				<h1>Ana Leal</h1>
				<p>Ilustradora</p>
			</div>
		</div>
	</div>
	<div class="container-fluid bg-3 text-center">
			<?php
			//Mostramos los productos por filas
			$ren = 0;
			for ($i=0; $i < count($productos) ; $i++) { 
				if ($ren==0) {
					print '<div class="row">';
				}
				print '<div class="col-md-6 col-lg-3"><div class="card mb-2" style="width: 18rem;">';
				print '<img class="card-img-top" src="img/'.$productos[$i]["imagen"].'" class="img-responsive img-rounded" style="width:100%" alt="'.$productos[$i]["nombre"].'">';
				print '<div class="card-body"><h5 class="card-title">'.$productos[$i]["nombre"].'</h5>';
				print '<p>'.$productos[$i]["descripcion"].'</p>';
				print '<p>'.$productos[$i]["precio"].'</p>';
				print '<a href="producto.php?id='.$productos[$i]["id"].'" class="btn btn-outline-dark">Ver producto</a>';
				print '</div></div></div>';
				$ren++;
				if ($ren==4) {
					$ren = 0;
					print "</div>";
				}
			}
			?>
	</div>
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
		<form action="busca.php" class="form-inline d-flex justify-content-center"  method="get">Buscar:
			<input type="text" name="buscar" id="buscar" class="form-control mr-3" size="50" placeholder="buscar un producto">
			<button type="submit" class="btn btn-outline-info">ir</button>
		</form>
	</footer>
</body>
</html>