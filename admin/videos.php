<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';
admin_require_login();

$pdo = content_pdo();
$flash = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!admin_verify_csrf($_POST['csrf'] ?? null)) {
        $flash = 'Invalid session token. Refresh and try again.';
        $flashType = 'danger';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        if ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $st = $pdo->prepare('DELETE FROM videos WHERE id = ?');
                $st->execute([$id]);
                $flash = 'Video removed.';
            }
        } elseif ($action === 'save') {
            $id = (int) ($_POST['id'] ?? 0);
            $title = trim((string) ($_POST['title'] ?? ''));
            $description = trim((string) ($_POST['description'] ?? ''));
            $videoUrl = trim((string) ($_POST['video_url'] ?? ''));
            $thumbnailUrl = trim((string) ($_POST['thumbnail_url'] ?? ''));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if ($videoUrl === '') {
                $flash = 'Video URL is required.';
                $flashType = 'danger';
            } else {
                if ($id > 0) {
                    $st = $pdo->prepare(
                        'UPDATE videos SET title=?, description=?, video_url=?, thumbnail_url=?, sort_order=?, is_active=? WHERE id=?'
                    );
                    $st->execute([$title, $description, $videoUrl, $thumbnailUrl, $sortOrder, $isActive, $id]);
                    $flash = 'Video updated.';
                } else {
                    $st = $pdo->prepare(
                        'INSERT INTO videos (title, description, video_url, thumbnail_url, sort_order, is_active) VALUES (?,?,?,?,?,?)'
                    );
                    $st->execute([$title, $description, $videoUrl, $thumbnailUrl, $sortOrder, $isActive]);
                    $flash = 'Video added.';
                }
            }
        }
    }
}

$edit = null;
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
if ($editId > 0) {
    $st = $pdo->prepare('SELECT * FROM videos WHERE id = ?');
    $st->execute([$editId]);
    $edit = $st->fetch(PDO::FETCH_ASSOC) ?: null;
}

$rows = $pdo->query('SELECT * FROM videos ORDER BY sort_order ASC, id ASC')->fetchAll(PDO::FETCH_ASSOC);

$adminPageTitle = 'Videos';
require __DIR__ . '/_head.php';
?>
<h1 class="h3 mb-4">Videos</h1>
<?php if ($flash !== ''): ?>
  <div class="alert alert-<?php echo htmlspecialchars($flashType, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($flash, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card card-admin">
      <div class="card-body">
        <h2 class="h5 mb-3"><?php echo $edit ? 'Edit video' : 'Add video'; ?></h2>
        <form method="post">
          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
          <input type="hidden" name="action" value="save" />
          <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?php echo (int) $edit['id']; ?>" />
          <?php endif; ?>
          <div class="mb-2">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?php echo htmlspecialchars((string) ($edit['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="mb-2">
            <label class="form-label">Description <span class="text-muted small">(optional)</span></label>
            <textarea class="form-control" name="description" rows="2"><?php echo htmlspecialchars((string) ($edit['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Video URL <span class="text-danger">*</span></label>
            <input class="form-control" name="video_url" required placeholder="https://www.youtube.com/watch?v=… or Vimeo link"
              value="<?php echo htmlspecialchars((string) ($edit['video_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
            <div class="form-text">YouTube (watch, embed, shorts) or Vimeo.</div>
          </div>
          <div class="mb-2">
            <label class="form-label">Thumbnail URL <span class="text-muted small">(optional)</span></label>
            <input class="form-control" name="thumbnail_url" placeholder="Override auto YouTube thumbnail"
              value="<?php echo htmlspecialchars((string) ($edit['thumbnail_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="mb-3">
            <label class="form-label">Sort order</label>
            <input class="form-control" type="number" name="sort_order" value="<?php echo (int) ($edit['sort_order'] ?? 0); ?>" />
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="v_active"
              <?php echo (!$edit || !empty($edit['is_active'])) ? 'checked' : ''; ?> />
            <label class="form-check-label" for="v_active">Visible on homepage</label>
          </div>
          <button type="submit" class="btn btn-oo-primary"><?php echo $edit ? 'Update' : 'Add'; ?></button>
          <?php if ($edit): ?>
            <a href="/admin/videos" class="btn btn-outline-secondary ms-1">Cancel</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card card-admin">
      <div class="card-body">
        <h2 class="h5 mb-3">All videos</h2>
        <?php if (!$rows): ?>
          <p class="text-muted mb-0">No videos yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead><tr><th>Title</th><th>URL</th><th>Order</th><th>On</th><th></th></tr></thead>
              <tbody>
                <?php foreach ($rows as $r): ?>
                  <tr>
                    <td><?php echo htmlspecialchars((string) $r['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="small text-truncate" style="max-width:180px"><?php echo htmlspecialchars((string) $r['video_url'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo (int) $r['sort_order']; ?></td>
                    <td><?php echo !empty($r['is_active']) ? 'Yes' : 'No'; ?></td>
                    <td class="text-nowrap">
                      <a class="btn btn-sm btn-outline-primary" href="/admin/videos?edit=<?php echo (int) $r['id']; ?>">Edit</a>
                      <form method="post" class="d-inline" onsubmit="return confirm('Delete this video?');">
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
