<?php
// process.php

$host = 'db';
$db = 'mi_db';
$user = 'user';
$pass = 'password';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// simple validation/trimming
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$password_confirmation = trim($_POST['password_confirmation'] ?? '');

// check required fields
if ($name === '' || $email === '' || $password === '' || $password_confirmation === '') {
  echo 'Please fill in all fields.';
  exit;
}

// check if passwords match
if ($password !== $password_confirmation) {
  echo 'Passwords do not match.';
  exit;
}

// create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
  echo 'User registered successfully!';
} else {
  echo 'Error: ' . $stmt->error;
}
$stmt->close();
$conn->close();

// sanitize output for display
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
