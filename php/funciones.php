<?php
function validaFecha($fecha){
	//aa-mm-dd
	$fecha_array = explode("-",$fecha);
	//mm, dd, aa
	return checkdate($fecha_array[1],$fecha_array[2],$fecha_array[0]);
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