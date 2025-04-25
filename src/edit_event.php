<?php
session_start();

$eventFile = __DIR__ . '/data/events.json';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$events = file_exists($eventFile) ? json_decode(file_get_contents($eventFile), true) : [];
$successMessage = '';
$errorMessage = '';

if (!isset($_GET['id']) || !isset($events[$_GET['id']])) {
    $errorMessage = "Event not found.";
} else {
    $eventId = (int) $_GET['id'];
    $event = $events[$eventId];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $events[$eventId]['title'] = $_POST['title'] ?? $event['title'];
        $events[$eventId]['date'] = $_POST['date'] ?? $event['date'];
        $events[$eventId]['type'] = $_POST['type'] ?? $event['type'];
        $events[$eventId]['description'] = $_POST['description'] ?? $event['description'];

        file_put_contents($eventFile, json_encode($events, JSON_PRETTY_PRINT));
        $successMessage = "Event updated successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f2f2f2;
        }
        .form-box {
            background: white;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        input[type=text], input[type=date], textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .message {
            text-align: center;
            color: green;
        }
        .error {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Edit Event</h2>
        <?php if ($errorMessage): ?>
            <p class="error"><?= $errorMessage ?></p>
        <?php elseif (!empty($event)): ?>
            <?php if ($successMessage): ?><p class="message"><?= $successMessage ?></p><?php endif; ?>
            <form method="POST">
                <label>Title:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>

                <label>Date:</label>
                <input type="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>

                <label>Type:</label>
                <select name="type" required>
                    <option <?= $event['type'] === 'Conference' ? 'selected' : '' ?>>Conference</option>
                    <option <?= $event['type'] === 'Workshop' ? 'selected' : '' ?>>Workshop</option>
                    <option <?= $event['type'] === 'Concert' ? 'selected' : '' ?>>Concert</option>
                    <option <?= $event['type'] === 'Festival' ? 'selected' : '' ?>>Festival</option>
                    <option <?= $event['type'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>

                <label>Description:</label>
                <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>

                <button type="submit">Save Changes</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
