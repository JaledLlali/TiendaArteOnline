<?php
require "php/conn.php";
require "php/sesion.php";
require "php/laterales.php";
$errores = array();
//Detectamos si se envía la información
if(isset($_POST["nombre"])){
	//Variables de trabajo
	$nombre = $_POST["nombre"];
	$apellido = $_POST["apellido"];
	$email = $_POST["email"];
	$direccion = $_POST["direccion"];
	$ciudad = $_POST["ciudad"];
	$codpos = $_POST["codpos"];
	$pais = $_POST["pais"];
	$clave1 = $_POST["clave1"];
	$clave2 = $_POST["clave2"];
	$errores = array();
	//Validación
	if ($nombre=="") {
		$errores[0]="El nombre del usuario es requerido";
	} else if ($apellido=="") {
		$errores[1]="El apellido es requerido";
	} else if ($email=="") {
		$errores[2]="El correo electrónico del usuario es requerido";
	} else if ($direccion=="") {
		$errores[3]="La dirección del usuario es requerida";
	} else if ($ciudad=="") {
		$errores[4]="La ciudad del usuario es requerida";
	}else if ($codpos=="") {
		$errores[5]="El código postal del usuario es requerido";
	} else if ($pais=="") {
		$errores[6]="El país del usuario es requerido";
	} else if ($clave1!==$clave2) {
		$errores[10]="Las claves de acceso no coinciden";
	} else {
		if(validaCorreo($email, $conn)){
			//encriptamos
			$clave = hash_hmac("sha512",$clave1,"encriptado");
			$sql = "INSERT INTO usuarios VALUES(0,";
			$sql .= "'".$nombre."', '".$apellido."',";
			$sql .= "'".$email."', '".$direccion."',";
			$sql .= "'".$ciudad."', '".$codpos."',";
			$sql .= "'".$pais."', '".$clave."')";
			//
			if(mysqli_query($conn, $sql)){
				header("location:registroGracias.php");
			} else {
				$errores[9] = "Error en la inserción a la base de datos";
			}
		} else {
			$errores[8] = "Ya existe el correo en la base de datos";
		}
	}
}
function validaCorreo($email, $conn){
	$sql = "SELECT * FROM usuarios WHERE email='".$email."'";
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	$bandera = ($n==0)? true : false;  
	return $bandera;
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
	<div class="container-fluid mt-5">
		<p class="display-4 text-center">Registro</p>
			<p>Rellene los siguientes datos:</p>
				<form action="registro.php" method="post">
					<div class="form-group text-left">
						<label for="nombre">* Nombre:</label>
						<input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Escriba su nombre"/>
					</div>

					<div class="form-group text-left">
						<label for="apellido">* Apellido:</label>
						<input type="text" name="apellido" id="apellido" class="form-control" required placeholder="Escriba su apellido"/>
					</div>


					<div class="form-group text-left">
						<label for="correo">* Correo electrónico:</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Escriba su correo electrónico"/>
					</div>

					<div class="form-group text-left">
						<label for="clave1">* Clave de acceso:</label>
						<input type="password" name="clave1" id="clave1" class="form-control" placeholder="Escriba su clave de acceso"/>
					</div>

					<div class="form-group text-left">
						<label for="clave2">* Repetir clave de acceso:</label>
						<input type="password" name="clave2" id="clave2" class="form-control" placeholder="Confirme su clave de acceso"/>
					</div>

					<div class="form-group text-left">
						<label for="direccion">* Dirección:</label>
						<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Escriba su dirección"/>
					</div>

					<div class="form-group text-left">
						<label for="ciudad">* Ciudad:</label>
						<input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Escriba su ciudad"/>
					</div>

					<div class="form-group text-left">
						<label for="codpos">* Código Postal:</label>
						<input type="text" name="codpos" id="codpos" class="form-control" placeholder="Escriba su código postal"/>
					</div>

					<div class="form-group text-left">
						<label for="pais">* País:</label>
						<input type="text" name="pais" id="pais" class="form-control" placeholder="Escriba su país"/>
					</div>

					<div class="form-group text-left">
						<label for="enviar"></label>
						<input type="submit" name="enviar" value="Enviar" class="btn btn-outline-info" role="button"/>
					</div>

				</form>
	</div>
	
	<footer class="footer text-center">
		<div class="text-muted">Todos los derechos reservados</div>
	</footer>
</body>
</html>
