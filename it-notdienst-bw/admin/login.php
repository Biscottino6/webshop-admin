<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Ungültiges Formular-Token.';
    }

    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if (!$errors) {
        $stmt = db()->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = :email AND role = :role LIMIT 1');
        $stmt->execute(['email' => $email, 'role' => 'admin']);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Admin-Login fehlgeschlagen.';
        } else {
            login_user($user);
            redirect('dashboard.php');
        }
    }
}
?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><title>Admin Login</title></head><body>
<h2>Admin Login</h2>
<?php foreach ($errors as $error): ?><p><?= e($error) ?></p><?php endforeach; ?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
  <label>E-Mail <input type="email" name="email" required></label><br>
  <label>Passwort <input type="password" name="password" required></label><br>
  <button type="submit">Einloggen</button>
</form>
</body></html>
