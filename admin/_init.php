<?php
declare(strict_types=1);

session_start();

require_once dirname(__DIR__) . '/includes/content_store.php';

/** @return array<string, mixed> */
function admin_config(): array
{
    $local = __DIR__ . '/config.local.php';
    if (!is_file($local)) {
        return [];
    }
    $c = require $local;
    return is_array($c) ? $c : [];
}

function admin_csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function admin_verify_csrf(?string $token): bool
{
    return is_string($token) && isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function admin_require_login(): void
{
    if (empty($_SESSION['admin_ok'])) {
        header('Location: /admin/login', true, 302);
        exit;
    }
}

function admin_attempt_login(string $password): bool
{
    $hash = admin_config()['admin_password_hash'] ?? '';
    if (!is_string($hash) || $hash === '') {
        return false;
    }
    return password_verify($password, $hash);
}

function admin_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], (bool) $p['secure'], true);
    }
    session_destroy();
}
