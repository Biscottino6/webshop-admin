<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Ungültiges Formular-Token.';
    }

    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        $errors[] = 'Bitte alle Felder ausfüllen.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail eingeben.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Passwort muss mindestens 8 Zeichen haben.';
    }

    if (!$errors) {
        $stmt = db()->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = 'E-Mail ist bereits registriert.';
        } else {
            $insert = db()->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
            $insert->execute([
                'name' => $name,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'customer',
            ]);
            redirect('index.php?page=login');
        }
    }
}
?>
<section>
    <h2>Registrieren</h2>
    <?php foreach ($errors as $error): ?>
        <p><?= e($error) ?></p>
    <?php endforeach; ?>
    <form method="post" action="index.php?page=register">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <label>Name <input type="text" name="name" required></label><br>
        <label>E-Mail <input type="email" name="email" required></label><br>
        <label>Passwort <input type="password" name="password" minlength="8" required></label><br>
        <button type="submit">Konto erstellen</button>
    </form>
</section>
