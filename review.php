<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$page_title = 'Post a Review — OwningOttawa';
$page_description = 'Share your experience with OwningOttawa. Your review will appear on our site after approval.';
require_once __DIR__ . '/includes/content_store.php';

if (empty($_SESSION['review_csrf'])) {
    $_SESSION['review_csrf'] = bin2hex(random_bytes(32));
}
$reviewCsrf = $_SESSION['review_csrf'];

$formMessage = '';
$formError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf'] ?? '');
    if (!hash_equals($reviewCsrf, $token)) {
        $formError = 'Your session expired. Please refresh the page and try again.';
    } elseif (trim((string) ($_POST['website'] ?? '')) !== '') {
        $formMessage = 'Thank you! Your review was submitted.';
    } else {
        $quote = trim((string) ($_POST['quote'] ?? ''));
        $authorName = trim((string) ($_POST['author_name'] ?? ''));
        $authorRole = trim((string) ($_POST['author_role'] ?? ''));
        $rating = (int) ($_POST['rating'] ?? 5);
        $rating = max(1, min(5, $rating));

        $qLen = function_exists('mb_strlen') ? mb_strlen($quote) : strlen($quote);
        $nLen = function_exists('mb_strlen') ? mb_strlen($authorName) : strlen($authorName);
        $rLen = function_exists('mb_strlen') ? mb_strlen($authorRole) : strlen($authorRole);
        if ($qLen < 10) {
            $formError = 'Please write at least a few sentences for your review.';
        } elseif ($qLen > 2000) {
            $formError = 'Your review is too long (maximum 2,000 characters).';
        } elseif ($authorName === '' || $nLen > 120) {
            $formError = 'Please enter your name.';
        } elseif ($rLen > 120) {
            $formError = 'Role or subtitle is too long.';
        } else {
            $pdo = content_pdo();
            $st = $pdo->prepare(
                "INSERT INTO testimonials (quote, author_name, author_role, rating, avatar_url, sort_order, is_active, approval_status) VALUES (?,?,?,?,?,?,0,'pending')"
            );
            $st->execute([$quote, $authorName, $authorRole, $rating, '', 1000]);
            $_SESSION['review_csrf'] = bin2hex(random_bytes(32));
            $_SESSION['review_thanks'] = true;
            header('Location: /', true, 303);
            exit;
        }
    }
}

include 'components/header.php'; ?>
<main class="main-content modern-redesign">
  <section class="common-section section-bg">
    <div class="container" style="max-width: 640px;">
      <div class="section-header text-center mb-4">
        <span class="section-tag"><i class="fas fa-pen"></i> Client review</span>
        <h1 class="section-title-modern">Post a review</h1>
        <p class="section-subtitle-modern">Tell others about your experience. We publish approved reviews on our homepage.</p>
      </div>

      <?php if ($formMessage !== ''): ?>
        <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($formMessage, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>
      <?php if ($formError !== ''): ?>
        <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($formError, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>

      <form method="post" action="" class="scroll-animate" novalidate>
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($reviewCsrf, ENT_QUOTES, 'UTF-8'); ?>" />
        <p class="visually-hidden" aria-hidden="true">
          <label>Leave blank <input type="text" name="website" value="" tabindex="-1" autocomplete="off" /></label>
        </p>

        <div class="mb-3">
          <label class="form-label" for="review_quote">Your review <span class="text-danger">*</span></label>
          <textarea class="form-control" id="review_quote" name="quote" rows="5" required maxlength="2000" placeholder="What went well? How did we help?"><?php echo htmlspecialchars((string) ($_POST['quote'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label" for="review_name">Your name <span class="text-danger">*</span></label>
          <input class="form-control" type="text" id="review_name" name="author_name" required maxlength="120" value="<?php echo htmlspecialchars((string) ($_POST['author_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="review_role">Role or context <span class="text-muted">(optional)</span></label>
          <input class="form-control" type="text" id="review_role" name="author_role" maxlength="120" placeholder="e.g. First-time buyer" value="<?php echo htmlspecialchars((string) ($_POST['author_role'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" />
        </div>
        <div class="mb-4">
          <label class="form-label" for="review_rating">Rating</label>
          <select class="form-select" id="review_rating" name="rating">
            <?php for ($r = 5; $r >= 1; $r--): ?>
              <option value="<?php echo $r; ?>" <?php echo (int) ($_POST['rating'] ?? 5) === $r ? 'selected' : ''; ?>><?php echo $r; ?> stars</option>
            <?php endfor; ?>
          </select>
        </div>
        <button type="submit" class="btn-modern-primary w-100 mb-3 justify-content-center">
          <span>Submit review</span>
          <i class="fas fa-paper-plane ms-2"></i>
        </button>
        <p class="text-center mb-0"><a href="/" class="text-muted">← Back to home</a></p>
      </form>
    </div>
  </section>
</main>
<?php include 'components/footer.php'; ?>
