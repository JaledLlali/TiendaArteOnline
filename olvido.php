<?php
require "php/conn.php";
require "php/sesion.php";
require "php/laterales.php";
if (isset($_POST["email"])) {
	$email = $_POST["email"];
	//Buscar el correo en la base de datos
	$sql = "SELECT * FROM usuarios WHERE email='".$email."'";
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	if($n==1){
		$data = mysqli_fetch_assoc($r);
		$id = $data["id"];
		//
		$mensaje = "Entra a la siguiente liga para cambiar tu clave de acceso.<br>";
		$mensaje .= "<a href='localhost/tiendaarte/analeal/cambiaclave.php?id=".$id.">Cambia clave de acceso</a>";
		
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type:text/html; charset=UTF-8\r\n"; 
		$headers .= "From: eCommerce\r\n"; 
		$headers .= "Repaly-to: $email\r\n";
		
		$asunto = "Cambiar la clave de acceso";
		
		if(mail($email, $asunto, $mensaje,$headers)){
			header("location:olvidoGracias.php");
		} else {
			$error = "Error en el envío de su correo, intentarlo más tarde";
		}

	} else {
		$error = "El correo no existe en la base de datos";
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Olvido de la clave de acceso</title>
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
		<div class="col-sm-8 text-center">
			<div class="well" id="contenedor">
				<?php
					if(isset($error)){
						print '<div class="alert alert-danger">';
						print "<strong>* ".$error."</strong>";
						print '</div>';
					}
				?>
				<h2>¿Olvidó la clave de acceso?</h2>
				<form class="text-left" action="olvido.php" method="post">
					<div class="form-group">
						<label for="email">Correo electrónico:</label>
						<input type="email" name="email" id="email" class="form-control" required placeholder="Escribe tu correo electrónico">
					</div>

					<div class="form-group text-left">
						<label for="entrar"></label>
						<input type="submit" name="enviar" value="Enviar" class="btn btn-success" role="button"/>
					</div>
				</form>
			</div>
			<div class="well text-left" id="contenedor" >
				<a href="registro.php" class="btn btn-info">Registrarte en el sitio</a>
			</div>
		</div>
		<div class="col-sm-2 sidenav">
		<h4>Productos relacionados</h4>
		<?php nuevos($conn); ?>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
<a href="aviso.php">Aviso de privacidad</a>
</footer>

</body>
</html>