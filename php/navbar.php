<?php
if (isset($_SESSION["carrito"])) {
	print '<li><a href="carrito.php"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Carrito</a></li>';
}
//Validamos si hay sesión
if(isset($_SESSION['usuario'])){
	print '<li><a href="./cambiaClave.php">'.$nombre." ".$apellido.'</a></li>';
	print '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>';
} else {
	print '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</a></li>';
}
?>