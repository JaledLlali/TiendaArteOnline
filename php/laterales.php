<?php
//Recogemos todos los productos que esten marcados como mas vendidos en la BD
function masVendidos($conn){
	$sql = "SELECT * FROM productos WHERE masvendido='1' LIMIT 3";
	$r = mysqli_query($conn, $sql);
	while ($data = mysqli_fetch_assoc($r)) {
		print '<div class="well">'.$data["nombre"];
		print '<a href="producto.php?id='.$data["id"].'"><img src="img/'.$data["imagen"].'" class="media-object img-resposvive" width="100%"></a>';
		print "</div>";	
	}
}
//Recogemos todos los productos que esten marcados como mas nuevos en la BD
function nuevos($conn){
	$sql = "SELECT * FROM productos WHERE nuevos='1' LIMIT 3";
	$r = mysqli_query($conn, $sql);
	while ($data = mysqli_fetch_assoc($r)) {
		print '<div class="well">'.$data["nombre"];
		print '<a href="producto.php?id='.$data["id"].'"><img src="img/'.$data["imagen"].'" class="media-object img-resposvive" width="100%"></a>';
		print "</div>";	
	}
}
?>