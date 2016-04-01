<?php
require_once('models/class.PDF.php');

$idOrder=$_REQUEST['idOrder'];

$pdf=new PDF();

$pdf->CreatePDF($idOrder);

?>