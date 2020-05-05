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
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registro</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
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
			<a href="index.php" class="navbar-brand">Mi sitio</a>
		</div>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Inicio</a></li>
				<li><a href="cursos.php">Cursos</a></li>
				<li><a href="libros.php">Libros</a></li>
				<li><a href="sobremi.php">Sobre mi</a></li>
				<li class="active"><a href="contacto.php">Contacto</a></li>
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
			<h4>Productos más vendidos</h4>
			<?php masVendidos($conn); ?>
		</div>
		<div class="col-sm-8 text-left">
			<div class="well" id="contenedor">
				<?php
					if(count($errores)>0){
						print '<div class="alert alert-danger">';
						foreach ($errores as $key => $valor) {
							print "<strong>* ".$valor."</strong>";
						}
						print '</div>';
					}
				?>
				<h2 class="text-center">Registro</h2>
				<p>Favor de capturar los siguientes datos:</p>
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
						<input type="submit" name="enviar" value="Enviar" class="btn btn-success" role="button"/>
					</div>

				</form>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
		<h4>Productos nuevos</h4>
		<?php nuevos($conn); ?>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
<a href="aviso.php">Aviso de privacidad</a>
</footer>

</body>
</html>