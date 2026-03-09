<?php
// process.php

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

// sanitize output for display
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
