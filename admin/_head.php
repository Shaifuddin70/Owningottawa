<?php
declare(strict_types=1);
if (!isset($adminPageTitle)) {
    $adminPageTitle = 'Admin';
}
$t = htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8');

$adminNav = 'dashboard';
if (!empty($_SESSION['admin_ok'])) {
    $reqUri = (string) ($_SERVER['REQUEST_URI'] ?? '');
    if (strpos($reqUri, '/admin/videos') !== false) {
        $adminNav = 'videos';
    } elseif (strpos($reqUri, '/admin/testimonials') !== false) {
        $adminNav = 'testimonials';
    } elseif (strpos($reqUri, '/admin/blogs') !== false || strpos($reqUri, '/admin/blog_edit') !== false) {
        $adminNav = 'blog';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $t; ?> — OwningOttawa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --oo-gold: #c99741;
      --oo-dark: #1a1a1a;
      --admin-sidebar-w: 260px;
    }
    body { background: #f4f2ef; font-family: 'Nunito Sans', system-ui, sans-serif; }
    body.admin-sidebar-open { overflow: hidden; }

    .card-admin { border: none; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,.06); }
    .btn-oo-primary { background: var(--oo-gold); border-color: var(--oo-gold); color: #fff; }
    .btn-oo-primary:hover { background: #b8863a; border-color: #b8863a; color: #fff; }

    .admin-app {
      min-height: 100vh;
      display: flex;
      align-items: stretch;
    }

    .admin-sidebar {
      width: var(--admin-sidebar-w);
      flex-shrink: 0;
      background: var(--oo-dark);
      color: rgba(255,255,255,.9);
      display: flex;
      flex-direction: column;
      padding: 1.25rem 0 1rem;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      z-index: 1040;
      border-right: 1px solid rgba(255,255,255,.06);
    }

    .admin-sidebar-brand {
      padding: 0 1.25rem 1.25rem;
      border-bottom: 1px solid rgba(255,255,255,.08);
      margin-bottom: 0.75rem;
    }
    .admin-sidebar-brand a {
      color: var(--oo-gold);
      font-weight: 700;
      font-size: 1.1rem;
      text-decoration: none;
    }
    .admin-sidebar-brand a:hover { color: #ddb863; }

    .admin-sidebar-nav {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
      padding: 0 0.75rem;
      flex: 1;
    }

    .admin-sidebar-link {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      padding: 0.65rem 0.85rem;
      border-radius: 8px;
      color: rgba(255,255,255,.88);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: background .15s ease, color .15s ease;
    }
    .admin-sidebar-link:hover {
      background: rgba(255,255,255,.08);
      color: #fff;
    }
    .admin-sidebar-link.active {
      background: rgba(201, 151, 65, .22);
      color: var(--oo-gold);
    }
    .admin-sidebar-link i { width: 1.25rem; text-align: center; opacity: .9; }

    .admin-sidebar-footer {
      padding: 1rem 1.25rem 0;
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,.08);
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    .admin-sidebar-footer a {
      color: rgba(255,255,255,.55);
      font-size: 0.875rem;
      text-decoration: none;
    }
    .admin-sidebar-footer a:hover { color: var(--oo-gold); }
    .admin-sidebar-footer .btn-logout {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem 0.75rem;
      border: 1px solid rgba(255,255,255,.25);
      border-radius: 8px;
      color: #fff;
      font-weight: 600;
      margin-top: 0.25rem;
    }
    .admin-sidebar-footer .btn-logout:hover {
      background: rgba(255,255,255,.1);
      border-color: rgba(255,255,255,.35);
      color: #fff;
    }

    .admin-sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.45);
      z-index: 1035;
      pointer-events: none;
      opacity: 0;
      transition: opacity .2s ease;
    }

    .admin-main {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      background: #f4f2ef;
    }

    .admin-mobile-header {
      position: sticky;
      top: 0;
      z-index: 1020;
      min-height: 56px;
      padding: 0.5rem 1rem;
      background: var(--oo-dark);
      border-bottom: 1px solid rgba(255,255,255,.08);
      gap: 0.75rem;
    }

    .admin-menu-toggle {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      padding: 0;
      border: none;
      border-radius: 8px;
      background: rgba(255,255,255,.1);
      color: #fff;
      cursor: pointer;
    }
    .admin-menu-toggle:hover { background: rgba(255,255,255,.18); }
    .admin-menu-toggle:focus { outline: 2px solid var(--oo-gold); outline-offset: 2px; }

    .admin-mobile-title {
      color: rgba(255,255,255,.9);
      font-weight: 700;
      font-size: 1rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 991.98px) {
      .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        transform: translateX(-102%);
        transition: transform .25s ease;
        box-shadow: 4px 0 32px rgba(0,0,0,.25);
      }
      .admin-app.admin-sidebar-open .admin-sidebar {
        transform: translateX(0);
      }
      .admin-app.admin-sidebar-open .admin-sidebar-backdrop {
        display: block;
        pointer-events: auto;
        opacity: 1;
      }
    }
  </style>
</head>
<body>
<?php if (!empty($_SESSION['admin_ok'])): ?>
<div class="admin-app" id="adminApp">
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <div class="admin-sidebar-brand">
      <a href="/admin/">OwningOttawa Admin</a>
    </div>
    <nav class="admin-sidebar-nav">
      <a class="admin-sidebar-link<?php echo $adminNav === 'dashboard' ? ' active' : ''; ?>" href="/admin/">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a class="admin-sidebar-link<?php echo $adminNav === 'videos' ? ' active' : ''; ?>" href="/admin/videos">
        <i class="fas fa-video"></i> Videos
      </a>
      <a class="admin-sidebar-link<?php echo $adminNav === 'testimonials' ? ' active' : ''; ?>" href="/admin/testimonials">
        <i class="fas fa-quote-left"></i> Testimonials
      </a>
      <a class="admin-sidebar-link<?php echo $adminNav === 'blog' ? ' active' : ''; ?>" href="/admin/blogs">
        <i class="fas fa-blog"></i> Blog
      </a>
    </nav>
    <div class="admin-sidebar-footer">
      <a href="/" target="_blank" rel="noopener"><i class="fas fa-external-link-alt me-1"></i> View site</a>
      <a class="btn-logout" href="/admin/logout"><i class="fas fa-sign-out-alt me-1"></i> Log out</a>
    </div>
  </aside>
  <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" role="presentation" aria-hidden="true"></div>
  <div class="admin-main">
    <header class="admin-mobile-header d-flex d-lg-none align-items-center">
      <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-controls="adminSidebar" aria-expanded="false" aria-label="Open menu">
        <i class="fas fa-bars fa-lg"></i>
      </button>
      <span class="admin-mobile-title flex-grow-1"><?php echo $t; ?></span>
    </header>
    <div class="container-fluid px-3 px-lg-4 py-3 py-lg-4 pb-5">
<?php else: ?>
<div class="container pb-5">
<?php endif; ?>
