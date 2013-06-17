<?php
include('../php/clase_mysql.php');
include('../php/conectarbase.php');
$consulta = new Servidor_Base_Datos($host,$usuario,$pass,$sql_db); //instanciar el objeto
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
$pdf->SetAuthor("Alfredo");
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





$sql = str_replace("\\",'', $sql); 
	if(!$consulta->consulta ($sql))
	{
		echo 'Problemas al intentar conectarse a la Base de Datos';
		exit;
	}
	
// set font
$pdf->SetFont("vera", "BI", 15);

// print clipping text
$pdf->Text(90, 24, "Reorden");
	
	
// set font
$pdf->SetFont("vera", "", 8);	
$nLinea=1;
// print a line using Cell()
$pdf->MultiCell(30, 4, "ID", 1, 'C', 1, 0, 0 ,0,false,0, false);
$pdf->MultiCell(120, 4, "Descripcion", 1, 'C', 1, 0, 0 ,0,false,0, false);
$pdf->MultiCell(10, 4, "Stock", 1, 'C', 1, 0, 0 ,0,false,0, false);
$pdf->MultiCell(10, 4, "Ext", 1, 'C', 1, 0, 0 ,0,false,0, false);
$pdf->MultiCell(10, 4, "Dif", 1, 'C', 1, $nLinea, 0 ,0,false,0, false);
while ($fila = $consulta->extraer_registro() ) {
//MultiCell(ancho,alto,texto,borde,alineacion texto,relleno,celdas o nueva fila,x,y,formatea al alto de celda,
$pdf->MultiCell(30, 4, $fila['id_prod'], 1, 'L', 0, 0, 0 ,0,false,0, false);
$pdf->MultiCell(120, 4, $fila['descripgral'], 1, 'L', 0, 0, 0 ,0,false,0,  false);
$pdf->MultiCell(10, 4, $fila['stock_min'], 1, 'L', 0, 0, 0 ,0,false,0,  false);
$pdf->MultiCell(10, 4, $fila['exist_1'], 1, 'L', 0, 0, 0 ,0,false,0,  false);
$pdf->MultiCell(10, 4, $fila['diferencia'], 1, 'L', 0, $nLinea, 0 ,0, false,0, false);
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output();

//============================================================+
// END OF FILE                                                 
//============================================================+
?>