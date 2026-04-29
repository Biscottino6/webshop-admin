<section>
    <h2>Mein Konto</h2>
    <p>Willkommen, <?= e((string)($_SESSION['user_name'] ?? '')) ?>.</p>
    <p>Rolle: <?= e((string)($_SESSION['user_role'] ?? 'customer')) ?></p>
</section>
