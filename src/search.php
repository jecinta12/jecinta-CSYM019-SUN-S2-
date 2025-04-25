<?php
$eventsData = file_get_contents(__DIR__ . '/data/events.json');
$events = json_decode($eventsData, true);

$searchTerm = strtolower($_GET['query'] ?? '');

$filtered = array_filter($events, function ($event) use ($searchTerm) {
    return strpos(strtolower($event['title']), $searchTerm) !== false ||
           strpos(strtolower($event['description']), $searchTerm) !== false;
});

header('Content-Type: application/json');
echo json_encode(array_values($filtered));
