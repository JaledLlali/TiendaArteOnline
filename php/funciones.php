<?php
function validaFecha($fecha){
	//aa-mm-dd
	$fecha_array = explode("-",$fecha);
	//mm, dd, aa
	return checkdate($fecha_array[1],$fecha_array[2],$fecha_array[0]);
}
function validaImagen($producto, $anchoNuevo){
	$archivo = "../img/".$producto;
	//print $archivo."<br>";
	
	//Recuperamos los datatos de la imagen
	$info = getimagesize($archivo);
	$ancho = $info[0];
	$alto = $info[1];
	$tipo = $info["mime"];
	
	//Calculamos la proporcionalidad
	$nuevoAncho = $anchoNuevo;
	$factor = $anchoNuevo / $ancho;
	$nuevoAlto = $alto * $factor;
	
	//Creamos un nuevo objeto
	switch($tipo){
		case "image/jpg":
		case "image/jpeg":
			$imagen = imagecreatefromjpeg($archivo);
			break;
		case "image/png":
			$imagen = imagecreatefrompng($archivo);
			break;	
		case "image/gif":
			$imagen = imagecreatefromgif($archivo);
			break;
	}
	
	//Creamos un "recipiente"
	$lienzo = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
	
	//Vaciamos la imagen modificada en el lienzo
	imagecopyresampled($lienzo, $imagen, 0,0, 0,0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
	
	//Creamos el nuevo archivo
	imagejpeg($lienzo, "../img/".$producto, 80);
}
function escapaCadena($cadena){
	$cadena = escapeshellcmd($cadena);
	//print $cadena;
	$buscar  = array('^','delete', 'drop', 'truncate','exec','system');
	$reemplazar = array('-','de*le*te', 'dr*op', 'trun*cate','ex*ec','syst*em');
	$cadena = str_replace($buscar, $reemplazar, $cadena);
	//print $cadena;
	return $cadena;
}
function limpiaNombreArchivo($producto){
	$buscar  = array('á','é', 'í', 'ó','ú','Á','É','Í','Ó','Ú','Ñ','ñ','Ü','ü');
	$reemplazar = array('a','e', 'i', 'o','u','A','E','I','O','U','N','n','U','u');
	$cadena = str_replace($buscar, $reemplazar, $producto);
	print $cadena;
	return $cadena;
}
?>