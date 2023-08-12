<?php

require_once('C:\xampp\htdocs\evproject\tc-lib-pdf-main\tc-lib-pdf-main\src\Tcpdf.php'); // Include the TCPDF library

// Connect to the database
$connection = mysqli_connect("hostname", "root", "", "ev");

// Execute the query to retrieve the data
$query = "SELECT S_ID, 
                 COUNT(*) as 'Total Reservations',
                 AVG(TIMESTAMPDIFF(MINUTE, START_TIME, END_TIME)) as 'Average Time Spent'
          FROM reservations
          WHERE DATE = '2023-01-13'
          GROUP BY S_ID";
$result = mysqli_query($connection, $query);

// Initialize the TCPDF library
$pdf = new Tcpdf();

// Set the document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Reservations Report');

// Set the margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set the font
$pdf->SetFont('helvetica', 'B', 12);

// Add a page
$pdf->AddPage();

// Print the table header
$pdf->Cell(40, 10, 'S_ID', 1, 0, 'C', 0, '', 0);
$pdf->Cell(40, 10, 'Total Reservations', 1, 0, 'C', 0, '', 0);
$pdf->Cell(40, 10, 'Average Time Spent', 1, 0, 'C', 0, '', 0);
$pdf->Ln();

// Print the table data
while($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(40, 10, $row['S_ID'], 1, 0, 'C', 0, '', 0);
    $pdf->Cell(40, 10, $row['Total Reservations'], 1, 0, 'C', 0, '', 0);
    $pdf->Cell(40, 10, $row['Average Time Spent'], 1, 0, 'C', 0, '', 0);
    $pdf->Ln();
}

// Close the database connection
mysqli_close($connection);

// Output the PDF document to the browser
$pdf->Output('reservations_report.pdf', 'I');
?>
