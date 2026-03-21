<?php

declare(strict_types=1);

/**
 * SQLite-backed videos & testimonials for public site + admin CRUD.
 */

function content_db_path(): string
{
    return dirname(__DIR__) . '/data/content.sqlite';
}

function content_pdo(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dir = dirname(content_db_path());
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $pdo = new PDO('sqlite:' . content_db_path(), null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        content_migrate($pdo);
    }
    return $pdo;
}

function content_testimonials_has_column(PDO $pdo, string $column): bool
{
    $stmt = $pdo->query('PRAGMA table_info(testimonials)');
    if ($stmt === false) {
        return false;
    }
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if (($row['name'] ?? '') === $column) {
            return true;
        }
    }
    return false;
}

function content_migrate(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS videos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL DEFAULT \'\',
            description TEXT NOT NULL DEFAULT \'\',
            video_url TEXT NOT NULL,
            thumbnail_url TEXT NOT NULL DEFAULT \'\',
            sort_order INTEGER NOT NULL DEFAULT 0,
            is_active INTEGER NOT NULL DEFAULT 1,
            created_at TEXT NOT NULL DEFAULT (datetime(\'now\'))
        );
        CREATE TABLE IF NOT EXISTS testimonials (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            quote TEXT NOT NULL,
            author_name TEXT NOT NULL,
            author_role TEXT NOT NULL DEFAULT \'\',
            rating INTEGER NOT NULL DEFAULT 5,
            avatar_url TEXT NOT NULL DEFAULT \'\',
            sort_order INTEGER NOT NULL DEFAULT 0,
            is_active INTEGER NOT NULL DEFAULT 1,
            approval_status TEXT NOT NULL DEFAULT \'approved\',
            created_at TEXT NOT NULL DEFAULT (datetime(\'now\'))
        );
        CREATE TABLE IF NOT EXISTS blogs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            excerpt TEXT NOT NULL DEFAULT \'\',
            body TEXT NOT NULL DEFAULT \'\',
            image_url TEXT NOT NULL DEFAULT \'\',
            sort_order INTEGER NOT NULL DEFAULT 0,
            is_active INTEGER NOT NULL DEFAULT 1,
            created_at TEXT NOT NULL DEFAULT (datetime(\'now\')),
            updated_at TEXT NOT NULL DEFAULT (datetime(\'now\'))
        );'
    );

    if (!content_testimonials_has_column($pdo, 'approval_status')) {
        $pdo->exec(
            "ALTER TABLE testimonials ADD COLUMN approval_status TEXT NOT NULL DEFAULT 'approved'"
        );
    }

    $count = (int) $pdo->query('SELECT COUNT(*) FROM testimonials')->fetchColumn();
    if ($count > 0) {
        return;
    }

    $defaults = [
        [
            'Shubham Duggal & his team is always there for all the questions I had even before start working with them. They are so professional and always on time .....',
            'Jean Rony Pierre',
        ],
        [
            'Shubham is highly responsive. He listens and understands your preferences and gives you great options that match your needs.',
            'Urmi Ramchandani',
        ],
        [
            'Shubham Duggal and his team always there to help me. With selling my condo and purchase my new townhouse. Very professional ......',
            'Jeenu Rikhi',
        ],
    ];

    $stmt = $pdo->prepare(
        'INSERT INTO testimonials (quote, author_name, rating, sort_order, is_active) VALUES (?,?,5,?,1)'
    );
    foreach ($defaults as $i => $row) {
        $stmt->execute([$row[0], $row[1], $i]);
    }
}

function content_youtube_id(string $url): ?string
{
    $url = trim($url);
    if ($url === '') {
        return null;
    }

    $patterns = [
        '~(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([a-zA-Z0-9_-]{11})~',
        '~youtube\.com/shorts/([a-zA-Z0-9_-]{11})~',
    ];
    foreach ($patterns as $p) {
        if (preg_match($p, $url, $m)) {
            return $m[1];
        }
    }
    return null;
}

function content_vimeo_id(string $url): ?string
{
    $url = trim($url);
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
        return $m[1];
    }
    return null;
}

/** Returns [ type => youtube|vimeo|unknown, embed => url, thumb => url|null ] */
function content_video_resolve(string $videoUrl, string $thumbOverride = ''): array
{
    $videoUrl = trim($videoUrl);
    $thumbOverride = trim($thumbOverride);

    $yt = content_youtube_id($videoUrl);
    if ($yt !== null) {
        $thumb = $thumbOverride !== ''
            ? $thumbOverride
            : 'https://img.youtube.com/vi/' . $yt . '/hqdefault.jpg';
        return [
            'type' => 'youtube',
            'embed' => 'https://www.youtube.com/embed/' . $yt . '?rel=0',
            'thumb' => $thumb,
        ];
    }

    $vm = content_vimeo_id($videoUrl);
    if ($vm !== null) {
        return [
            'type' => 'vimeo',
            'embed' => 'https://player.vimeo.com/video/' . $vm,
            'thumb' => $thumbOverride !== '' ? $thumbOverride : '',
        ];
    }

    return [
        'type' => 'unknown',
        'embed' => $videoUrl,
        'thumb' => $thumbOverride,
    ];
}

/** @return list<array<string,mixed>> */
function content_get_active_videos(): array
{
    $pdo = content_pdo();
    $stmt = $pdo->query(
        'SELECT * FROM videos WHERE is_active = 1 ORDER BY sort_order ASC, id ASC'
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/** @return list<array<string,mixed>> */
function content_get_active_testimonials(): array
{
    $pdo = content_pdo();
    $stmt = $pdo->query(
        "SELECT * FROM testimonials WHERE is_active = 1 AND approval_status = 'approved' ORDER BY sort_order ASC, id ASC"
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function content_blog_slugify(string $title): string
{
    $s = strtolower(trim($title));
    $s = preg_replace('~[^a-z0-9]+~', '-', $s);
    $s = trim($s, '-');
    return $s !== '' ? $s : 'post-' . bin2hex(random_bytes(4));
}

function content_blog_unique_slug(PDO $pdo, string $slug, int $excludeId = 0): string
{
    $base = $slug;
    $n = 0;
    while (true) {
        $stmt = $pdo->prepare('SELECT id FROM blogs WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $excludeId]);
        if (!$stmt->fetch()) {
            return $slug;
        }
        $n++;
        $slug = $base . '-' . $n;
    }
}

/** Public URL path prefix for blog thumbnails stored on disk. */
function content_blog_upload_public_prefix(): string
{
    return '/uploads/blogs/';
}

function content_blog_upload_abs_dir(): string
{
    return dirname(__DIR__) . '/uploads/blogs';
}

/**
 * @param array<string,mixed> $file One element of $_FILES (e.g. $_FILES['thumbnail'])
 * @return array{ok:bool,path:?string,error:?string} path is web path like /uploads/blogs/… or null if no file
 */
function content_blog_handle_thumbnail_upload(array $file): array
{
    if (!isset($file['error'])) {
        return ['ok' => true, 'path' => null, 'error' => null];
    }
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'path' => null, 'error' => null];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => null, 'error' => 'Upload failed (code ' . (int) $file['error'] . ').'];
    }
    $tmp = $file['tmp_name'] ?? '';
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return ['ok' => false, 'path' => null, 'error' => 'Invalid upload.'];
    }
    $maxBytes = 5 * 1024 * 1024;
    if ((int) ($file['size'] ?? 0) > $maxBytes) {
        return ['ok' => false, 'path' => null, 'error' => 'Image must be 5MB or smaller.'];
    }

    $mime = '';
    if (class_exists('finfo')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $finfo->file($tmp);
    } else {
        $info = @getimagesize($tmp);
        if ($info === false) {
            return ['ok' => false, 'path' => null, 'error' => 'Could not read image.'];
        }
        switch ($info[2] ?? 0) {
            case IMAGETYPE_JPEG:
                $mime = 'image/jpeg';
                break;
            case IMAGETYPE_PNG:
                $mime = 'image/png';
                break;
            case IMAGETYPE_GIF:
                $mime = 'image/gif';
                break;
            case IMAGETYPE_WEBP:
                $mime = 'image/webp';
                break;
            default:
                $mime = '';
        }
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    if (!isset($allowed[$mime])) {
        return ['ok' => false, 'path' => null, 'error' => 'Use JPEG, PNG, WebP, or GIF only.'];
    }
    $ext = $allowed[$mime];

    $dir = content_blog_upload_abs_dir();
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        return ['ok' => false, 'path' => null, 'error' => 'Could not create uploads folder.'];
    }

    $name = 'blog-' . bin2hex(random_bytes(16)) . '.' . $ext;
    $full = $dir . '/' . $name;
    if (!move_uploaded_file($tmp, $full)) {
        return ['ok' => false, 'path' => null, 'error' => 'Could not save the image.'];
    }

    return ['ok' => true, 'path' => content_blog_upload_public_prefix() . $name, 'error' => null];
}

/** Remove a previously uploaded blog image (path must be under /uploads/blogs/). */
function content_blog_delete_uploaded_thumbnail(?string $pathOrUrl): void
{
    if ($pathOrUrl === null || $pathOrUrl === '') {
        return;
    }
    $prefix = content_blog_upload_public_prefix();
    if (strpos($pathOrUrl, $prefix) !== 0) {
        return;
    }
    $full = dirname(__DIR__) . $pathOrUrl;
    if (is_file($full)) {
        @unlink($full);
    }
}

/** @return list<array<string,mixed>> Published posts (for a future public blog listing). */
function content_get_active_blogs(): array
{
    $pdo = content_pdo();
    $stmt = $pdo->query(
        'SELECT * FROM blogs WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC, id DESC'
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/** Single published post by URL slug, or null. */
/** @return array<string,mixed>|null */
function content_get_blog_by_slug(string $slug): ?array
{
    $slug = trim($slug);
    if ($slug === '') {
        return null;
    }
    $pdo = content_pdo();
    $stmt = $pdo->prepare('SELECT * FROM blogs WHERE slug = ? AND is_active = 1');
    $stmt->execute([$slug]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}
