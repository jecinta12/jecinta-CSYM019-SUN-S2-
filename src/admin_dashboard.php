<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 40px;
        }
        .dashboard {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        a.logout-btn {
            display: inline-block;
            margin-top: 20px;
            background: #cc0000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a.logout-btn:hover {
            background: #a30000;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin']) ?>!</h1>
    <p>You are now logged in as an administrator.</p>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
