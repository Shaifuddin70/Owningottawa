<?php
declare(strict_types=1);
if (!isset($adminPageTitle)) {
    $adminPageTitle = 'Admin';
}
$t = htmlspecialchars($adminPageTitle, ENT_QUOTES, 'UTF-8');
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
    :root { --oo-gold: #c99741; --oo-dark: #1a1a1a; }
    body { background: #f4f2ef; font-family: 'Nunito Sans', system-ui, sans-serif; }
    .admin-nav { background: var(--oo-dark); }
    .admin-nav .navbar-brand { color: var(--oo-gold) !important; font-weight: 700; }
    .admin-nav .nav-link { color: rgba(255,255,255,.85) !important; }
    .admin-nav .nav-link:hover { color: var(--oo-gold) !important; }
    .card-admin { border: none; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,.06); }
    .btn-oo-primary { background: var(--oo-gold); border-color: var(--oo-gold); color: #fff; }
    .btn-oo-primary:hover { background: #b8863a; border-color: #b8863a; color: #fff; }
  </style>
</head>
<body>
<?php if (!empty($_SESSION['admin_ok'])): ?>
<nav class="navbar navbar-expand-lg admin-nav mb-4">
  <div class="container">
    <a class="navbar-brand" href="/admin/">OwningOttawa Admin</a>
    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/admin/videos"><i class="fas fa-video me-1"></i> Videos</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/testimonials"><i class="fas fa-quote-left me-1"></i> Testimonials</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/blogs"><i class="fas fa-blog me-1"></i> Blog</a></li>
      </ul>
      <a class="nav-link text-white-50 small" href="/" target="_blank" rel="noopener">View site</a>
      <a class="btn btn-outline-light btn-sm ms-2" href="/admin/logout">Log out</a>
    </div>
  </div>
</nav>
<?php endif; ?>
<div class="container pb-5">
