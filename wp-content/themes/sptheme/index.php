<?php

/**
 * Home page
 */

get_header();

get_template_part('template-parts/home/home', 'title');
get_template_part('template-parts/home/home', 'works_video');
get_template_part('template-parts/home/home', 'we_our_own');
get_template_part('template-parts/home/home', 'reviews');
get_template_part('template-parts/home/home', 'application');
get_template_part('template-parts/shop/shop', 'products');
get_template_part('template-parts/home/home', 'popup');

get_footer(); ?>