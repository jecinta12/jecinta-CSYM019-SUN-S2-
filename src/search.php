<?php
require_once 'includes/config.php';

$term = $_GET['term'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT * FROM events 
        WHERE (title LIKE ? OR description LIKE ?) 
        AND category LIKE ? 
        ORDER BY event_date ASC";

$stmt = $conn->prepare($sql);
$searchTerm = "%$term%";
$searchCategory = "%$category%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchCategory);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
  $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);