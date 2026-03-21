<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';
admin_require_login();

content_pdo();

$adminPageTitle = 'Dashboard';
require __DIR__ . '/_head.php';
?>
<h1 class="h3 mb-4">Dashboard</h1>
<p class="text-muted mb-4">Manage homepage videos, testimonials, and blog posts.</p>
<div class="row g-4">
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-video text-warning me-2"></i> Videos</h2>
        <p class="text-muted">YouTube or Vimeo URLs, thumbnails, sort order, show/hide.</p>
        <a href="/admin/videos" class="btn btn-oo-primary">Manage videos</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-quote-left text-warning me-2"></i> Testimonials</h2>
        <p class="text-muted">Quotes, names, ratings, optional photo URL.</p>
        <a href="/admin/testimonials" class="btn btn-oo-primary">Manage testimonials</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-blog text-warning me-2"></i> Blog</h2>
        <p class="text-muted">Articles, excerpts, images, slugs, publish on/off.</p>
        <a href="/admin/blogs" class="btn btn-oo-primary">Manage blog</a>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/_foot.php'; ?>
