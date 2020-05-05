<?php
//Validamos si hay sesión
if(isset($_SESSION['admon'])){
	print '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>';
} else {
	header("location:index.php");
}
?>