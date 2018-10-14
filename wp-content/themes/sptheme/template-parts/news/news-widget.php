<?php

/**
 * News widget
 */

$posts_per_page = 6;

$args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
];

$query = new WP_Query($args);
wp_reset_query();
?>
    <div class="other_news">
        <div class="row">
            <div class="block_header">другие новости</div>
            <div class="news_more_slider owl-carousel">
<?php while ($query->have_posts()) { $query->the_post(); ?>
                <div class="item_news_more">
                    <div class="head_news"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                    <?php the_excerpt(); ?>
                </div>
<?php } wp_reset_postdata(); ?>
            </div>
        </div>
    </div>