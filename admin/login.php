<?php
declare(strict_types=1);

require __DIR__ . '/_init.php';

if (!empty($_SESSION['admin_ok'])) {
    header('Location: /admin/', true, 302);
    exit;
}

$error = '';
$cfg = admin_config();
$missingConfig = !isset($cfg['admin_password_hash']) || !is_string($cfg['admin_password_hash']) || $cfg['admin_password_hash'] === '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$missingConfig && admin_verify_csrf($_POST['csrf'] ?? null)) {
        $pass = (string) ($_POST['password'] ?? '');
        if (admin_attempt_login($pass)) {
            session_regenerate_id(true);
            $_SESSION['admin_ok'] = true;
            header('Location: /admin/', true, 302);
            exit;
        }
        $error = 'Invalid password.';
    } elseif (!$missingConfig) {
        $error = 'Invalid session. Please try again.';
    }
}

$adminPageTitle = 'Log in';
require __DIR__ . '/_head.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card card-admin p-4">
      <h1 class="h4 mb-3">Admin login</h1>
      <?php if ($missingConfig): ?>
        <div class="alert alert-warning">
          <strong>Setup required.</strong> Copy <code>admin/config.sample.php</code> to <code>admin/config.local.php</code>,
          then generate a password hash from the project root:
          <pre class="small mb-0 mt-2 bg-light p-2 rounded">php admin/hash_password.php 'YourPassword'</pre>
          Paste the hash into <code>config.local.php</code> as <code>admin_password_hash</code>.
        </div>
      <?php else: ?>
        <?php if ($error !== ''): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="post" action="">
          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(admin_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required autocomplete="current-password" />
          </div>
          <button type="submit" class="btn btn-oo-primary w-100">Sign in</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php require __DIR__ . '/_foot.php'; ?>
