<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function config(string $key, mixed $default = null): mixed
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/app.php';
    }

    return $config[$key] ?? $default;
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}
