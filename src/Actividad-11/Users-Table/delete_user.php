<?php
$host = 'db';
$db = 'mi_db';
$user = 'user';
$pass = 'password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
  echo 'Invalid user id.';
  exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
if (!$stmt) {
  echo 'Error preparing delete: ' . $conn->error;
  exit;
}
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  header('Location: index.php?deleted=1');
  exit;
} else {
  echo 'No user deleted. ID not found.';
}
$stmt->close();
$conn->close();
