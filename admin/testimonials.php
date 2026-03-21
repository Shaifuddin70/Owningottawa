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
                $st = $pdo->prepare('DELETE FROM testimonials WHERE id = ?');
                $st->execute([$id]);
                $flash = 'Testimonial removed.';
            }
        } elseif ($action === 'approve') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $maxSo = (int) $pdo->query(
                    "SELECT COALESCE(MAX(sort_order), 0) FROM testimonials WHERE approval_status = 'approved'"
                )->fetchColumn();
                $st = $pdo->prepare(
                    "UPDATE testimonials SET approval_status = 'approved', is_active = 1, sort_order = ? WHERE id = ? AND approval_status IN ('pending','rejected')"
                );
                $st->execute([$maxSo + 1, $id]);
                $flash = 'Review approved. It will show on the homepage (you can hide it anytime with “Visible”).';
            }
        } elseif ($action === 'reject') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $st = $pdo->prepare(
                    "UPDATE testimonials SET approval_status = 'rejected', is_active = 0 WHERE id = ? AND approval_status = 'pending'"
                );
                $st->execute([$id]);
                $flash = 'Review rejected (hidden from the site).';
            }
        } elseif ($action === 'save') {
            $id = (int) ($_POST['id'] ?? 0);
            $quote = trim((string) ($_POST['quote'] ?? ''));
            $authorName = trim((string) ($_POST['author_name'] ?? ''));
            $authorRole = trim((string) ($_POST['author_role'] ?? ''));
            $avatarUrl = trim((string) ($_POST['avatar_url'] ?? ''));
            $rating = (int) ($_POST['rating'] ?? 5);
            $rating = max(1, min(5, $rating));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if ($quote === '' || $authorName === '') {
                $flash = 'Quote and author name are required.';
                $flashType = 'danger';
            } else {
                if ($id > 0) {
                    $st = $pdo->prepare(
                        'UPDATE testimonials SET quote=?, author_name=?, author_role=?, avatar_url=?, rating=?, sort_order=?, is_active=? WHERE id=?'
                    );
                    $st->execute([$quote, $authorName, $authorRole, $avatarUrl, $rating, $sortOrder, $isActive, $id]);
                    $flash = 'Testimonial updated.';
                } else {
                    $st = $pdo->prepare(
                        "INSERT INTO testimonials (quote, author_name, author_role, avatar_url, rating, sort_order, is_active, approval_status) VALUES (?,?,?,?,?,?,?,'approved')"
                    );
                    $st->execute([$quote, $authorName, $authorRole, $avatarUrl, $rating, $sortOrder, $isActive]);
                    $flash = 'Testimonial added (published when visible is on).';
                }
            }
        }
    }
}

$edit = null;
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
if ($editId > 0) {
    $st = $pdo->prepare('SELECT * FROM testimonials WHERE id = ?');
    $st->execute([$editId]);
    $edit = $st->fetch(PDO::FETCH_ASSOC) ?: null;
}

$rows = $pdo->query(
    "SELECT * FROM testimonials ORDER BY CASE approval_status WHEN 'pending' THEN 0 WHEN 'approved' THEN 1 ELSE 2 END, sort_order ASC, id ASC"
)->fetchAll(PDO::FETCH_ASSOC);

$pendingCount = (int) $pdo->query("SELECT COUNT(*) FROM testimonials WHERE approval_status = 'pending'")->fetchColumn();

$adminPageTitle = 'Testimonials';
require __DIR__ . '/_head.php';
?>
<h1 class="h3 mb-2">Testimonials</h1>
<?php if ($pendingCount > 0): ?>
  <p class="text-warning mb-3"><i class="fas fa-inbox me-1"></i><strong><?php echo $pendingCount; ?></strong> review<?php echo $pendingCount === 1 ? '' : 's'; ?> waiting for approval.</p>
<?php endif; ?>
<?php if ($flash !== ''): ?>
  <div class="alert alert-<?php echo htmlspecialchars($flashType, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($flash, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card card-admin">
      <div class="card-body">
        <h2 class="h5 mb-3"><?php echo $edit ? 'Edit testimonial' : 'Add testimonial'; ?></h2>
        <p class="small text-muted">Reviews submitted from the website are <strong>pending</strong> until you approve them below.</p>
        <form method="post">
          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
          <input type="hidden" name="action" value="save" />
          <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?php echo (int) $edit['id']; ?>" />
          <?php endif; ?>
          <div class="mb-2">
            <label class="form-label">Quote <span class="text-danger">*</span></label>
            <textarea class="form-control" name="quote" rows="4" required><?php echo htmlspecialchars((string) ($edit['quote'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Author name <span class="text-danger">*</span></label>
            <input class="form-control" name="author_name" required value="<?php echo htmlspecialchars((string) ($edit['author_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="mb-2">
            <label class="form-label">Role / subtitle <span class="text-muted small">(optional)</span></label>
            <input class="form-control" name="author_role" value="<?php echo htmlspecialchars((string) ($edit['author_role'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="mb-2">
            <label class="form-label">Avatar image URL <span class="text-muted small">(optional)</span></label>
            <input class="form-control" name="avatar_url" placeholder="https://…"
              value="<?php echo htmlspecialchars((string) ($edit['avatar_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="mb-2">
            <label class="form-label">Star rating</label>
            <select class="form-select" name="rating">
              <?php for ($i = 5; $i >= 1; $i--): ?>
                <option value="<?php echo $i; ?>" <?php echo (int) ($edit['rating'] ?? 5) === $i ? 'selected' : ''; ?>><?php echo $i; ?> stars</option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Sort order</label>
            <input class="form-control" type="number" name="sort_order" value="<?php echo (int) ($edit['sort_order'] ?? 0); ?>" />
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="t_active"
              <?php echo (!$edit || !empty($edit['is_active'])) ? 'checked' : ''; ?> />
            <label class="form-check-label" for="t_active">Visible on homepage (only if approved)</label>
          </div>
          <button type="submit" class="btn btn-oo-primary"><?php echo $edit ? 'Update' : 'Add'; ?></button>
          <?php if ($edit): ?>
            <a href="/admin/testimonials" class="btn btn-outline-secondary ms-1">Cancel</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card card-admin">
      <div class="card-body">
        <h2 class="h5 mb-3">All reviews</h2>
        <?php if (!$rows): ?>
          <p class="text-muted mb-0">No testimonials yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead><tr><th>Author</th><th>Preview</th><th>★</th><th>Status</th><th>On</th><th></th></tr></thead>
              <tbody>
                <?php foreach ($rows as $r):
                    $status = (string) ($r['approval_status'] ?? 'approved');
                    ?>
                  <tr class="<?php echo $status === 'pending' ? 'table-warning' : ''; ?>">
                    <td><?php echo htmlspecialchars((string) $r['author_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="small"><?php
                        $q = (string) $r['quote'];
                    $qlen = function_exists('mb_strlen') ? mb_strlen($q) : strlen($q);
                    $prev = function_exists('mb_substr') ? mb_substr($q, 0, 60) : substr($q, 0, 60);
                    if ($qlen > 60) {
                        $prev .= '…';
                    }
                    echo htmlspecialchars($prev, ENT_QUOTES, 'UTF-8');
                    ?></td>
                    <td><?php echo (int) $r['rating']; ?></td>
                    <td><span class="badge bg-<?php echo $status === 'pending' ? 'warning text-dark' : ($status === 'approved' ? 'success' : 'secondary'); ?>"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span></td>
                    <td><?php echo !empty($r['is_active']) ? 'Yes' : 'No'; ?></td>
                    <td class="text-nowrap">
                      <?php if ($status === 'pending'): ?>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                          <input type="hidden" name="action" value="approve" />
                          <input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>" />
                          <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form method="post" class="d-inline" onsubmit="return confirm('Reject this review?');">
                          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                          <input type="hidden" name="action" value="reject" />
                          <input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>" />
                          <button type="submit" class="btn btn-sm btn-outline-secondary">Reject</button>
                        </form>
                      <?php elseif ($status === 'rejected'): ?>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                          <input type="hidden" name="action" value="approve" />
                          <input type="hidden" name="id" value="<?php echo (int) $r['id']; ?>" />
                          <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </form>
                      <?php endif; ?>
                      <a class="btn btn-sm btn-outline-primary" href="/admin/testimonials?edit=<?php echo (int) $r['id']; ?>">Edit</a>
                      <form method="post" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
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
