<?php
session_start();
include('db.php');
include('student_sidebar.php');
// Ensure student is logged in
if (!isset($_SESSION['student_logged_in']) || !$_SESSION['student_logged_in']) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch the application status for the logged-in student
$query = "SELECT status, application_date FROM library_card_applications WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $application = $result->fetch_assoc();
    $status = $application['status'];
    $application_date = $application['application_date'];
} else {
    $status = "No application found";
    $application_date = "N/A";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Status</title>
    <style>
        body {
            background-color: #F8F9F9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .topbar {
            background-color: #2E86C1;
            color: white;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .status-info {
            text-align: center;
        }

        .status-info h2 {
            color: #2E86C1;
            margin-bottom: 20px;
        }

        .status-info p {
            font-size: 16px;
        }

        .badge {
            padding: 8px 15px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            margin-top: 10px;
        }

        .badge-approved { background-color: #28A745; }
        .badge-denied { background-color: #DC3545; }
        .badge-pending { background-color: #FFC107; color: black; }
    </style>
</head>
<body>

<div class="topbar">Application Status</div>

<div class="container">
    <div class="status-info">
        <h2>Application Status</h2>
        <p><strong>Application Date:</strong> <?= date("d M Y, h:i A", strtotime($application_date)) ?></p>
        <p><strong>Status:</strong> 
            <?php
                if ($status === 'Approved') {
                    echo "<span class='badge badge-approved'>$status</span>";
                } elseif ($status === 'Denied') {
                    echo "<span class='badge badge-denied'>$status</span>";
                } else {
                    echo "<span class='badge badge-pending'>$status</span>";
                }
            ?>
        </p>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
