<?php
require_once __DIR__ . '/../includes/db.php';

$stmt = db()->query('SELECT id, title, description, price FROM services WHERE active = 1 ORDER BY id DESC');
$services = $stmt->fetchAll();
?>
<section>
    <h2>Shop</h2>
    <?php if (!$services): ?>
        <p>Aktuell sind keine Services verfügbar.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($services as $service): ?>
                <li>
                    <strong><?= e($service['title']) ?></strong>
                    - <?= e((string)$service['price']) ?> €<br>
                    <small><?= e((string)$service['description']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
