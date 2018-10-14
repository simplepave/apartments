<?php

/**
 * Template name: Отзывы
 */

$post = get_post();
$post_url = esc_url(home_url($post->post_name . '/'));

$comm_loop = 6;
$comm_offset = isset($_POST['offset'])? $_POST['offset']: 0;
$comm_count = get_comments(['post_id' => $post->ID, 'count' => true]);
$more_show = $comm_count > ($comm_offset + $comm_loop)? 1: 0;

$args = [
    'number'  => $comm_loop,
    'post_id' => $post->ID,
    'status'  => 'approve',
    'offset'  => $comm_offset,
];

$comments = get_comments($args);

ob_start();
foreach ($comments as $comment) {
?>
    <div class="col-md-4">
        <div class="rev_block">
            <div class="head_rev">
                <strong><?php echo $comment->comment_author; ?></strong>
                <span><?php echo mysql2date('d.m.Y', $comment->comment_date); ?></span>
            </div>
            <div class="text_rev">
                <p><?php echo $comment->comment_content; ?></p>
            </div>
        </div>
    </div>
<?php
}
$comments = ob_get_clean();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json['next'] = $more_show;
    $json['review'] = $comments;
    $json['success'] = true;
    echo json_encode($json);
    exit();
}

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="reviews">
            <div class="container">
                <div class="row_flex">
                    <div class="block_header"><?php echo $post->post_title; ?></div>
                    <a class="rev_button button_hover popup" href="#reviews_popup">Оставить отзывы</a>
                </div>
            </div>
            <div class="container">
                <div class="main_reviews">
                    <div id="reviews" class="row">
                    <?php echo $comments; ?>
                    </div>
<?php if ($more_show) : ?>
                    <a id="more-reviews" data-loop="<?php echo $comm_loop; ?>" class="rev_download button_hover work" href="<?php echo $post_url;?>">Загрузить еще</a>
<?php endif; ?>
                </div>
            </div>
            <?php get_template_part('template-parts/mail/form', 'feedback'); ?>
        </div>
        <div id="reviews_popup" class="reviews_popup">
            <div class="head_rev_popup">оставить отзыв</div>
            <form action="<?php echo esc_url(home_url('wp-comments-post.php')); ?>" method="post">
                <input name="author" class="input" type="text" placeholder="Имя" required="required">
                <textarea name="comment" class="textarea" placeholder="Отзыв" required="required"></textarea>
                <div class="align_submit">
                    <input name="submit" class="submit" type="submit" value="Отправить" />
                    <input type='hidden' name='comment_post_ID' value='<?php echo $post->ID; ?>' id='comment_post_ID' />
                    <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                </div>
            </form>
        </div>
<?php get_footer(); ?>