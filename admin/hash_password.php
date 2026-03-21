#!/usr/bin/env php
<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    fwrite(STDERR, "CLI only.\n");
    exit(1);
}

$pass = $argv[1] ?? '';
if ($pass === '') {
    fwrite(STDERR, "Usage: php admin/hash_password.php 'YourPassword'\n");
    exit(1);
}

echo password_hash($pass, PASSWORD_DEFAULT), "\n";
