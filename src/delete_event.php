<?php
session_start();

$eventFile = __DIR__ . '/data/events.json';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$events = file_exists($eventFile) ? json_decode(file_get_contents($eventFile), true) : [];

if (isset($_GET['id']) && isset($events[$_GET['id']])) {
    unset($events[$_GET['id']]);
    $events = array_values($events); // Reindex to keep IDs in order
    file_put_contents($eventFile, json_encode($events, JSON_PRETTY_PRINT));
}

header('Location: index.php');
exit;
