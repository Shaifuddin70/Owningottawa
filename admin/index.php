<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';
admin_require_login();

$pdo = content_pdo();
$stats = content_admin_dashboard_counts($pdo);
$grandTotal = $stats['videos']['total'] + $stats['testimonials']['total'] + $stats['blogs']['total'];
$pending = $stats['testimonials_pending'];

$adminPageTitle = 'Dashboard';
require __DIR__ . '/_head.php';
?>
<h1 class="h3 mb-2">Dashboard</h1>
<p class="text-muted mb-4">Manage homepage videos, testimonials, and blog posts.</p>

<div class="row g-3 mb-4">
  <div class="col-md-6 col-xl-3">
    <div class="card card-admin h-100 border-0">
      <div class="card-body py-3">
        <div class="small text-muted text-uppercase fw-bold mb-1">All content</div>
        <div class="fs-3 fw-bold" style="color: var(--oo-gold, #c99741);"><?php echo (int) $grandTotal; ?></div>
        <div class="small text-muted">Total items (videos + testimonials + posts)</div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card card-admin h-100 border-0">
      <div class="card-body py-3">
        <div class="small text-muted text-uppercase fw-bold mb-1">Published / visible</div>
        <div class="fs-3 fw-bold text-success"><?php echo (int) ($stats['videos']['active'] + $stats['testimonials']['active'] + $stats['blogs']['active']); ?></div>
        <div class="small text-muted">Active across all types</div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card card-admin h-100 border-0">
      <div class="card-body py-3">
        <div class="small text-muted text-uppercase fw-bold mb-1">Hidden</div>
        <div class="fs-3 fw-bold text-secondary"><?php echo (int) ($stats['videos']['inactive'] + $stats['testimonials']['inactive'] + $stats['blogs']['inactive']); ?></div>
        <div class="small text-muted">Inactive (not shown on site)</div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card card-admin h-100 border-0">
      <div class="card-body py-3">
        <div class="small text-muted text-uppercase fw-bold mb-1">Reviews pending</div>
        <div class="fs-3 fw-bold <?php echo $pending > 0 ? 'text-warning' : 'text-muted'; ?>"><?php echo (int) $pending; ?></div>
        <div class="small text-muted">Awaiting approval</div>
        <?php if ($pending > 0): ?>
          <a href="/admin/testimonials" class="small fw-bold">Review &rarr;</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if ($pending > 0): ?>
  <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-hourglass-half me-2"></i>
    <span><strong><?php echo (int) $pending; ?></strong> testimonial<?php echo $pending === 1 ? '' : 's'; ?> waiting for approval.</span>
    <a href="/admin/testimonials" class="btn btn-sm btn-outline-dark ms-auto">Open testimonials</a>
  </div>
<?php endif; ?>

<div class="card card-admin mb-4">
  <div class="card-body">
    <h2 class="h5 mb-3"><i class="fas fa-table me-2 text-secondary"></i>Content overview</h2>
    <div class="table-responsive">
      <table class="table table-sm table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Type</th>
            <th class="text-end">Total</th>
            <th class="text-end">Active</th>
            <th class="text-end">Inactive</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><i class="fas fa-video text-muted me-2"></i>Videos</td>
            <td class="text-end fw-semibold"><?php echo (int) $stats['videos']['total']; ?></td>
            <td class="text-end text-success"><?php echo (int) $stats['videos']['active']; ?></td>
            <td class="text-end text-secondary"><?php echo (int) $stats['videos']['inactive']; ?></td>
            <td class="text-end"><a href="/admin/videos" class="btn btn-sm btn-outline-primary">Manage</a></td>
          </tr>
          <tr>
            <td><i class="fas fa-quote-left text-muted me-2"></i>Testimonials</td>
            <td class="text-end fw-semibold"><?php echo (int) $stats['testimonials']['total']; ?></td>
            <td class="text-end text-success"><?php echo (int) $stats['testimonials']['active']; ?></td>
            <td class="text-end text-secondary"><?php echo (int) $stats['testimonials']['inactive']; ?></td>
            <td class="text-end"><a href="/admin/testimonials" class="btn btn-sm btn-outline-primary">Manage</a></td>
          </tr>
          <tr>
            <td><i class="fas fa-blog text-muted me-2"></i>Blog posts</td>
            <td class="text-end fw-semibold"><?php echo (int) $stats['blogs']['total']; ?></td>
            <td class="text-end text-success"><?php echo (int) $stats['blogs']['active']; ?></td>
            <td class="text-end text-secondary"><?php echo (int) $stats['blogs']['inactive']; ?></td>
            <td class="text-end"><a href="/admin/blogs" class="btn btn-sm btn-outline-primary">Manage</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="small text-muted mb-0 mt-2">
      <strong>Active</strong> = shown on the site (videos &amp; approved testimonials &amp; published posts). <strong>Inactive</strong> = hidden or off.
    </p>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-video text-warning me-2"></i> Videos</h2>
        <p class="text-muted small mb-2">YouTube or Vimeo URLs, thumbnails, sort order, show/hide.</p>
        <ul class="list-unstyled small mb-3">
          <li><span class="text-muted">Total</span> <strong><?php echo (int) $stats['videos']['total']; ?></strong>
            &middot; <span class="text-success">Active <?php echo (int) $stats['videos']['active']; ?></span>
            &middot; <span class="text-secondary">Inactive <?php echo (int) $stats['videos']['inactive']; ?></span></li>
        </ul>
        <a href="/admin/videos" class="btn btn-oo-primary">Manage videos</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-quote-left text-warning me-2"></i> Testimonials</h2>
        <p class="text-muted small mb-2">Quotes, names, ratings, optional photo URL.</p>
        <ul class="list-unstyled small mb-3">
          <li><span class="text-muted">Total</span> <strong><?php echo (int) $stats['testimonials']['total']; ?></strong>
            &middot; <span class="text-success">Active <?php echo (int) $stats['testimonials']['active']; ?></span>
            &middot; <span class="text-secondary">Inactive <?php echo (int) $stats['testimonials']['inactive']; ?></span></li>
          <?php if ($pending > 0): ?>
            <li class="mt-1"><span class="badge bg-warning text-dark">Pending approval: <?php echo (int) $pending; ?></span></li>
          <?php endif; ?>
        </ul>
        <a href="/admin/testimonials" class="btn btn-oo-primary">Manage testimonials</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-admin h-100">
      <div class="card-body">
        <h2 class="h5"><i class="fas fa-blog text-warning me-2"></i> Blog</h2>
        <p class="text-muted small mb-2">Articles, excerpts, images, slugs, publish on/off.</p>
        <ul class="list-unstyled small mb-3">
          <li><span class="text-muted">Total</span> <strong><?php echo (int) $stats['blogs']['total']; ?></strong>
            &middot; <span class="text-success">Published <?php echo (int) $stats['blogs']['active']; ?></span>
            &middot; <span class="text-secondary">Draft / off <?php echo (int) $stats['blogs']['inactive']; ?></span></li>
        </ul>
        <a href="/admin/blogs" class="btn btn-oo-primary">Manage blog</a>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/_foot.php'; ?>
