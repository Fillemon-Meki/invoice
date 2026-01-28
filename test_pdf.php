<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PDF Generation Test</h2>";

// Load required files
require_once('includes/config.php');
require_once('invoice.php');

echo "<p>Files loaded successfully</p>";

try {
    echo "<p>Creating invoice object...</p>";
    $invoice = new invoicr("A4", CURRENCY, "en");
    echo "<p style='color:green;'>Invoice object created successfully!</p>";
    
    echo "<p>Setting invoice properties...</p>";
    $invoice->setType("Invoice");
    $invoice->setReference("TEST-001");
    $invoice->setDate(date('M dS Y', time()));
    $invoice->setDue(date('M dS Y', strtotime('+1 month')));
    
    echo "<p>Setting FROM data...</p>";
    $invoice->setFrom(array(
        "Business Name",
        "123 Street",
        "City",
        "Country"
    ));
    
    echo "<p>Setting TO data...</p>";
    $invoice->setTo(array(
        "Test Customer",
        "456 Avenue",
        "Town",
        "Country"
    ));
    
    echo "<p>Adding an item...</p>";
    $invoice->addItem("Test Product", "Test Description", 1, 0, 100.00, 100.00, 0);
    
    echo "<p>Adding totals...</p>";
    $invoice->addTotal("Total", 100.00);
    $invoice->addTotal("Total Due", 100.00, true);
    
    echo "<p>Setting badge...</p>";
    $invoice->addBadge("Unpaid");
    
    echo "<p>Setting footer...</p>";
    $invoice->setFooternote("Test Footer");
    
    echo "<p>Attempting to set logo...</p>";
    if(file_exists('images/logo.png')) {
        echo "<p style='color:green;'>Logo file exists</p>";
        $invoice->setLogo('images/logo.png');
        echo "<p style='color:green;'>Logo set successfully</p>";
    } else {
        echo "<p style='color:orange;'>Logo file not found, skipping...</p>";
    }
    
    echo "<p>Rendering PDF...</p>";
    $pdf_path = 'invoices/TEST-PDF.pdf';
    $invoice->render($pdf_path, 'F');
    
    if(file_exists($pdf_path)) {
        echo "<h3 style='color:green;'>SUCCESS! PDF created at: $pdf_path</h3>";
        echo "<p><a href='$pdf_path' target='_blank'>View PDF</a></p>";
        echo "<p>File size: " . filesize($pdf_path) . " bytes</p>";
    } else {
        echo "<h3 style='color:red;'>FAILED! PDF file was not created</h3>";
        echo "<p>Check permissions on the invoices/ folder</p>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color:red;'>Exception caught:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
} catch (Error $e) {
    echo "<h3 style='color:red;'>Fatal Error caught:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>File: " . $e->getFile() . " Line: " . $e->getLine() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr><h3>Invoices Folder Contents:</h3>";
$files = scandir('invoices/');
echo "<ul>";
foreach($files as $file) {
    if($file != '.' && $file != '..') {
        echo "<li>$file</li>";
    }
}
echo "</ul>";
?>
