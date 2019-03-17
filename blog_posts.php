<?php
require_once "includes/config.php";

define("POSTS_PER_PAGE", 3);

// Check if request is AJAX or nor
function is_ajax_request()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

// Exit page if not through Ajax
if (!is_ajax_request()) {
    exit();
}

// Get all the blog posts
function find_blog_posts($page)
{
    $starting_record = ($page * POSTS_PER_PAGE);
    $blog_posts_set = get_posts(POSTS_PER_PAGE, $starting_record);
    return $blog_posts_set;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$posts = find_blog_posts($page); // Save all the posts in variable $posts ( Assoc array )

?>

<?php while($post = mysqli_fetch_assoc($posts)): ?>
    <article id="blog-post-<?= $post['id']; ?>" class="blog-post">
        <header>
            <h2><?= $post['title']; ?> - <?= $post['id']; ?></h2>
            <p>Posted on <?= $post['date_created']; ?></p>
        </header>
        <p><?= $post['content']; ?></p>
    </article>
<?php endwhile; ?>
