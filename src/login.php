<?php
session_start();

$adminFile = __DIR__ . '/data/admins.json';
$eventFile = __DIR__ . '/data/events.json';
$loginError = '';

$events = file_exists($eventFile) ? json_decode(file_get_contents($eventFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admins = json_decode(file_get_contents($adminFile), true);
    $admin = $admins[0];
    $inputUser = $_POST['username'] ?? '';
    $inputPass = $_POST['password'] ?? '';

    if ($inputUser === $admin['username'] && $inputPass === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $inputUser;
        header('Location: index.php');
        exit;
    } else {
        $loginError = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ece9e6, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px;
            gap: 40px;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .events-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
        }
        form label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-btn {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            text-align: center;
        }
        .event {
            padding: 10px 15px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .event:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="events-box">
        <h2>Available Events</h2>
        <?php if (empty($events)): ?>
            <p>No events available.</p>
        <?php else: ?>
            <?php foreach ($events as $event): ?>
                <div class="event">
                    <h3><?= htmlspecialchars($event['title']) ?></h3>
                    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                    <p><strong>Type:</strong> <?= isset($event['type']) ? htmlspecialchars($event['type']) : 'N/A' ?></p>
                    <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if (!empty($loginError)): ?>
            <p class="error"><?= htmlspecialchars($loginError) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button class="login-btn" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
