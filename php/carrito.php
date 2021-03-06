<?php
$carrito="";
if(isset($_SESSION['carrito'])){
		$carrito = $_SESSION['carrito'];
}
/*************
FUNCIONES
**************/
function despliegaCarrito($carrito, $conn){
	//Variables de trabajo
	$subtotal = 0;
	$descuento = 0;
	$envio = 0;
	$total = 0;
	//Leer los datos del carrito
	$sql = "SELECT c.idUsuario as usuario, ";
	$sql .= "c.idProducto as producto, ";
	$sql .= "c.cantidad as cantidad, ";
	$sql .= "c.precio as precio, ";
	$sql .= "c.envio as envio, ";
	$sql .= "c.descuento as descuento, ";
	$sql .= "p.imagen as imagen, ";
	$sql .= "p.descripcion as descripcion, ";
	$sql .= "p.nombre as nombre ";
	$sql .= "FROM carrito as c, productos as p ";
	$sql .= "WHERE num='".$carrito."' AND ";
	$sql .= "c.idProducto=p.id";
	//Leemos el query
	$r = mysqli_query($conn, $sql);
	while ($data=mysqli_fetch_assoc($r)) {
		$tot = $data['cantidad']*$data['precio'];
		$subtotal += $tot;
		$descuento += $data["descuento"];
		$envio += $data["envio"];
	}
	$total = $subtotal + $envio - $descuento;
	return number_format($total,2);
}
function actualizaProducto($carrito, $producto, $cantidad, $conn){
	$sql = "UPDATE carrito ";
	$sql .= "SET cantidad=".$cantidad." ";
	$sql .= "WHERE num='".$carrito."' AND idProducto=".$producto;
	if(!mysqli_query($conn, $sql)) print "Error al modificar un registro";

}
function llaveCarrito($len) { 
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $len); 
}
function agregaProducto($carrito, $id, $precio, $descuento, $envio, $conn){
	//Verificamos que no exista el producto en el carrito
	$sql = "SELECT * FROM carrito WHERE num='".$carrito."' AND idProducto=".$id;
	$r = mysqli_query($conn, $sql);
	if(mysqli_num_rows($r)==0){
		$sql = "INSERT INTO carrito ";
		$sql .= "SET num='".$carrito."', ";
		$sql .= "estado='0', "; //carrito abierto
		$sql .= "idProducto=".$id.", ";
		$sql .= "precio=".$precio.", ";
		$sql .= "descuento=".$descuento.", ";
		$sql .= "envio=".$envio.", ";
		$sql .= "cantidad=1";
		if (!mysqli_query($conn, $sql)) {
			print "Erro al insertar el producto";
		}
	}
}
function despliegaCarritoCompleto($carrito, $verifica, $conn){
	//Variables de trabajo
	$subtotal = 0;
	$descuento = 0;
	$envio = 0;
	$total = 0;
	//Leer los datos del carrito
	$sql = "SELECT c.idUsuario as usuario, ";
	$sql .= "c.idProducto as producto, ";
	$sql .= "c.cantidad as cantidad, ";
	$sql .= "c.precio as precio, ";
	$sql .= "c.envio as envio, ";
	$sql .= "c.descuento as descuento, ";
	$sql .= "p.imagen as imagen, ";
	$sql .= "p.descripcion as descripcion, ";
	$sql .= "p.nombre as nombre ";
	$sql .= "FROM carrito as c, productos as p ";
	$sql .= "WHERE num='".$carrito."' AND ";
	$sql .= "c.idProducto=p.id";
	//Leemos el query
	$r = mysqli_query($conn, $sql);
	print '<form action="carrito.php" method="post">';
	print '<table class="table table-striped" width="100%">';
	print '<tr>';
	print '<th width="12%">Producto</th>';
	print '<th width="58%">Descripción</th>';
	print '<th width="1.8%">Cant.</th>';
	print '<th width="10.12%">Precio</th>';
	print '<th width="10.12%">Subtotal</th>';
	print '<th width="1%"></th>';
	print '<th width="6.5%">Borrar</th>';
	print '</tr>';
	$i=0;
	while ($data=mysqli_fetch_assoc($r)) {
		$desc = $data['nombre'].":</b> ".substr($data['descripcion'],0,250);
		$nom =$data['nombre'];
		$num = $data['producto'];
		$tot = $data['cantidad']*$data['precio'];
		print '<tr>';
		print '<td>';
		print '<img src="img/'.$data['imagen'].'" width="105" alt="'.$nom.'">';
		print '</td>';
		print '<td>';
		print '<p><b>'.$desc.'...</p>';
		print '</td>';
		print '<td class="text-right">';
		print '<input type="number" name="c'.$i.'" value="'.$data['cantidad'].'" min="1" max="99"/>';
		print '<input type="hidden" name="i'.$i.'" value="'.$data['producto'].'"/>';
		print '</td>';
		print '<td class="text-right">'.$data['precio'].'€</td>';
		print '<td class="text-right">'.$tot.'€</td>';
		print '<td>&nbsp;</td>';
		//Borrar productos
		print '<td class="text-right"><a href="carrito.php?m=b&id='.$data['producto'].'" class="btn btn-outline-danger">Borrar</a></td>';
		print '</tr>';
		//+= sirve para sumar a una variable (numérica) otro número y que el resultado sea el valor de la primera variable. 
		//Ej: $a = 3; $a += 5; establece $a en 8, como si se hubiera dicho: $a = $a + 5;
		$subtotal += $tot;
		$descuento += $data["descuento"];
		$envio += $data["envio"];
		$i++;
	}
	$total = $subtotal + $envio - $descuento;
	print '<input type="hidden" name="num" value="'.$i.'"/>';
	print '</table>';
	print '<hr>';
	print '<table width="100%" class="text-right">';
	print '<tr>';
	print '<td width="79.85%"></td>';
	print '<td width="11.55%">Subtotal:</td>';
	print '<td width="9.20%">'.number_format($subtotal,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Descuento:</td>';
	print '<td>'.number_format($descuento,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Costo de envío:</td>';
	print '<td>'.number_format($envio,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Total:</td>';
	print '<td>'.number_format($total,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td><a href="index.php" class="btn btn-outline-secondary" role="button">Seguir comprando</a></td>';
	print '<td><input type="submit" class="btn btn-outline-info" role="button" value="Recalcular"></td>';
	if($verifica){
		print '<td><a href="gracias.php" class="btn btn-outline-success" role="button">Pagar</a></td>';
	} else {
		print '<td><a href="checkout.php" class="btn btn-outline-success" role="button">Pagar</a></td>';
	}
	print '</tr>';
	print '</table>';
	print '</form>';
}
function despliegaCarritoPago($carrito, $verifica, $conn){
	//Variables de trabajo
	$subtotal = 0;
	$descuento = 0;
	$envio = 0;
	$total = 0;
	//Leer los datos del carrito
	$sql = "SELECT c.idUsuario as usuario, ";
	$sql .= "c.idProducto as producto, ";
	$sql .= "c.cantidad as cantidad, ";
	$sql .= "c.precio as precio, ";
	$sql .= "c.envio as envio, ";
	$sql .= "c.descuento as descuento, ";
	$sql .= "p.imagen as imagen, ";
	$sql .= "p.descripcion as descripcion, ";
	$sql .= "p.nombre as nombre ";
	$sql .= "FROM carrito as c, productos as p ";
	$sql .= "WHERE num='".$carrito."' AND ";
	$sql .= "c.idProducto=p.id";
	//Leemos el query
	$r = mysqli_query($conn, $sql);
	print '<form action="carrito.php" method="post">';
	print '<table class="table table-striped" width="100%">';
	print '<tr>';
	print '<th width="12%">Producto</th>';
	print '<th width="58%">Descripción</th>';
	print '<th width="1.8%">Cant.</th>';
	print '<th width="10.12%">Precio</th>';
	print '<th width="10.12%">Subtotal</th>';
	print '<th width="1%"></th>';
	print '<th width="6.5%">Borrar</th>';
	print '</tr>';
	$i=0;
	while ($data=mysqli_fetch_assoc($r)) {
		$desc = $data['nombre'].":</b> ".substr($data['descripcion'],0,250);
		$nom =$data['nombre'];
		$num = $data['producto'];
		$tot = $data['cantidad']*$data['precio'];
		print '<tr>';
		print '<td>';
		print '<img src="img/'.$data['imagen'].'" width="105" alt="'.$nom.'">';
		print '</td>';
		print '<td>';
		print '<p><b>'.$desc.'...</p>';
		print '</td>';
		print '<td class="text-right">';
		print '<input type="number" name="c'.$i.'" value="'.$data['cantidad'].'" min="1" max="99"/>';
		print '<input type="hidden" name="i'.$i.'" value="'.$data['producto'].'"/>';
		print '</td>';
		print '<td class="text-right">'.$data['precio'].'€</td>';
		print '<td class="text-right">'.$tot.'€</td>';
		print '<td>&nbsp;</td>';
		//Borrar productos
		print '<td class="text-right"><a href="carrito.php?m=b&id='.$data['producto'].'" class="btn btn-danger">Borrar</a></td>';
		print '</tr>';
		//+= sirve para sumar a una variable (numérica) otro número y que el resultado sea el valor de la primera variable. 
		//Ej: $a = 3; $a += 5; establece $a en 8, como si se hubiera dicho: $a = $a + 5;
		$subtotal += $tot;
		$descuento += $data["descuento"];
		$envio += $data["envio"];
		$i++;
	}
	$total = $subtotal + $envio - $descuento;
	print '<input type="hidden" name="num" value="'.$i.'"/>';
	print '</table>';
	print '<hr>';
	print '<table width="100%" class="text-right">';
	print '<tr>';
	print '<td width="79.85%"></td>';
	print '<td width="11.55%">Subtotal:</td>';
	print '<td width="9.20%">'.number_format($subtotal,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Descuento:</td>';
	print '<td>'.number_format($descuento,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Costo de envío:</td>';
	print '<td>'.number_format($envio,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td></td>';
	print '<td>Gran total:</td>';
	print '<td>'.number_format($total,2).'€</td>';
	print '</tr>';
	print '<tr>';
	print '<td><a href="index.php" class="btn btn-info" role="button">Seguir comprando</a></td>';
	print '<td><input type="submit" class="btn btn-info" role="button" value="Recalcular"></td>';
	print '<td><a href="pagoconPaypal.php" class="btn btn-success" role="button">Confirmar y pagar</a></td>';
	print '</tr>';
	print '</table>';
	print '</form>';
}
function despliegaCarritoConsulta($carrito, $conn){
	//Variables de trabajo
	$subtotal = 0;
	$descuento = 0;
	$envio = 0;
	$total = 0;
	//Leer los datos del carrito
	$sql = "SELECT c.idUsuario as usuario, ";
	$sql .= "c.idProducto as producto, ";
	$sql .= "c.cantidad as cantidad, ";
	$sql .= "c.precio as precio, ";
	$sql .= "c.envio as envio, ";
	$sql .= "c.descuento as descuento, ";
	$sql .= "p.imagen as imagen, ";
	$sql .= "p.descripcion as descripcion, ";
	$sql .= "p.nombre as nombre ";
	$sql .= "FROM carrito as c, productos as p ";
	$sql .= "WHERE num='".$carrito."' AND ";
	$sql .= "c.idProducto=p.id";
	//Leemos el query
	$r = mysqli_query($conn, $sql);
	//Calculamos el total y mostramos los datos
	while ($data=mysqli_fetch_assoc($r)) {
		$nom =$data['nombre'];
		$num = $data['producto'];
		$tot = $data['cantidad']*$data['precio']-$data['descuento']+$data['envio'];
		//+= sirve para sumar a una variable (numérica) otro número y que el resultado sea el valor de la primera variable. 
		//Ej: $a = 3; $a += 5; establece $a en 8, como si se hubiera dicho: $a = $a + 5;
		$subtotal += $tot;
		$descuento += $data["descuento"];
		$envio += $data["envio"];
		$can += $data['cantidad'];
	}
	$total = $subtotal + $envio - $descuento;

}

function calculaTotal($carrito, $conn){
	//Variables de trabajo
	$subtotal = 0;
	$descuento = 0;
	$envio = 0;
	$total = 0;
	//Leer los datos del carrito
	$sql = "SELECT c.idUsuario as usuario, ";
	$sql .= "c.idProducto as producto, ";
	$sql .= "c.cantidad as cantidad, ";
	$sql .= "c.precio as precio, ";
	$sql .= "c.envio as envio, ";
	$sql .= "c.descuento as descuento, ";
	$sql .= "p.imagen as imagen, ";
	$sql .= "p.descripcion as descripcion, ";
	$sql .= "p.nombre as nombre ";
	$sql .= "FROM carrito as c, productos as p ";
	$sql .= "WHERE num='".$carrito."' AND ";
	$sql .= "c.idProducto=p.id";
	//Leemos el query
	$r = mysqli_query($conn, $sql);
	$i=0;
	while ($data=mysqli_fetch_assoc($r)) {
		$desc = $data['nombre'].":</b> ".substr($data['descripcion'],0,250);
		$nom =$data['nombre'];
		$num = $data['producto'];
		$tot = $data['cantidad']*$data['precio'];
		//+= sirve para sumar a una variable (numérica) otro número y que el resultado sea el valor de la primera variable. 
		//Ej: $a = 3; $a += 5; establece $a en 8, como si se hubiera dicho: $a = $a + 5;
		$subtotal += $tot;
		$descuento += $data["descuento"];
		$envio += $data["envio"];
		$i++;
	}
	$total = $subtotal + $envio - $descuento;
	echo $total;
}
?>