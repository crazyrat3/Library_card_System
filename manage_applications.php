<?php
session_start();
include('admin_sidebar.php');
include('db.php');

// Fetch all applications (Pending, Approved, Denied)
$sql = "SELECT l.id, l.application_date, s.name, s.student_id, l.status 
        FROM library_card_applications l 
        JOIN students s ON l.student_id = s.student_id
        ORDER BY l.application_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Applications</title>
    <style>
        /* Style similar to the one used in approved applications */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F9F9;
        }

        .topbar {
            background-color: #2E86C1;
            color: white;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 1000px;
            margin: 100px auto 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #EAF2F8;
        }

        .btn {
            padding: 6px 14px;
            background-color: #2E86C1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1B4F72;
        }

        .btn-danger {
            background-color: #C0392B;
        }

        .btn-danger:hover {
            background-color: #A93226;
        }

        .btn-warning {
            background-color: #F39C12;
        }

        .btn-warning:hover {
            background-color: #E67E22;
        }
    </style>
</head>
<body>

<div class="topbar">Manage Applications</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Date</th>
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['application_date'])) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['student_id'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
    <?php if ($row['status'] == 'Pending'): ?>
        <a href="update_application_status.php?id=<?= $row['id'] ?>&status=Approved" class="btn">Approve</a>
        <a href="update_application_status.php?id=<?= $row['id'] ?>&status=Denied" class="btn btn-danger">Deny</a>
    <?php elseif ($row['status'] == 'Approved'): ?>
        <a href="update_application_status.php?id=<?= $row['id'] ?>&status=Denied" class="btn btn-danger">Deny</a>
    <?php elseif ($row['status'] == 'Denied'): ?>
        <a href="update_application_status.php?id=<?= $row['id'] ?>&status=Approved" class="btn">Approve</a>
        <a href="update_application_status.php?id=<?= $row['id'] ?>&status=Pending" class="btn btn-warning">Revert to Pending</a>
    <?php endif; ?>
    <a href="delete_application.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
</td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No applications found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
</body>
</html>
