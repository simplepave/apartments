<?php

/**
 *
 */

$sp = new SP_Woo();

$product = product_data();
$subcat = get_the_terms($product->ID, 'product_cat')[0];
set_query_var('cat_id', $subcat->term_id);

if (!$product || category_data(get_query_var('shop-category')) !== $subcat->term_id)
    page_404();

$shop_data = shop_data();

$product_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'full')[0];
$product_image_small = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), [170,169])[0];
$product_image_gallery = get_post_meta($product->ID, '_product_image_gallery')[0];

$post = get_post(62);
$post_url = esc_url(home_url($post->post_name . '/'));

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="apartment_card">
            <div class="container">
                <div class="bread-crumbs">
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo get_the_title(get_option('page_on_front')); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url($shop_data->post_name . '/')); ?>"><?php echo $shop_data->post_title; ?></a></li>
                        <li><a href="<?php echo esc_url(home_url($shop_data->post_name.'/'.$subcat->slug.'/')); ?>"><?php echo $subcat->name; ?></a></li>
                        <li class="active"><a href="<?php echo esc_url(home_url($shop_data->post_name.'/'.$subcat->slug.'/'.$product->post_name.'/')); ?>"><?php echo $product->post_title; ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="block_header"><?php echo $product->post_title; ?></div>
                <div class="row_flex">
                    <div class="apartment_slider">
                        <div id="slider" class="flexslider">
                            <ul class="slides gallery">
                                <li><a href="<?php echo $product_image_full; ?>"><img src="<?php echo $product_image_full; ?>" alt=""></a></li>
<?php
if ($product_image_gallery) {
    $product_image_array = explode(',', $product_image_gallery);

    foreach ($product_image_array as $img_id) {
        $img_full = wp_get_attachment_image_src($img_id, [170,169])[0];
?>
        <li><a href="<?php echo $img_full; ?>"><img src="<?php echo $img_full; ?>" alt=""></a></li>
<?php
}}
?>
                            </ul>
                        </div>
                        <div id="carousel" class="flexslider">
                            <ul class="slides">
                                <li><img src="<?php echo $product_image_small; ?>" alt=""></li>
<?php
if ($product_image_gallery) {
    $product_image_array = explode(',', $product_image_gallery);

    foreach ($product_image_array as $img_id) {
        $img_small = wp_get_attachment_image_src($img_id, 'full')[0];
?>
        <li><img src="<?php echo $img_small; ?>" alt=""></li>
<?php
}}
?>
                            </ul>
                        </div>
                    </div>
                    <div class="apartment_des">
                        <div class="apart_text">
                            <p><strong>Стоимость:</strong> <?php echo number_format(get_post_meta($product->ID, '_price', true), 0, ',', ' '); ?></p>
<?php
$attributes = wc_get_product($product->ID)->attributes;

if ($attributes) {
    foreach ($attributes as $attribute) {
        $attribute = $attribute->get_data();
?>

                            <p><strong><?php echo $attribute['name']; ?></strong> <?php echo $attribute['value']; ?></p>
<?php
}}
?>
                        </div>
                        <p><strong>Описание:</strong> <?php echo $product->post_content; ?></p>
<?php if ($sp->is_reservation($product->ID)) : ?>
                        <p><strong>Забронировано</strong></p>
<?php else :?>
                        <a class="apartment_button button_hover popup" href="#apartment_popup">Забронировать</a>
<?php endif; ?>
                    </div>
                </div>
            </div>
            <?php get_template_part('template-parts/shop/shop', 'products'); ?>
            <div class="container">
                <div class="apartment_text">
                    <?php echo get_the_content(); ?>
                </div>
            </div>
        </div>
        <div id="apartment_popup" class="apartment_popup">
            <div class="head_popup">забронировать квартиру</div>
            <form id="reservation-form" action="<?php echo $post_url; ?>" method="post">
                <div class="row_flex">
                    <div class="input_row">
                        <label>Дата заезда</label>
                        <input name="arrival" id="arrival-date" class="input" type="text" required="required">
                    </div>
                    <div class="input_row">
                        <label>Дата выезда </label>
                        <input name="departure" id="departure-date" class="input" type="text" required="required">
                    </div>
                </div>
                <div class="row_flex">
                    <div class="input_row">
                        <label>Имя</label>
                        <input name="author" class="input" type="text" required="required">
                    </div>
                    <div class="input_row">
                        <label>Телефон</label>
                        <input name="phone" id="phone-mask" class="input" type="text" required="required">
                    </div>
                </div>
                <textarea name="comment" placeholder="Комментарий"></textarea>
                <input type='hidden' name='apartment' value='<?php echo $product->ID; ?>' />
                <div class="align_submit"><input class="submit button_hover" type="submit" value="Отправить"></div>
            </form>
        </div>
<?php get_footer(); ?>