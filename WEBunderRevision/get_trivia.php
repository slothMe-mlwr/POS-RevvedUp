<?php
include "config.php"; // your database connection

// Option A: Pick trivia based on date (so it changes daily)
$day = date('j'); // 1–31
$query = $conn->query("SELECT * FROM trivia ORDER BY id LIMIT 1 OFFSET " . (($day - 1) % 10));

// Option B: Or pick random trivia (if you prefer it to change on refresh)
// $query = $conn->query("SELECT * FROM trivia ORDER BY RAND() LIMIT 1");

if ($row = $query->fetch_assoc()) {
  echo json_encode(['trivia' => $row['text']]);
} else {
  echo json_encode(['trivia' => 'No trivia available today.']);
}
?>
