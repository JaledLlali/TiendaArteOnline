<?php
//Iniciar la sesion
session_start();
//
if(!isset($_SESSION["admon"])){
	header("location:index.php");
}
require "../php/conn.php";
require "../php/funciones.php";
require "../php/carrito.php";
//Modo de la página
//D - guardar carrito en registro de la bd antes de borrar
//S - consulta
//B - borrar
//C - cambiar
$errores = array();
if (isset($_GET["m"])) {
	$m = $_GET["m"];
} else {
	$m = "S";
}
//lee la tabla productos
if ($m=="D") {
	$id = $_GET["id"];
	//Verificar que el usuario no tenga ningún registro en la tabla "carrito"
	$sql = "SELECT * FROM carrito WHERE num='".$id."'";
	$r = mysqli_query($conn, $sql);
	//Trasladamos los registros a la tabla histórica
	while($data = mysqli_fetch_assoc($r)){
		$sql = "INSERT INTO historicopedidos ";
		$sql .= "SET num='".$data["num"]."', ";
		$sql .= "estado='".$data["estado"]."', ";
		$sql .= "idProducto=".$data["idProducto"].", ";
		$sql .= "precio=".$data["precio"].", ";
		$sql .= "descuento=".$data["descuento"].", ";
		$sql .= "envio=".$data["envio"].", ";
		$sql .= "cantidad=".$data["cantidad"];
		if (!mysqli_query($conn, $sql)) {
			print "Error al insertar el producto";
		}
	}
	//Borramos el registro
	$sql = "DELETE FROM carrito WHERE num='".$id."'";
	if(mysqli_query($conn, $sql)){
		header("location:pedidosABC.php");
	}
	$errores = array("Error al borrar el registro");
	
}
//lee la tabla productos
if ($m=="S") {
	$sql = "SELECT num, estado, sum(precio) as importe, sum(cantidad) as cantidad, sum(descuento) as descuento, sum(envio) as envio, idUsuario, fecha FROM carrito GROUP BY num ORDER BY fecha";
	$r = mysqli_query($conn, $sql);
	$pedidos = array();
	while($data = mysqli_fetch_assoc($r)){
		array_push($pedidos, $data);
	}
}
//lee un producto antes de ser borrado
if ($m=="B") {
	$carrito = $_GET["id"];
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
<title>Pedidos ABC</title>
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
          		<li class="nav-item active">
            		<a class="nav-link" href="pedidosABC.php">Pedidos</a>
          		</li>
				<li class="nav-item ">
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
					<h2 class="text-center">ABC tabla pedidos</h2>
					<?php
					if(count($errores)>0){
						print '<div class="alert alert-danger">';
						foreach ($errores as $key => $valor) {
							print "<strong>* ".$valor."</strong>";
						}
						print '</div>';
					}
					//Mostramos el pedido antes de ser borrado
					if($m=="B"){
						print '<div class="alert alert-danger">';
						print "¿Desea borrar este pedido? ";
						print "<a href='pedidosABC.php'>No</a>&nbsp;";
						print "<a href='pedidosABC.php?m=D&id=".$carrito."'>Si</a>";
						print "<p>Los datos del pedido se traspasarán al histórico.</p>";
						print "</div>";
						despliegaCarritoConsulta($carrito, $conn);
					} 
					if ($m=="S") {
						print "<table class='table table-striped' width='100%'>";
						print "<tr>";
						print "<th>Estado</th>";
						print "<th>Importe</th>";
						print "<th>Cant. prod.</th>";
						print "<th>Descuento</th>";
						print "<th>Envío</th>";
						print "<th>Total</th>";
						print "<th>Cliente</th>";
						print "<th>Fecha</th>";
						print "<th>Borrar</th>";
						print "</tr>";
						for ($i=0; $i < count($pedidos) ; $i++) {
							$total = $pedidos[$i]["importe"]-$pedidos[$i]["descuento"]+$pedidos[$i]["envio"];
							if($pedidos[$i]["estado"]=="0"){
								print "<tr class='warning'>";
								print "<td>";
								print "Abierto";
							}
							if($pedidos[$i]["estado"]=="1"){
								print "<tr class='success'>";
								print "<td>";
								print "Aprobado";
							}
							print "</td>";
							print "<td>".number_format($pedidos[$i]["importe"],2)."</td>";
							print "<td>".number_format($pedidos[$i]["cantidad"])."</td>";
							print "<td>".number_format($pedidos[$i]["descuento"],2)."</td>";
							print "<td>".number_format($pedidos[$i]["envio"],2)."</td>";
							print "<td>".number_format($total,2)."</td>";
							print "<td>".$pedidos[$i]["idUsuario"]."</td>";
							print "<td>".$pedidos[$i]["fecha"]."</td>";
							print "<td><a class='btn btn-danger' href='pedidosABC.php?m=B&id=".$pedidos[$i]["num"]."'>Borrar</a></td>";
							print "</tr>";
						}
						print "</table>";
					}
					?>
				</div>
			</div>
			<div class="col-sm-2 sidenav">

			</div>
		</div>
	</div>

</body>
</html>