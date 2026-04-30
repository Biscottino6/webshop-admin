<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Ungültiges Formular-Token.';
    }

    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $errors[] = 'Bitte E-Mail und Passwort eingeben.';
    }

    if (!$errors) {
        $stmt = db()->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Login fehlgeschlagen.';
        } else {
            login_user($user);
            redirect('index.php?page=account');
        }
    }
}
?>
<section>
    <h2>Login</h2>
    <?php foreach ($errors as $error): ?>
        <p><?= e($error) ?></p>
    <?php endforeach; ?>
    <form method="post" action="index.php?page=login">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <label>E-Mail <input type="email" name="email" required></label><br>
        <label>Passwort <input type="password" name="password" required></label><br>
        <button type="submit">Anmelden</button>
    </form>
</section>
