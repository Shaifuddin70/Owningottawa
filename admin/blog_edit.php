<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';
admin_require_login();

$pdo = content_pdo();
$flash = '';
$flashType = 'danger';

$editId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$edit = null;
if ($editId > 0) {
    $st = $pdo->prepare('SELECT * FROM blogs WHERE id = ?');
    $st->execute([$editId]);
    $edit = $st->fetch(PDO::FETCH_ASSOC) ?: null;
    if ($edit === null) {
        $_SESSION['admin_flash'] = 'That blog post was not found.';
        $_SESSION['admin_flash_type'] = 'danger';
        header('Location: /admin/blogs', true, 302);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!admin_verify_csrf($_POST['csrf'] ?? null)) {
        $flash = 'Invalid session token. Refresh and try again.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        if ($action === 'save') {
            $id = (int) ($_POST['id'] ?? 0);
            $title = trim((string) ($_POST['title'] ?? ''));
            $slugInput = trim((string) ($_POST['slug'] ?? ''));
            $excerpt = trim((string) ($_POST['excerpt'] ?? ''));
            $body = (string) ($_POST['body'] ?? '');
            $imageUrl = trim((string) ($_POST['image_url'] ?? ''));
            $sortOrder = (int) ($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if ($title === '') {
                $flash = 'Title is required.';
            } else {
                $uploadResult = content_blog_handle_thumbnail_upload($_FILES['thumbnail'] ?? []);
                if (!$uploadResult['ok']) {
                    $flash = (string) $uploadResult['error'];
                } else {
                    if ($uploadResult['path'] !== null) {
                        $imageUrl = $uploadResult['path'];
                        if ($id > 0) {
                            $stPrev = $pdo->prepare('SELECT image_url FROM blogs WHERE id = ?');
                            $stPrev->execute([$id]);
                            $prev = $stPrev->fetch(PDO::FETCH_ASSOC);
                            if ($prev) {
                                content_blog_delete_uploaded_thumbnail((string) ($prev['image_url'] ?? ''));
                            }
                        }
                    }

                    $slug = $slugInput !== '' ? content_blog_slugify($slugInput) : content_blog_slugify($title);
                    $slug = content_blog_unique_slug($pdo, $slug, $id);

                    if ($id > 0) {
                        $st = $pdo->prepare(
                            'UPDATE blogs SET title=?, slug=?, excerpt=?, body=?, image_url=?, sort_order=?, is_active=?, updated_at=datetime(\'now\') WHERE id=?'
                        );
                        $st->execute([$title, $slug, $excerpt, $body, $imageUrl, $sortOrder, $isActive, $id]);
                        $_SESSION['admin_flash'] = 'Blog post updated.';
                    } else {
                        $st = $pdo->prepare(
                            'INSERT INTO blogs (title, slug, excerpt, body, image_url, sort_order, is_active) VALUES (?,?,?,?,?,?,?)'
                        );
                        $st->execute([$title, $slug, $excerpt, $body, $imageUrl, $sortOrder, $isActive]);
                        $_SESSION['admin_flash'] = 'Blog post added.';
                    }
                    $_SESSION['admin_flash_type'] = 'success';
                    header('Location: /admin/blogs', true, 302);
                    exit;
                }
            }
        }
    }
}

$adminPageTitle = $edit ? 'Edit blog post' : 'New blog post';
$e = $edit ?? [];
require __DIR__ . '/_head.php';
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
  <h1 class="h3 mb-0"><?php echo $edit ? 'Edit post' : 'New post'; ?></h1>
  <a href="/admin/blogs" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> All posts</a>
</div>
<?php if ($flash !== ''): ?>
  <div class="alert alert-<?php echo htmlspecialchars($flashType, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($flash, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<div class="card card-admin">
  <div class="card-body">
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="action" value="save" />
      <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?php echo (int) $edit['id']; ?>" />
      <?php endif; ?>
      <div class="mb-2">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input class="form-control" name="title" required value="<?php echo htmlspecialchars((string) ($e['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
      </div>
      <div class="mb-2">
        <label class="form-label">URL slug <span class="text-muted small">(optional)</span></label>
        <input class="form-control" name="slug" placeholder="auto from title if empty"
          value="<?php echo htmlspecialchars((string) ($e['slug'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
        <div class="form-text">Lowercase letters, numbers, hyphens. Used in public URLs: /blog/your-slug</div>
      </div>
      <div class="mb-2">
        <label class="form-label">Excerpt <span class="text-muted small">(optional)</span></label>
        <textarea class="form-control" name="excerpt" rows="2"><?php echo htmlspecialchars((string) ($e['excerpt'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
      </div>
      <div class="mb-2">
        <label class="form-label">Body</label>
        <textarea id="blog_body" class="form-control" name="body" rows="14"><?php echo htmlspecialchars((string) ($e['body'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
        <div class="form-text">Use the editor for headings, lists, links, and emphasis. Shown on the public blog as formatted HTML.</div>
      </div>
      <div class="mb-2">
        <label class="form-label" for="blog_thumbnail">Featured image upload <span class="text-muted small">(optional)</span></label>
        <input class="form-control" type="file" name="thumbnail" id="blog_thumbnail"
          accept="image/jpeg,image/png,image/webp,image/gif" />
        <div class="form-text">JPEG, PNG, WebP, or GIF — max 5MB. Replaces URL below when you choose a file.</div>
      </div>
      <?php
        $curImg = trim((string) ($e['image_url'] ?? ''));
      if ($curImg !== ''): ?>
      <div class="mb-3">
        <span class="form-label d-block small text-muted">Current image</span>
        <img src="<?php echo htmlspecialchars($curImg, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="img-fluid rounded border" style="max-height: 160px;" loading="lazy" />
      </div>
      <?php endif; ?>
      <div class="mb-2">
        <label class="form-label">Featured image URL <span class="text-muted small">(optional)</span></label>
        <input class="form-control" name="image_url" placeholder="https://… or leave blank if you uploaded above"
          value="<?php echo htmlspecialchars((string) ($e['image_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
        <div class="form-text">Use an external URL, or leave empty and upload a file instead.</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Sort order</label>
        <input class="form-control" type="number" name="sort_order" value="<?php echo (int) ($e['sort_order'] ?? 0); ?>" />
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="blog_active"
          <?php echo (!$edit || !empty($edit['is_active'])) ? 'checked' : ''; ?> />
        <label class="form-check-label" for="blog_active">Published (visible when blog is on the site)</label>
      </div>
      <button type="submit" class="btn btn-oo-primary"><?php echo $edit ? 'Update post' : 'Publish post'; ?></button>
      <a href="/admin/blogs" class="btn btn-outline-secondary ms-1">Cancel</a>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
(function () {
  if (typeof tinymce === 'undefined') return;
  tinymce.init({
    selector: '#blog_body',
    width: '100%',
    height: 560,
    menubar: false,
    license_key: 'gpl',
    promotion: false,
    branding: false,
    plugins: 'lists link code',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link bullist numlist | outdent indent | removeformat | code',
    block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3',
    content_style: 'body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #334155; }',
    relative_urls: false,
    convert_urls: true,
  });
})();
</script>
<?php require __DIR__ . '/_foot.php'; ?>
