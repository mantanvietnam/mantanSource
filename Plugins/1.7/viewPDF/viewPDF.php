<?php
    $file= $_GET['url'];
    header('Content-type: application/pdf');
    include 'PDFMerger.php';

    $pdf = new PDFMerger;
    
    $pdf->addPDF($file, 'all')
    	->merge('browser', 'samplepdfs/TEST2.pdf');
?>