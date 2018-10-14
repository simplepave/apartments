<?php

/**
 * Template name: Информация
 */

$post = get_post();

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="information">
            <div class="container">
                <div class="block_header"><?php echo $post->post_title; ?></div>
                <?php echo $post->post_content; ?>
            </div>
            <?php get_template_part('template-parts/shop/shop', 'products'); ?>
            <?php get_template_part('template-parts/mail/form', 'feedback'); ?>
        </div>
<?php get_footer(); ?>