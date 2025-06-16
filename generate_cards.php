<?php
session_start();
include('admin_sidebar.php');
include('db.php');

// Fetch only approved applications
$sql = "SELECT l.id, l.application_date, s.name, s.student_id, lc.file_name 
        FROM library_card_applications l 
        JOIN students s ON l.student_id = s.student_id 
        LEFT JOIN library_cards lc ON s.student_id = lc.student_id
        WHERE l.status = 'Approved'
        ORDER BY l.application_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Applications</title>
    <style>
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
    </style>
</head>
<body>

<div class="topbar">Approved Applications</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Date</th>
                <th>Student Name</th>
                <th>Student ID</th>
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
                        <td>
                            <?php if ($row['file_name']): ?>
                                <!-- View Card Button -->
                                <a href="<?= $row['file_name'] ?>" target="_blank" class="btn">View Card</a>
                                <!-- Delete Card Button -->
                                <a href="delete_card.php?file=<?= urlencode($row['file_name']) ?>&student_id=<?= $row['student_id'] ?>" class="btn btn-danger">Delete Card</a>
                            <?php else: ?>
                                <!-- Generate Card Button -->
                                <a href="generatepdfcard.php?student_id=<?= $row['student_id'] ?>" class="btn">Generate Card</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No approved applications found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
</body>
</html>



