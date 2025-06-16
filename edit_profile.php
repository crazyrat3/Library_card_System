<?php
session_start();
include('student_sidebar.php');
include('db.php');

if (!isset($_SESSION['student_logged_in']) || !$_SESSION['student_logged_in']) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch current data
$query = "SELECT username, email, contact_no FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Student not found.";
    exit();
}

$student = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE students SET username = ?, email = ?, contact_no = ?, password = ? WHERE student_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssss", $username, $email, $contact_no, $hashed_password, $student_id);
    } else {
        $update_query = "UPDATE students SET username = ?, email = ?, contact_no = ? WHERE student_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssss", $username, $email, $contact_no, $student_id);
    }

    if ($stmt->execute()) {
        header("Location: home_page.php");
        exit();
    } else {
        echo "<p style='color:red;'>Update failed. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #F8F9F9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .edit-container {
            max-width: 600px;
            margin: 80px auto;
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
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .submit-btn {
            margin-top: 25px;
            background-color: #2E86C1;
            color: white;
            padding: 10px 20px;
            border: none;
            width: 100%;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #21618C;
        }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Profile</h2>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($student['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>

        <label>Contact No</label>
        <input type="text" name="contact_no" value="<?= htmlspecialchars($student['contact_no']) ?>" required>

        <label>New Password (leave blank to keep current)</label>
        <input type="password" name="password">

        <button type="submit" class="submit-btn">Save Changes</button>
    </form>
</div>

<?php include('footer.php'); ?>
</body>
</html>
