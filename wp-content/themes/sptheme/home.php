<?php

/**
 * Home page
 */

$posts_per_page = 6;
$paged = isset($_POST['paged'])? $_POST['paged']: 1;

$args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
];

$query = new WP_Query($args);
wp_reset_query();

$max_num_pages = $query->max_num_pages;
$more_show = $max_num_pages > $paged? 1: 0;

ob_start();
while ($query->have_posts()) { $query->the_post(); ?>
    <li>
        <a href="<?php the_permalink(); ?>">
            <div class="head_news"><?php the_title(); ?></div>
            <?php the_excerpt(); ?>
        </a>
    </li>
<?php }
$contents = ob_get_clean();
wp_reset_postdata();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json['next'] = $more_show;
    $json['contents'] = $contents;
    $json['success'] = true;
    echo json_encode($json);
    exit();
}

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="news">
            <div class="container">
                <div class="row">
                    <div class="block_header"><?php echo single_post_title('', false); ?> </div>
                </div>
            </div>
            <div class="news_block">
                <ul class="contents-block">
                <?php echo $contents; ?>
                </ul>
<?php if ($more_show) : ?>
                <a id="more-contents" data-page="<?php echo ++$paged; ?>" class="rev_download button_hover" href="#">Загрузить еще</a>
<?php endif; ?>
            </div>
            <?php get_template_part('template-parts/mail/form', 'feedback'); ?>
        </div>
<?php get_footer(); ?>