<?php
$host = 'db';
$db = 'mi_db';
$user = 'user';
$pass = 'password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// ensure users table exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";
$result = $conn->query($sql);
$users = [];
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
}
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Users Table</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <div class="container">
    <h1>Users List</h1>
    <p class="note">Select a row to highlight it. Use the red Delete button to remove a user.</p>
    <?php if (count($users) === 0): ?>
      <div class="empty">No users found. Register users first at <a href="../index.html">Registration</a>.</div>
    <?php else: ?>
      <table id="users-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr data-id="<?= htmlspecialchars($user['id']) ?>">
              <td><?= htmlspecialchars($user['id']) ?></td>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['created_at']) ?></td>
              <td>
                <form method="post" action="delete_user.php" onsubmit="return confirm('Delete this user?');">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>" />
                  <button type="submit" class="btn-delete">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <p class="links"><a href="../index.html">Register user</a> | <a href="../Update-User/index.html">Update user</a></p>
  </div>

  <script>
    const rows = document.querySelectorAll('#users-table tbody tr');
    rows.forEach(row => {
      row.addEventListener('click', () => {
        rows.forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');
      });
    });
  </script>
</body>

</html>