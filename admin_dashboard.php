<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}
include('admin_sidebar.php');
include('db.php');

// Fetch counts
$totalApplications = $conn->query("SELECT COUNT(*) AS total FROM library_card_applications")->fetch_assoc()['total'];
$approvedApplications = $conn->query("SELECT COUNT(*) AS approved FROM library_card_applications WHERE status = 'Approved'")->fetch_assoc()['approved'];
$deniedApplications = $conn->query("SELECT COUNT(*) AS denied FROM library_card_applications WHERE status = 'Denied'")->fetch_assoc()['denied'];
$totalStudents = $conn->query("SELECT COUNT(*) AS students FROM students")->fetch_assoc()['students'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F4F6F7;
            margin: 0;
        }

        .topbar {
            background-color: #2E86C1;
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-left: 250px; /* Push away from sidebar */
            margin-top: 100px;
            padding: 40px 10px;
            gap: 30px;
        }

        .card {
            background-color: white;
            width: 250px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 15px;
            color: #2E86C1;
            font-size: 20px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="page-title">Admin Dashboard</div>
</div>

<div class="dashboard-container">
    <div class="card">
        <h3>Total Applications</h3>
        <p><?= $totalApplications ?></p>
    </div>

    <div class="card">
        <h3>Approved Applications</h3>
        <p><?= $approvedApplications ?></p>
    </div>

    <div class="card">
        <h3>Denied Applications</h3>
        <p><?= $deniedApplications ?></p>
    </div>

    <div class="card">
        <h3>Total Students</h3>
        <p><?= $totalStudents ?></p>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>

