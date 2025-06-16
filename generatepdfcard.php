<?php
require_once('TCPDF-main/TCPDF-main/tcpdf.php');
include('db.php'); // Ensure DB is connected

// Get student_id from URL
$student_id = $_GET['student_id'] ?? 0;

// Fetch student info from DB
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error); // Debugging failed preparation
}
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    die("Student not found.");
}
$student = $result->fetch_assoc();

// Generate file path
$filename = 'library_card_' . $student['student_id'] . '.pdf';

// Set the absolute file path for saving the PDF
$save_path = $_SERVER['DOCUMENT_ROOT'] . '/lib_card_system/cards/' . $filename; // Absolute path

// Ensure the 'cards/' directory exists and is writable
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib_card_system/cards')) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . '/lib_card_system/cards', 0777, true); // Create the directory if it doesn't exist
}

// Create PDF
$pdf = new TCPDF('L', PDF_UNIT, 'A7', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Library');
$pdf->SetTitle('Library Card');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(5, 5, 5);

$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '
<h2 style="color:#2E86C1;">Library Card</h2>
<table cellpadding="4">
    <tr><td><strong>Name:</strong></td><td>' . htmlspecialchars($student['name']) . '</td></tr>
    <tr><td><strong>ID:</strong></td><td>' . $student['student_id'] . '</td></tr>
    <tr><td><strong>Department:</strong></td><td>' . htmlspecialchars($student['department']) . '</td></tr>
    <tr><td><strong>Issued On:</strong></td><td>' . date("d M Y") . '</td></tr>
</table>
';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Save the PDF to the specified path
$pdf->Output($save_path, 'F');  // Save the file to the absolute path

// Prepare the file path to be inserted
$file_name = 'cards/' . $filename; // Relative path to be saved in the DB

// Insert into library_cards table
$insert = $conn->prepare("INSERT INTO library_cards (student_id, file_name) VALUES (?, ?)");
if ($insert === false) {
    die('Error preparing the insert query: ' . $conn->error); // Debugging failed preparation
}
$insert->bind_param("is", $student_id, $file_name); // Pass the variable here
if ($insert->execute()) {
    echo "<script>alert('Library card generated and saved.'); window.location.href='generate_cards.php';</script>";
} else {
    echo "Error: " . $insert->error;
}
?>

