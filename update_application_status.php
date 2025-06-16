<?php
session_start();
include('db.php');

// Validate and sanitize inputs
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Invalid request.");
}

$application_id = intval($_GET['id']);
$status = $_GET['status'];

// Only allow specific status values
$allowed_statuses = ['Approved', 'Denied', 'Pending'];
if (!in_array($status, $allowed_statuses)) {
    die("Invalid status value.");
}

// Update the application status
$sql = "UPDATE library_card_applications SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("si", $status, $application_id);
    if ($stmt->execute()) {
        // Redirect with success message
        echo "<script>
                alert('Application status updated to \"$status\" successfully.');
                window.location.href = 'manage_applications.php';
              </script>";
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();
?>
