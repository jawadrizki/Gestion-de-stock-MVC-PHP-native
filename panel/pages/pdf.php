<?php
require_once "html2pdf-4.4.0/html2pdf.class.php";
try{
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->pdf->SetTitle("Rapport_$d");
    $html2pdf->writeHTML($pdf);
    $html2pdf->Output("Rapport_$d.pdf",'D');

}catch (HTML2PDF_exception $e){
    die($e);
}
