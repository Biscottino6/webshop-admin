<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function is_admin(): bool
{
    return is_logged_in() && (($_SESSION['user_role'] ?? '') === 'admin');
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('index.php?page=login');
    }
}

function require_admin(): void
{
    if (!is_admin()) {
        http_response_code(403);
        echo 'Zugriff verweigert.';
        exit;
    }
}

function login_user(array $user): void
{
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['user_name'] = (string) $user['name'];
    $_SESSION['user_role'] = (string) $user['role'];
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
