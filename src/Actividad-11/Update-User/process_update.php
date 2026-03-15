<?php
$host = 'db';
$db = 'mi_db';
$user = 'user';
$pass = 'password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Accept form POST to simulate PUT update logic
$method = strtoupper($_POST['_method'] ?? 'POST');
if ($method !== 'PUT') {
  echo 'Invalid request method. Use the update form.';
  exit;
}

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$password_confirmation = trim($_POST['password_confirmation'] ?? '');

if ($id <= 0 || $name === '' || $email === '' || $password === '' || $password_confirmation === '') {
  echo 'Please complete all fields and provide a valid user id.';
  exit;
}
if ($password !== $password_confirmation) {
  echo 'Passwords do not match.';
  exit;
}

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
if (!$stmt) {
  echo 'Error preparing update: ' . $conn->error;
  exit;
}
$stmt->bind_param('sssi', $name, $email, $hashed_password, $id);

if ($stmt->execute()) {
  if ($stmt->affected_rows > 0) {
    echo 'User updated successfully.';
  } else {
    echo 'No user found with that ID or no changes were made.';
  }
} else {
  echo 'Update failed: ' . $stmt->error;
}
$stmt->close();
$conn->close();
