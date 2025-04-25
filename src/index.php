<?php
session_start();

// File paths
$adminFile = __DIR__ . '/data/admins.json';
$eventFile = __DIR__ . '/data/events.json';

// Load events
$events = file_exists($eventFile) ? json_decode(file_get_contents($eventFile), true) : [];

$loginError = '';
$successMessage = '';

// Handle login
if (isset($_POST['login'])) {
    $admins = json_decode(file_get_contents($adminFile), true);
    $admin = $admins[0];

    if ($_POST['username'] === $admin['username'] && $_POST['password'] === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $admin['username'];
    } else {
        $loginError = "Invalid username or password.";
    }
}

// Handle event creation
if (isset($_POST['add_event']) && isset($_SESSION['admin_logged_in'])) {
    $newEvent = [
        "id" => count($events) + 1,
        "title" => $_POST['title'],
        "date" => $_POST['date'],
        "type" => $_POST['type'],
        "description" => $_POST['description']
    ];

    $events[] = $newEvent;
    file_put_contents($eventFile, json_encode($events, JSON_PRETTY_PRINT));
    $successMessage = "Event successfully created.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }
        .container {
            margin-left: 220px;
            padding: 20px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 200px;
            background-color: #2c3e50;
            padding-top: 30px;
            color: white;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
        }
        .header {
            padding: 10px 20px;
            background-color: #ecf0f1;
            border-bottom: 1px solid #ccc;
        }
        h1 {
            margin-top: 0;
        }
        .form-box, .event-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type=text], input[type=date], select, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #16a085;
        }
        .success { color: green; }
        .error { color: red; }
        .event {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Events</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <div class="header">
            <h1>Event Dashboard</h1>
        </div>

        <?php if (!isset($_SESSION['admin_logged_in'])): ?>
            <div class="form-box">
                <h2>Admin Login</h2>
                <?php if ($loginError): ?><p class="error"><?= htmlspecialchars($loginError) ?></p><?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="login" value="1">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                    <input type="submit" value="Login">
                </form>
            </div>
        <?php else: ?>
            <div class="form-box">
                <h2>Create New Event</h2>
                <?php if ($successMessage): ?><p class="success"><?= htmlspecialchars($successMessage) ?></p><?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="add_event" value="1">
                    <label>Event Title:</label>
                    <input type="text" name="title" required>

                    <label>Date:</label>
                    <input type="date" name="date" required>

                    <label>Type:</label>
                    <select name="type" required>
                        <option value="Conference">Conference</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Concert">Concert</option>
                        <option value="Festival">Festival</option>
                        <option value="Other">Other</option>
                    </select>

                    <label>Description:</label>
                    <textarea name="description" required></textarea>
                    <input type="submit" value="Add Event">
                </form>
            </div>

            <div class="event-list">
                <h2>All Events</h2>
                <?php foreach ($events as $event): ?>
                    <div class="event">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                        <p><strong>Type:</strong> <?= htmlspecialchars($event['type']) ?></p>
                        <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
