<?php
session_start();
include('db.php'); // DB connection file

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM students WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_logged_in'] = true;
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['student_name'] = $row['name'];
            header('Location: home_page.php');
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Student Login - Hostel Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #10375C;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            border-radius: 10px;
            background: #F3C623;
            margin-top: 50px;
        }

        .card-title {
            color: #10375C;
            font-weight: bold;
            background: #F3C623;
        }

        .login-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #F3C623;
            margin-top: 20px;
        }

        .form-control {
            color: #10375C;
            font-weight: bold;
        }

        .btn {
            background-color: #10375C;
            border-color: #F3C623;
            color: #F3C623;
            font-weight: 600;
        }

        .btn:hover {
            background-color: #F3C623;
            border-color: #10375C;
            color: #10375C;
        }

        #btn-login {
            margin-right: 30px;
            width: 100%;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn-container a {
            width: 48%;
            text-align: center;
            display: inline-block;
            background-color: #F3C623;
            color: #10375C;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-container a:hover {
            background-color: #10375C;
            color: #F3C623;
        }

    </style>
</head>
<body>
    <div class="login-title">Library Student Login</div>
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 420px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Student Login</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <button class="btn" id="btn-login" type="submit">Login</button>
                    <div class="btn-container">
                        <a href="index.php">Not Registered?</a>
                     
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
