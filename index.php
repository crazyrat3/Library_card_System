<?php include('db.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <!-- Bootstrap and Google Fonts for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #10375C;
        }

        .container {
            background-color: #F3C623;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .form-group label {
            font-weight: 500;
            color: #10375C;
        }

        .btn-primary {
            background-color: #10375C;
            border-color: #F3C623 ;
            color:  #F3C623;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color:  #F3C623 ;
            border-color: #10375C;
            color: #10375C;
        }

        .alert {
            border-radius: 8px;
            font-weight: 500;
        }

        .page-title {
            color:  #10375C;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
           
        }

        .form-check-input {
            margin-right: 10px;
        }

        .form-check-label {
            font-weight: 500;
        }
        #login-btn{
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="page-title">STUDENT REGISTRATION</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact_no = $_POST['contact_no'];
        $class = $_POST['class'];
        $year = $_POST['year'];
        $department = $_POST['department'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password

        $sql = "INSERT INTO students 
                (name, email, contact_no, class, year, department, gender, address, username, password)
                VALUES 
                ('$name', '$email', '$contact_no', '$class', '$year', '$department', '$gender', '$address', '$username', '$password')";

        if (mysqli_query($conn, $sql)) {
            header("Location: student_login.php");
        exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Class</label>
            <input type="text" name="class" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Year</label>
            <select name="year" class="form-control" required>
                <option value="">-- Select Year --</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>
        </div>

        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="Male" required>
                <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="Female">
                <label class="form-check-label">Female</label>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">REGISTER</button>
        <a href="student_login.php"  class="btn btn-primary w-100" id="login-btn">LOGIN</a>
        
    </form>
</div>

</body>
</html>

<?php include('footer.php'); ?>