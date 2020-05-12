<?php
//Validamos si hay sesión
if(isset($_SESSION['admon'])){
	print '<li class="nav-item"><a class="nav-link" href="../logout.php" style="decoration: none;" ><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>';
} else {
	header("location:index.php");
}
?>