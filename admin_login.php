<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Library Admin</title>
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
        }
        .card-title {
            color: #10375C;
            font-weight: bold;
        }
        .login-title {
            text-align: center;
            margin-top: 40px;
            font-size: 28px;
            font-weight: 700;
            color: #F3C623;
        }
        .form-control {
            color: #10375C;
            font-weight: bold;
            border-radius: 8px;
            padding: 10px;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(100, 55, 0, 0.4);
            border-color: #10375C;
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
    </style>
</head>
<body>
    <div class="login-title">Library System</div>
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 420px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Admin Login</h4>
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
                    <button class="btn btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

