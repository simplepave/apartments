<?php

/**
 *
 */

$product_categories = get_categories([
        'menu_order' => 'ASC',
        'hide_empty' => 1, // 0
        'taxonomy'   => 'product_cat',
        'exclude'    => '15',
        'slug'       => get_query_var('shop-category')?: '',
    ]);

if (!$product_categories)
    page_404();

$shop_url = shop_data('post_name');

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="apartment_catalog">
<?php
foreach ($product_categories as $key => $category) {
    $subcat_url = $category->slug;
    set_query_var('cat_id', $category->term_id);
?>
            <div class="container">
                <?php if (!$key) : ?>
                <div class="block_header"><?php the_title(); ?></div>
                <?php endif; ?>
                <div class="apartment_header"><?php echo $category->name; ?></div>
            </div>
            <?php get_template_part('template-parts/shop/shop', 'products'); ?>
<?php } ?>
            <div class="container">
                <div class="apartment_text">
                    <?php echo get_the_content(); ?>
                </div>
            </div>
        </div>
<?php get_footer(); ?>