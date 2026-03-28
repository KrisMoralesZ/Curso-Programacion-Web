<?php
$host = 'db';
$db = 'mi_db';
$user = 'user';
$pass = 'password';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

echo "Conexión exitosa a MySQL";
