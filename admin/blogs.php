<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';
admin_require_login();

$pdo = content_pdo();
$flash = '';
$flashType = 'success';

if (!empty($_SESSION['admin_flash'])) {
    $flash = (string) $_SESSION['admin_flash'];
    $flashType = (string) ($_SESSION['admin_flash_type'] ?? 'success');
    unset($_SESSION['admin_flash'], $_SESSION['admin_flash_type']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!admin_verify_csrf($_POST['csrf'] ?? null)) {
        $flash = 'Invalid session token. Refresh and try again.';
        $flashType = 'danger';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        if ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $st = $pdo->prepare('SELECT image_url FROM blogs WHERE id = ?');
                $st->execute([$id]);
                $row = $st->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    content_blog_delete_uploaded_thumbnail((string) ($row['image_url'] ?? ''));
                }
                $st = $pdo->prepare('DELETE FROM blogs WHERE id = ?');
                $st->execute([$id]);
                $flash = 'Blog post removed.';
                $flashType = 'success';
            }
        }
    }
}

$rows = $pdo->query('SELECT * FROM blogs ORDER BY sort_order ASC, created_at DESC, id DESC')->fetchAll(PDO::FETCH_ASSOC);

$adminPageTitle = 'Blog posts';
require __DIR__ . '/_head.php';
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
  <h1 class="h3 mb-0">Blog posts</h1>
  <a href="/admin/blog_edit" class="btn btn-oo-primary"><i class="fas fa-plus me-1"></i> New post</a>
</div>
<?php if ($flash !== ''): ?>
  <div class="alert alert-<?php echo htmlspecialchars($flashType, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($flash, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-12">
    <div class="card card-admin">
      <div class="card-body">
        <h2 class="h5 mb-3">All posts</h2>
        <?php if (!$rows): ?>
          <p class="text-muted mb-3">No posts yet.</p>
          <a href="/admin/blog_edit" class="btn btn-oo-primary">Create your first post</a>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead><tr><th>Thumb</th><th>Title</th><th>Slug</th><th>Order</th><th>On</th><th></th></tr></thead>
              <tbody>
                <?php foreach ($rows as $r):
                    $iu = trim((string) ($r['image_url'] ?? ''));
                    ?>
                  <tr>
                    <td style="width:56px;">
                      <?php if ($iu !== ''): ?>
                        <img src="<?php echo htmlspecialchars($iu, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="rounded border" style="width:48px;height:48px;object-fit:cover;" loading="lazy" />
                      <?php else: ?>
                        <span class="text-muted small">—</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars((string) $r['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="small text-truncate" style="max-width:140px"><?php echo htmlspecialchars((string) $r['slug'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo (int) $r['sort_order']; ?></td>
                    <td><?php echo !empty($r['is_active']) ? 'Yes' : 'No'; ?></td>
                    <td class="text-nowrap">
                      <a class="btn btn-sm btn-outline-primary" href="/admin/blog_edit?id=<?php echo (int) $r['id']; ?>">Edit</a>
                      <form method="post" class="d-inline" onsubmit="return confirm('Delete this post?');">
                        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="delete" />
                        <input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>" />
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/_foot.php'; ?>
