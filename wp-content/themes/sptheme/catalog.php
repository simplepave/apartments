<?php

/**
 * Template name: Каталог квартир
 */

get_header();

if (get_query_var('shop-product'))
    get_template_part('template-parts/shop/shop', 'card');
else
    get_template_part('template-parts/shop/shop', 'catalog');

get_footer();
?>