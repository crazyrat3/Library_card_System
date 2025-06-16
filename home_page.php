<?php
include('student_sidebar.php');
session_start();

if (!isset($_SESSION['student_logged_in']) || !$_SESSION['student_logged_in']) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

include('db.php');

// Fetch student info
$query = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "<p style='color:red;'>Error: Student not found.</p>";
    include('footer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F9F9;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background-color: #2E86C1; /* DO NOT CHANGE */
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

        .student-profile {
            max-width: 700px;
            margin: 80px auto 40px auto; /* moved lower with top margin */
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            border-radius: 10px;
            position: relative;
        }

        .student-profile h2 {
            text-align: center;
            color: #2E86C1;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #AED6F1;
            color: #1B4F72;
            width: 35%;
        }

        td {
            background-color: #F4F6F6;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #3498DB;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #2E86C1;
        }

        @media (max-width: 768px) {
            .student-profile {
                margin: 40px 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="page-title">MY PROFILE</div>
    <div class="topbar-right"></div>
</div>

<div class="student-profile">
    <h2>Student Information</h2>
    <table>
        <tr><th>Student ID</th><td><?= htmlspecialchars($student['student_id']) ?></td></tr>
        <tr><th>Name</th><td><?= htmlspecialchars($student['name']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($student['email']) ?></td></tr>
        <tr><th>Contact No</th><td><?= htmlspecialchars($student['contact_no']) ?></td></tr>
        <tr><th>Class</th><td><?= htmlspecialchars($student['class']) ?></td></tr>
        <tr><th>Year</th><td><?= htmlspecialchars($student['year']) ?></td></tr>
        <tr><th>Department</th><td><?= htmlspecialchars($student['department']) ?></td></tr>
        <tr><th>Gender</th><td><?= htmlspecialchars($student['gender']) ?></td></tr>
        <tr><th>Address</th><td><?= htmlspecialchars($student['address']) ?></td></tr>
        <tr><th>Username</th><td><?= htmlspecialchars($student['username']) ?></td></tr>
    </table>

    <!-- Edit Button -->
    <div style="text-align: center;">
        <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
