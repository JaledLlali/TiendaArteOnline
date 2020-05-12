<?php
require "../php/sesion.php";
require "../php/conn.php";
require "../php/laterales.php";
require "../php/carrito.php";
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../img/Logotipo_All.png',170,8,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
	
	$this->Cell(80);
    // Título
	$this -> SetY(20);
	$this -> SetX(60);
    $this->Cell(80,10,'Comprobante de compra',1,0,'C');
   
	//Nombre
    $this->Cell(80);
	$this -> SetY(40);
	$this -> SetX(168);
    $this->Cell(30,10,'Ana Leal',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}



// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm', 'A4',true );
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(80,80,80);
$pdf->SetTextColor(40,40,40);
$pdf->Cell(100,10,'Prodcutos',0,0,'L',1);
$pdf->Cell(20,10,'Cantidad',0,0,'C',1);
$pdf->Cell(30,10,'Precio',0,0,'C',1);
$pdf->Cell(30,10,'A pagar',0,0,'R',1);

$pdf->SetDrawColor(161,64,47);
$pdf->SetLineWidth(0.5);
$pdf->Line(5,70,195,70);

$pdf->Ln(15);

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
//Variables
$i=0;
$subtotal = 0;
$descuento = 0;
$envio = 0;
$total = 0;
$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(240,240,240);
$pdf->SetDrawColor(255,255,255);
$pdf->SetTextColor(40,40,40);
//Imprimimos las filas de productos
while ($data=mysqli_fetch_assoc($r)) {
	$desc = $data['nombre'].":</b> ".substr($data['descripcion'],0,250);
	$nom =$data['nombre'];
	$num = $data['producto'];
	$tot = $data['cantidad']*$data['precio'];
	
	$pdf->Cell(100,10,$data['nombre'],1,0,'L',1);
	$pdf->Cell(20,10,$data['cantidad'],1,0,'C',1);
	$pdf->Cell(30,10,$data['precio'],1,0,'C',1);
	$pdf->Ln();
	
	$subtotal += $tot;
	$descuento += $data["descuento"];
	$envio += $data["envio"];
	$i++;
}
$total = $subtotal + $envio - $descuento;

//Imprimimos lo que ha pagado
$pdf->SetFillColor(240,240,240);
$pdf->SetDrawColor(255,255,255);
$pdf->SetTextColor(40,40,40);
$pdf->Cell(150,10,'Subtotal',1,0,'L',1);
$pdf->Cell(30,10,$subtotal.' Euros',0,0,'R',0);
$pdf->Ln();
$pdf->Cell(150,10,'Envío',1,0,'L',1);
$pdf->Cell(30,10,$envio.' Euros',0,0,'R',0);
$pdf->Ln();
$pdf->Cell(150,10,'Descuento',1,0,'L',1);
$pdf->Cell(30,10,'-'.$descuento.' Euros',0,0,'R',0);
$pdf->Ln();
$pdf->SetFont('Times','B',15);
$pdf->Cell(150,10,'Total',1,0,'L',1);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,10,$total.' Euros',0,0,'R',1);
$pdf->Ln();
$pdf->SetDrawColor(161,64,47);
$pdf->SetLineWidth(0.5);
$pdf->Line(5,130,195,130);
$pdf->Ln();

//Imprimimos los datos del comprador
$pdf->SetX(60);
$pdf->Cell(50,10,'Nombre del comprador:',0,0,'L',0);
$pdf->Cell(30,10,$_SESSION["usuario"]["nombre"]." ".$_SESSION["usuario"]["apellido"],0,0,'R',0);
$pdf->Ln();
$pdf->SetX(60);
$pdf->Cell(50,10,'Dirección:',0,0,'L',0);
$pdf->Cell(30,10,$_SESSION["usuario"]["direccion"]."  ".$_SESSION["usuario"]["ciudad"].", ".$_SESSION["usuario"]["pais"],0,0,'R',0);
$pdf->Ln();
$pdf->SetX(60);
$pdf->Cell(50,10,'Código Postal:',0,0,'L',0);
$pdf->Cell(30,10,$_SESSION["usuario"]["codpos"],0,0,'R',0);
$pdf->Ln();


$pdf->Output();
?>