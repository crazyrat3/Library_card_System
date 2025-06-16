<?php
session_start();
include('admin_sidebar.php');
include('db.php');

// Get filter type (Approved, Denied, or Pending) from URL parameter or default to 'All'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

// Prepare the SQL query based on the selected filter
$sql = "SELECT l.id, l.application_date, l.status, s.name, s.student_id 
        FROM library_card_applications l 
        JOIN students s ON l.student_id = s.student_id";

// Add filter to the query
if ($filter !== 'All') {
    $sql .= " WHERE l.status = '$filter'";
}

$sql .= " ORDER BY l.application_date DESC";  // Ordering by application date
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Card Applications</title>
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
            max-width: 1100px;
            margin: 80px auto;
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
            padding: 6px 12px;
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

        .btn[disabled] {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-size: 13px;
        }

        .badge-approved { background-color: #28A745; }
        .badge-denied { background-color: #DC3545; }
        .badge-pending { background-color: #FFC107; color: black; }

        .filter-btn {
            padding: 10px 20px;
            font-size: 14px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            background-color: #2E86C1;
            color: white;
            border: none;
        }

        .filter-btn:hover {
            background-color: #1B4F72;
        }

        .filter-btn.active {
            background-color: #1B4F72;
        }
    </style>
</head>
<body>

<div class="topbar">Library Card Applications</div>

<div class="container">
    <!-- Filter buttons -->
    <div style="margin-bottom: 20px;">
        <a href="?filter=All" class="filter-btn <?= $filter === 'All' ? 'active' : '' ?>">All</a>
        <a href="?filter=Approved" class="filter-btn <?= $filter === 'Approved' ? 'active' : '' ?>">Approved</a>
        <a href="?filter=Denied" class="filter-btn <?= $filter === 'Denied' ? 'active' : '' ?>">Denied</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Date</th>
                <th>Student Name</th>
                <th>Status</th>
                <th>Actions</th>
                <th>More</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['application_date'])) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <?php
                                $status = $row['status'];
                                $badgeClass = "badge-pending";
                                if ($status === 'Approved') $badgeClass = "badge-approved";
                                else if ($status === 'Denied') $badgeClass = "badge-denied";
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="application_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn" <?= ($status !== 'Pending') ? 'disabled' : '' ?>>Approve</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="application_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="deny">
                                <button type="submit" class="btn" style="background-color:#DC3545;" <?= ($status !== 'Pending') ? 'disabled' : '' ?>>Deny</button>
                            </form>
                        </td>
                        <td>
                            <a href="student_details.php?student_id=<?= $row['student_id'] ?>" class="btn">More</a>
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
