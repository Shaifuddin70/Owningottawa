<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/content_store.php';

/**
 * @param array<string,mixed> $post
 */
function blog_excerpt_plain(array $post, int $max = 160): string
{
    $excerpt = trim((string) ($post['excerpt'] ?? ''));
    if ($excerpt !== '') {
        $t = preg_replace('/\s+/', ' ', $excerpt);
        $len = function_exists('mb_strlen') ? mb_strlen($t, 'UTF-8') : strlen($t);
        $cut = function_exists('mb_substr') ? mb_substr($t, 0, $max, 'UTF-8') : substr($t, 0, $max);

        return $len > $max ? $cut . '…' : $cut;
    }
    $body = strip_tags((string) ($post['body'] ?? ''));
    $body = preg_replace('/\s+/', ' ', trim($body));
    $len = function_exists('mb_strlen') ? mb_strlen($body, 'UTF-8') : strlen($body);
    $cut = function_exists('mb_substr') ? mb_substr($body, 0, $max, 'UTF-8') : substr($body, 0, $max);

    return $len > $max ? $cut . '…' : $cut;
}

/**
 * @param array<string,mixed> $post
 */
function blog_format_date(array $post): string
{
    $at = $post['created_at'] ?? null;
    if ($at === null || $at === '') {
        return '';
    }
    $dt = date_create((string) $at);

    return $dt ? $dt->format('F j, Y') : '';
}

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$post = null;
$force_404 = false;
$blogs = [];

if ($slug !== '') {
    $post = content_get_blog_by_slug($slug);
    if ($post === null) {
        $force_404 = true;
        $page_title = 'Post not found — OwningOttawa';
        $page_description = 'This blog post could not be found. Browse our blog for Ottawa real estate insights.';
    } else {
        $page_title = (string) $post['title'] . ' — Blog | OwningOttawa';
        $page_description = blog_excerpt_plain($post, 300);
    }
} else {
    $blogs = content_get_active_blogs();
    $page_title = 'Blog — OwningOttawa | Ottawa Real Estate Insights';
    $page_description = 'News, tips, and updates from OwningOttawa on Ottawa real estate, mortgages, and buying or selling in Ottawa.';
}

include __DIR__ . '/components/header.php';
?>
<main class="main-content modern-redesign blog-page">
  <?php if ($post !== null) : ?>
    <?php
    $titleEsc = htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8');
    $dateLabel = blog_format_date($post);
    $thumb = trim((string) ($post['image_url'] ?? ''));
    ?>
    <section class="common-section blog-article-hero">
      <div class="container">
        <nav class="blog-breadcrumb" aria-label="Breadcrumb">
          <a href="/blog">Blog</a>
          <span class="blog-breadcrumb-sep" aria-hidden="true">/</span>
          <span class="blog-breadcrumb-current"><?php echo $titleEsc; ?></span>
        </nav>
        <div class="blog-article-header text-center">
          <?php if ($dateLabel !== '') : ?>
            <p class="blog-meta"><time datetime="<?php echo htmlspecialchars((string) $post['created_at'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($dateLabel, ENT_QUOTES, 'UTF-8'); ?></time></p>
          <?php endif; ?>
          <h1 class="section-title-modern blog-article-title"><?php echo $titleEsc; ?></h1>
        </div>
        <?php if ($thumb !== '') : ?>
          <div class="blog-article-featured-wrap">
            <img class="blog-article-featured" src="<?php echo htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo $titleEsc; ?>" loading="eager" />
          </div>
        <?php endif; ?>
        <article class="blog-article-body">
          <?php echo $post['body']; ?>
        </article>
        <p class="blog-back-wrap">
          <a href="/blog" class="blog-back-link"><i class="fas fa-arrow-left" aria-hidden="true"></i> All posts</a>
        </p>
      </div>
    </section>
  <?php elseif ($force_404) : ?>
    <section class="common-section blog-not-found">
      <div class="container text-center">
        <span class="section-tag"><i class="fas fa-blog"></i> Blog</span>
        <h1 class="section-title-modern">Post not found</h1>
        <p class="section-description">That post may have been removed or the link is incorrect.</p>
        <p class="blog-back-wrap">
          <a href="/blog" class="cta-button">View all posts</a>
        </p>
      </div>
    </section>
  <?php else : ?>
    <section class="common-section blog-list-hero">
      <div class="container">
        <div class="section-header text-center scroll-animate">
          <span class="section-tag"><i class="fas fa-blog"></i> Blog</span>
          <h1 class="section-title-modern"><strong>Ottawa real estate insights</strong></h1>
          <p class="section-description">
            Tips, market notes, and updates from the OwningOttawa team.
          </p>
        </div>
        <?php if (count($blogs) === 0) : ?>
          <p class="blog-empty text-center">No posts yet. Check back soon.</p>
        <?php else : ?>
          <div class="row g-4 blog-card-grid">
            <?php foreach ($blogs as $row) :
                $s = rawurlencode((string) $row['slug']);
                $tEsc = htmlspecialchars((string) $row['title'], ENT_QUOTES, 'UTF-8');
                $ex = blog_excerpt_plain($row, 180);
                $exEsc = htmlspecialchars($ex, ENT_QUOTES, 'UTF-8');
                $d = blog_format_date($row);
                $dEsc = htmlspecialchars($d, ENT_QUOTES, 'UTF-8');
                $img = trim((string) ($row['image_url'] ?? ''));
                ?>
              <div class="col-md-6 col-lg-4">
                <a href="/blog/<?php echo $s; ?>" class="blog-card">
                  <div class="blog-card-media">
                    <?php if ($img !== '') : ?>
                      <img src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="" loading="lazy" />
                    <?php else : ?>
                      <div class="blog-card-placeholder" aria-hidden="true"><i class="fas fa-newspaper"></i></div>
                    <?php endif; ?>
                  </div>
                  <div class="blog-card-body">
                    <?php if ($d !== '') : ?>
                      <p class="blog-card-meta"><time datetime="<?php echo htmlspecialchars((string) $row['created_at'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $dEsc; ?></time></p>
                    <?php endif; ?>
                    <h2 class="blog-card-title"><?php echo $tEsc; ?></h2>
                    <p class="blog-card-excerpt"><?php echo $exEsc; ?></p>
                    <span class="blog-card-cta">Read more <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/components/footer.php'; ?>
