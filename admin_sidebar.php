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
    <img src="admin_bonafide.png" alt="Admin" class="admin-img">
    <h2>ADMIN</h2>
  </div>

  <ul class="menu">
  <li><a href="admin_dashboard.php"><span class="material-symbols-outlined">dashboard</span>Dashboard</a></li>
  <li><a href="admin_view_applications.php"><span class="material-symbols-outlined">description</span> View Application</a></li>
  <li><a href="admin_application_status.php"><span class="material-symbols-outlined">fact_check</span> Approve or Deny </a></li>
  <li><a href="generate_cards.php"><span class="material-symbols-outlined">receipt_long</span> Generate Card</a></li>
  <li><a href="manage_applications.php"><span class="material-symbols-outlined">upload</span> Manage Applications</a></li>
</ul>

<ul class="logout">
  <li><a href="admin_logout.php"><span class="material-symbols-outlined">logout</span> Logout</a></li>
</ul>
</div>


  <button id="toggleBtn"><</button>

 

  <script src="script.js"></script>

  </body>
  </html>