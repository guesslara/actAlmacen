<?php
include('../php/clase_mysql.php');
include('../php/conectarbase.php');
$consulta = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db);  //instanciar el objeto
if(!$consulta->conectar_base_datos())	//probar la conexion al servidor
{
	echo 'Problemas al intentar conectarse a la Base de Datos.';
	exit;
}
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
$sql = $_GET['sql'];
stripcslashes($sql);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("IQ");
$pdf->SetTitle("PDF");
$pdf->SetSubject("TCPDF Tutorial");
$pdf->SetKeywords("TCPDF, PDF, example, test, guide");
 
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING); 

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

//initialize document
$pdf->AliasNbPages();

// add a page
$pdf->AddPage();

// ---------------------------------------------------------




$sql2 = "SELECT id_prod, descripgral, stock_min, exist_1, (stock_min-exist_1) as diferencia FROM catprod WHERE exist_1 < stock_min order by diferencia desc LIMIT 0,15";
	if(!$consulta->consulta ($sql2))
	{
		echo 'Problemas al intentar conectarse a la Base de Datos';
		exit;
	}

// set font
$pdf->SetFont("vera", "B", 12);

// print clipping text
$pdf->Text(90, 24, "Reorden");
	
	
// set font
$pdf->SetFont("vera", "", 5);	
$altura=30;
$con=1;
// Formato a la linea del rectangulo
//$pdf->SetLineWidth(0.5);

//$pdf->Text(0, 10, $sql);

while ($fila = $consulta->extraer_registro() ) {
if($altura==30)
	$max_diferencia = $fila["diferencia"];  // Ajusta el Rect para que no sobrepase los limites de mangen horizontal ajustando las barras
if($altura==30)
	$pdf->SetFillColor(0, 255, 255, false, 0);
if($altura==60)
	$pdf->SetFillColor(8, 72, 255, false, 0);	
if($altura==90)
	$pdf->SetFillColor(63, 36, 235, false, 0);

$pdf->SetDrawColor(50, 0, 250, 250);
$pdf->SetTextColor(255, 255, 255, false, 0);

$pdf->Rect(20, $altura, ($fila["diferencia"]*150)/$max_diferencia, 2, 'DF');

$pdf->Text(15, $altura+1.5, $con.')');
$pdf->Text(19, $altura+4, 0);
$pdf->Text(($fila["diferencia"]*150)/$max_diferencia+20, $altura+4, $fila["diferencia"]);
$pdf->Text(($fila["diferencia"]*150)/$max_diferencia+21, $altura+1.5, $fila["descripgral"]);

$altura+=6;
$con+=1;
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output();

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
