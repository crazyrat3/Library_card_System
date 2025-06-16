<?php
session_start();
include('student_sidebar.php');
include('db.php');

if (!isset($_SESSION['student_logged_in']) || !$_SESSION['student_logged_in']) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$message = "";

// Check if student has already applied and its status
$check = $conn->prepare("SELECT application_date, status FROM library_card_applications WHERE student_id = ?");
$check->bind_param("s", $student_id);
$check->execute();
$check_result = $check->get_result();

$already_applied = false;
$application_date = "";
$application_status = "";

if ($check_result->num_rows > 0) {
    $row = $check_result->fetch_assoc();
    $already_applied = true;
    $application_date = date("d M Y, h:i A", strtotime($row['application_date']));
    $application_status = $row['status']; // Fetch the status of the application
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert application
    $stmt = $conn->prepare("INSERT INTO library_card_applications (student_id) VALUES (?)");
    $stmt->bind_param("s", $student_id);
    if ($stmt->execute()) {
        $already_applied = true;
        $application_date = date("d M Y, h:i A");
        $application_status = "Pending";  // New application status is Pending
    } else {
        $message = "Error submitting application. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Library Card</title>
    <style>
        body {
            background-color: #F8F9F9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .topbar {
            background-color: #2E86C1;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 100px auto 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #2E86C1;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #2E86C1;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #1B4F72;
        }

        .message {
            margin-top: 25px;
            font-size: 16px;
            color: #117A65;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="page-title">Apply for Library Card</div>
    <div class="topbar-right"></div>
</div>

<div class="container">
    <h2>Library Card Application</h2>

    <?php if ($already_applied): ?>
        <?php if ($application_status === 'Denied'): ?>
            <div class="message" style="color: red;">
                Your application for a library card was denied on <strong><?= $application_date ?></strong>. You can apply again below.
            </div>
            <form method="POST">
                <button type="submit" class="btn">Re-Apply</button>
            </form>
        <?php elseif ($application_status === 'Approved'): ?>
            <div class="message">
                Your application has been approved on <strong><?= $application_date ?></strong>.
            </div>
        <?php else: ?>
            <div class="message">
                You have already applied for a library card on <strong><?= $application_date ?></strong>. Status: <strong><?= $application_status ?></strong>.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($message): ?>
            <div class="message" style="color: red;"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST">
            <button type="submit" class="btn">Apply Now</button>
        </form>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>

