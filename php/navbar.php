<?php
if (isset($_SESSION["carrito"])) {
	print '<li><a href="carrito.php" class="fa fa-shopping-cart" )></a></li>';
}
//Validamos si hay sesión
if(isset($_SESSION['usuario'])){
	print '<li><a href="./cambiaClave.php">'.$nombre." ".$apellido.'</a></li>';
	print '<li><a href="logout.php" class="fa fa-sign-out" )>&nbsp;Logout</a></li>';
} else {
	print '<li><a href="login.php"><span class="fa fa-sign-in"></span>&nbsp;Login</a></li>';
}
?>