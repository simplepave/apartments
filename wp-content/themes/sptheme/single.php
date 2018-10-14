<?php

/**
 *
 */

$page_for_posts = get_option('page_for_posts');

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="news_more">
            <div class="bread-crumbs">
                <div class="container">
                    <div class="row">
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo get_the_title(get_option('page_on_front')); ?></a></li>
                            <li><a href="<?php the_permalink($page_for_posts); ?>"><?php echo get_the_title($page_for_posts); ?></a></li>
                            <li class="active"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="block_header"><?php the_title(); ?></div>
                    <div class="news_more_text">
                        <?php echo get_post()->post_content; ?>
                    </div>
                </div>
                <?php get_template_part('template-parts/news/news', 'widget'); ?>
            </div>
            <?php get_template_part('template-parts/mail/form', 'feedback'); ?>
        </div>
<?php
get_footer();