<?php
require_once __DIR__ . '/includes/helpers.php';
$page = $_GET['page'] ?? 'home';
$allowed = [
    'home','shop','service-detail','cart','checkout','prices','contact','about','faq','reviews',
    'account','login','register','logout','impressum','datenschutz','status'
];
if (!in_array($page, $allowed, true)) {
    $page = 'home';
}
require __DIR__ . '/includes/header.php';
require __DIR__ . '/pages/' . $page . '.php';
require __DIR__ . '/includes/footer.php';
