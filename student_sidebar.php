<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>

    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add this in your header.php if not already present -->

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="student.png" alt="student" class="admin-img">
    <h2>MY PROFILE</h2>
  </div>

  <ul class="menu">
    <li><a href="home_page.php"><span class="material-symbols-outlined">
home
</span>Home</a></li>
    <li><a href="apply_card.php"><span class="material-symbols-outlined">
assignment
</span> Apply for Library Card</a></li>
<li><a href="student_status.php"><span class="material-symbols-outlined">fact_check</span>Check Application Status</a></li>



<li><a href="my_card.php"><span class="material-symbols-outlined">download</span> Get Card</a></li>

    
    
    
  </ul>

  <ul class="logout">
    <li><a href="student_logout.php"><span class="material-symbols-outlined">
logout
</span> Logout</a></li>
  </ul>
</div>


  <button id="toggleBtn"><</button>

 

  <script src="script.js"></script>

  </body>
  </html>