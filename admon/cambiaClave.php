<?php
//Iniciar la sesion
session_start();
//
if(!isset($_SESSION["admon"])){
	header("location:index.php");
}
require "../php/conn.php";
if(isset($_POST["clave1"])){
	$clave1 = $_POST["clave1"];
	$clave2 = $_POST["clave2"];
	//verificamos las claves
	if ($clave1==$clave2) {
		$clave = hash_hmac("sha512",$clave1,"encriptado");
		$sql = "UPDATE admon SET clave='".$clave."' WHERE id=1";
		if(mysqli_query($conn, $sql)){
			header("location:index.php");
		} else {
			$error = "Error al actualizar la clave de acceso";
		}
	} else {
		$error = "Las claves de acceso no coinciden";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/main.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/main.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<title>Cambia clave Admon</title>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="productosABC.php">Admon</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
      	</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
        	<ul class="navbar-nav mr-auto">
				<li class="nav-item ">
            		<a class="nav-link" href="productosABC.php">Productos<span class="sr-only">(current)</span></a>
          		</li>
          		<li class="nav-item">
            		<a class="nav-link" href="usuariosABC.php">Usuarios</a>
          		</li>
          		<li class="nav-item">
            		<a class="nav-link" href="pedidosABC.php">Pedidos</a>
          		</li>
				<li class="nav-item active">
            		<a class="nav-link" href="cambiaClave.php">Cambiar clave</a>
          		</li>
   				<?php require "php/navbar.php"; ?>     
			</ul>
      	</div>
    </nav>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav">
			</div>
			<div class="col-sm-8 text-left">
				<div class="well" id="contenedor">
					<?php
						if(isset($error)){
							print '<div class="alert alert-danger">';
							print "<strong>* ".$error."</strong>";
							print '</div>';
						}
					?>
					<h2 class="text-center">Cambia clave de acceso</h2>
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
							<input type="submit" name="enviar" value="Enviar" class="btn btn-success" role="button"/>
						</div>


					</form>
				</div>
			</div>
			<div class="col-sm-2 sidenav">
			</div>
		</div>
	</div>



</body>
</html>