<?php
require_once 'includes/config.php';

$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Community Events</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>Upcoming Events</h1>
  
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search events...">
    <select id="categoryFilter">
      <option value="">All Categories</option>
      <option value="Workshop">Workshop</option>
      <option value="Seminar">Seminar</option>
    </select>
  </div>

  <div id="eventList">
    <?php while($event = $result->fetch_assoc()): ?>
      <div class="event-card">
        <h3><?= htmlspecialchars($event['title']) ?></h3>
        <p>Date: <?= htmlspecialchars($event['event_date']) ?></p>
        <p>Location: <?= htmlspecialchars($event['location']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>