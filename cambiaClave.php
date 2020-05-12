<?php
require "php/conn.php";
require "php/sesion.php";
require "php/laterales.php";
//Detectamos si se envía la información
if(isset($_GET["id"])){
	$id = $_GET["id"];
	//Leer los datos del usuario
	$sql = "SELECT * FROM usuarios WHERE id=".$id;
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	if($n!=1){
		//No existe ese usuario
		header("location:index.php");
	}
}
if(isset($_POST["id"])){
	$id = $_POST["id"];
	$clave1 = $_POST["clave1"];
	$clave2 = $_POST["clave2"];
	//verificamos las claves
	if ($clave1==$clave2) {
		$clave = hash_hmac("sha512",$clave1,"encriptado");
		$sql = "UPDATE usuarios SET clave='".$clave."' WHERE id=".$id;
		//$sql nos devuelve un valor que también se inteprera por true o false
		if(mysqli_query($conn, $sql)){
			header("location:cambiaClaveGracias.php");
		} else {
			$error = "Error al actualizar la clave de acceso";
		}
	} else {
		$error = "Las claves de acceso no coinciden";
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
<title>Cambiar Clave</title>
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
			<li class="nav-link">
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
	<div class="container-fluid text-center mt-5">
		<p class="display-4">Cambia clave de acceso</p>
		<form action="cambiaClave.php" method="post">

					<div class="form-group text-left">
						<label for="clave1">* Clave de acceso:</label>
						<input type="password" name="clave1" id="clave1" class="form-control" placeholder="Escriba su clave de acceso"/>
					</div>

					<div class="form-group text-left">
						<label for="clave2">* Repetir clave de acceso:</label>
						<input type="password" name="clave2" id="clave2" class="form-control" placeholder="Confirme su clave de acceso"/>
					</div>

					<div class="form-group text-left">
						<label for="enviar"></label>
						<input type="submit" name="enviar" value="Enviar" class="btn btn-outline-info" role="button"/>
					</div>

					<input type="hidden" name="id" id="id" value="<?php print $id; ?>">

		</form>
	</div>
	<footer class="footer">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>
