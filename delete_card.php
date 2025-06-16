<?php
include('db.php');

if (isset($_GET['file']) && isset($_GET['student_id'])) {
    $file_path = $_GET['file'];
    $student_id = $_GET['student_id'];

    // Remove the file from the server
    if (file_exists($file_path)) {
        unlink($file_path); // Delete the file
    }

    // Delete the record from the database
    $delete = $conn->prepare("DELETE FROM library_cards WHERE student_id = ?");
    $delete->bind_param("i", $student_id);
    
    if ($delete->execute()) {
        echo "<script>alert('Card deleted successfully.'); window.location.href='generate_cards.php';</script>";
    } else {
        echo "Error deleting the record: " . $delete->error;
    }
} else {
    echo "Invalid request.";
}
?>
