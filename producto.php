<?php
require "php/sesion.php";
require "php/conn.php";
require "php/carrito.php";
require "php/laterales.php";
if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$sql = "SELECT * FROM productos WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($r);
}
//Incluimos el $conn para evitar que sea global
function muestraProductoRelacionado($id, $conn)
{
	$sql = "SELECT nombre, imagen FROM productos WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($r);
	//Desplegamos etiquetas concatenando 
	print '<div class="well text-center"><a class="badge badge-light mb-1" href="producto.php?id='.$id.'">'.$data["nombre"].'</a>';
	print '<a href="producto.php?id='.$id.'"><img src="img/'.$data["imagen"].'" class="media-object img-resposvive" width="100%"></a>';
	print '</div>';
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
	<div class="container mt-5">
		<div class="row">
			<div class="col-lg-9">
				<div>
					<div class="display-4"><?php print $data['nombre']; ?></div>
					<div class="mt-3 mb-3"><img src="img/<?php print $data['imagen']; ?>" class="img-fluid" alt="Responsive image" style="max-width: 700px;"></div>
					<div><?php print $data['descripcion']; ?></div>
					<div class="mt-3 d-flex justify-content-end">
						<h6>Precio:<?php print $data['precio']; ?> €</h6>
					</div>
					<div class="mt-3 d-flex justify-content-end">
							<a href="index.php" class="btn btn-outline-secondary mr-2" role="button">Regresar</a>
							<a href="carrito.php?id=<?php print $id; ?>" class="btn btn-outline-success " role="button">Añadir al carrito</a>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<p class=" text-center">Productos relacionados:</p>
				<br>
				<?php
				if ($data["relacion1"]!=0) {
				muestraProductoRelacionado($data["relacion1"], $conn);
				}
				if ($data["relacion2"]!=0) {
					muestraProductoRelacionado($data["relacion2"], $conn);
				}
				if ($data["relacion3"]!=0) {
					muestraProductoRelacionado($data["relacion3"], $conn);
				}
				?>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>