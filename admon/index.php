<?php
require "../php/conn.php";
if(isset($_POST["usuario"])){
	$usuario = $_POST["usuario"];
	$clave = $_POST["clave"];
	$clave = substr(hash_hmac("sha512",$clave,"encriptado"),0,50);
	//Creamos el query
	$sql = "SELECT * FROM admon WHERE usuario='".$usuario."' AND clave='".$clave."'";
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	if($n==1){
		//Iniciar la sesion
		session_start();
		//Creamos la variable de sesion
		$_SESSION['admon']=$usuario;
		//Saltamos a index
		header("location:productosABC.php");
	} else {
		$error = "Usuario o clave de acceso errónea";
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
<title>Admon</title>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="../index.php">Inicio</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>

<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-sm-2 sidenav">
			
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
				<p class="display-4">Iniciar sesión administrativa</p>
				<form class="text-left" action="index.php" method="post">
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Escribe tu usuario administrativo">
					</div>
					<div class="form-group">
						<label for="clave">Clave de acceso:</label>
						<input type="password" name="clave" id="clave" class="form-control" required placeholder="Escribe tu clave de acceso">
					</div>

					<div class="form-group text-left">
						<label for="entrar"></label>
						<input type="submit" name="entrar" value="Entrar" class="btn btn-success" role="button"/>
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