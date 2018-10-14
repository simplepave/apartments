<?php

/**
 * Footer
 */

$product_categories = get_categories([
        'menu_order' => 'ASC',
        'hide_empty' => 1,
        'taxonomy'   => 'product_cat',
        'exclude'    => '15',
    ]);
?>
        <div class="footer">
            <div class="container">
                <div class="bg_footer">
                    <div class="footer_row">
                        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
<?php
if (has_nav_menu('footer-menu'))
    get_template_part( 'template-parts/navigation/navigation', 'footer' );
?>
                    </div>
                    <div class="footer_row">
                        <div class="quarters">
                            <div class="head_quarters">Квартиры</div>
<?php
if ($product_categories) {
    $shop_url = shop_data('post_name');

    foreach ($product_categories as $category) {
        $cat_url = esc_url(home_url($shop_url . '/' . $category->slug . '/'));
?>
    <a class="quarters_link" href="<?php echo $cat_url; ?>"><?php echo $category->name; ?></a>
<?php }} ?>
                        </div>
                        <div class="footer_phone">
                            <p class="head_p">Телефон службы поддержки</p>
                            <a class="link_phone" href="tel:<?php echo href_tel(get_option('phone', '' )); ?>"><?php echo esc_html(get_option('phone', '' )); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php wp_footer(); ?>
    </body>
</html>
