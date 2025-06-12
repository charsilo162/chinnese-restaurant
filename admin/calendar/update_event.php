<?php
require_once __DIR__ . '/../../BackEnd/config/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['data_type' => 'message', 'message' => 'Invalid request.']);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['id'])) {
  echo json_encode(['data_type' => 'message', 'message' => 'Missing event ID.']);
  exit;
}

$params = [
  'title' => $data['title'],
  'type' => $data['type'],
  'event_date' => $data['date'],
  'start_time' => $data['startTime'],
  'end_time' => $data['endTime'],
  'venue' => $data['venue'],
  'notes' => $data['notes'],
  'id' => $data['id'],
  'user_id' => $_SESSION['user_id']
];

$query = "
  UPDATE events
  SET title = :title, type = :type, event_date = :event_date,
      start_time = :start_time, end_time = :end_time,
      venue = :venue, notes = :notes
  WHERE id = :id AND user_id = :user_id
";

if (db_query($query, $params)) {
  echo json_encode(['data_type' => 'event_updated', 'message' => 'Updated successfully.']);
} else {
  echo json_encode(['data_type' => 'message', 'message' => 'Update failed.']);
}
