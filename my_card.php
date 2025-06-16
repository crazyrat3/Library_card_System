<?php
session_start();
include('db.php');
include('student_sidebar.php');
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch card info
$sql = "SELECT file_name FROM library_cards WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();
?><div class="topbar">
<div class="page-title">Library Card</div>
<div class="topbar-right"></div>
</div>

<!DOCTYPE html>
<html>
<head>
    <title>My Library Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F6F7;
            margin: 0;
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
            height: 100vh; /* Full viewport height */
            flex-direction: column; /* Allow column direction to stack the content */
        }

        .container {
            background: white;
            padding: 30px;
            max-width: 500px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%; /* Ensure container uses available width */
        }

        h2 {
            color: #2E86C1;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            color: white;
            background-color: #2E86C1;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #1A5276;
        }

        .no-card {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Library Card</h2>

    <?php if ($card && !empty($card['file_name'])): ?>
        <a href="<?= $card['file_name'] ?>" target="_blank" class="btn">Preview Card</a>
        <a href="<?= $card['file_name'] ?>" download class="btn">Download Card</a>
    <?php else: ?>
        <p class="no-card">Your library card has not been generated yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
