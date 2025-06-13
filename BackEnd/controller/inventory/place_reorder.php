<?php
require_once __DIR__ . '/../../config/init.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$itemId = $input['item_id'] ?? null;
$reorderQuantity = $input['reorder_quantity'] ?? null;
if (!$itemId || !is_numeric($reorderQuantity) || $reorderQuantity < 1) {
  echo json_encode(['success' => false, 'message' => 'Invalid input']);
  exit;
}
$updated_at= date("Y-m-d H:i:s");

$sql = "UPDATE stock SET record_qty = :reorder_qty, updated_at = :updated_at WHERE id = :id";
$result = db_query($sql, ['reorder_qty' => (int)$reorderQuantity, 'id' => (int)$itemId, 'updated_at'=>$updated_at]);


if ($result) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to place reorder']);
}


