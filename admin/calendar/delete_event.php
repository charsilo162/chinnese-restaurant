<?php
require_once __DIR__ . '/../../BackEnd/config/init.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['data_type' => 'message', 'message' => 'Invalid request.']);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
  echo json_encode(['data_type' => 'message', 'message' => 'Missing ID.']);
  exit;
}

$query = "DELETE FROM events WHERE id = :id AND user_id = :user_id";
$params = [
  'id' => $data['id'],
  'user_id' => $_SESSION['user_id']
];

if (db_query($query, $params)) {
  echo json_encode(['data_type' => 'event_deleted', 'message' => 'Deleted successfully.']);
} else {
  echo json_encode(['data_type' => 'message', 'message' => 'Delete failed.']);
}
