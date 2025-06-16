<?php
session_start();
include('admin_sidebar.php');
include('db.php');

if (!isset($_GET['student_id'])) {
    echo "No student selected.";
    exit();
}

$student_id = $_GET['student_id'];

$query = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Student not found.";
    exit();
}

$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
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
    max-width: 700px;
    margin: 120px auto 60px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}


        h2 {
            color: #2E86C1;
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-top: 20px;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .label {
            font-weight: bold;
            color: #2C3E50;
        }
    </style>
</head>
<body>

<div class="topbar">Student Details</div>

<div class="container">
    <h2><?= htmlspecialchars($student['name']) ?></h2>
    <div class="info">
        <p><span class="label">Student ID:</span> <?= $student['student_id'] ?></p>
        <p><span class="label">Email:</span> <?= $student['email'] ?></p>
        <p><span class="label">Contact No:</span> <?= $student['contact_no'] ?></p>
        <p><span class="label">Username:</span> <?= $student['username'] ?></p>
        <p><span class="label">Class:</span> <?= $student['class'] ?></p>
        <p><span class="label">Year:</span> <?= $student['year'] ?></p>
        <p><span class="label">Department:</span> <?= $student['department'] ?></p>
        <p><span class="label">Gender:</span> <?= $student['gender'] ?></p>
        <p><span class="label">Address:</span> <?= $student['address'] ?></p>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
