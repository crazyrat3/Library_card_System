<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$application_id = intval($_GET['id']);

// Delete the application
$sql = "DELETE FROM library_card_applications WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $application_id);
    if ($stmt->execute()) {
        echo "<script>
                alert('Application deleted successfully.');
                window.location.href = 'manage_applications.php';
              </script>";
    } else {
        echo "Error executing delete: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
