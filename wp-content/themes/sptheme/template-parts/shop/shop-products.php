<?php

/**
 *
 */

$sp = new SP_Woo();

$posts_per_page = 6;
$paged = isset($_POST['paged'])? $_POST['paged']: 1;
$category_id = isset($cat_id)? $cat_id: (isset($_POST['cat_id'])? $_POST['cat_id']: false);

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
];

if ($category_id)
    $args['tax_query'] = [[
        'taxonomy'  => 'product_cat',
        'field'     => 'id',
        'terms'     => $category_id,
    ]];

$query = new WP_Query($args);
wp_reset_query();

$max_num_pages = $query->max_num_pages;
$more_show = $max_num_pages > $paged? 1: 0;
$query = $query->posts;
$shop_data = shop_data();

ob_start();
foreach($query as $product){
    $subcat = get_the_terms($product->ID, 'product_cat')[0];
    $card_url = esc_url(home_url($shop_data->post_name . '/' . $subcat->slug . '/' . $product->post_name . '/'));
    $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'full')[0];
    $price = number_format(get_post_meta($product->ID, '_price', true), 0, ',', ' ');
?>
            <div class="take_off_block">
                <div class="img_take_off">
                    <a href="<?php echo $card_url; ?>"><img src="<?php echo $img_src; ?>" alt=""></a>
                    <div class="take_off_prise"><?php echo $price; ?></div>
<?php if ($sp->is_reservation($product->ID)) : ?>
                    <div class="surrendered">Сдано</div>
<?php else :?>
                    <div class="free">Свободно</div>
<?php endif; ?>
                </div>
                <div class="text_take_off">
                    <strong><?php echo $product->post_title; ?></strong>
<?php
    $attributes = wc_get_product($product->ID)->attributes;
    if ($attributes) {
?>
                    <ul>
<?php
        foreach ($attributes as $attribute) {
            $attribute = $attribute->get_data();
            $arr_attr = ['Площадь:', 'Количество комнат:', 'Телефон:'];
            if (in_array($attribute['name'], $arr_attr)) {
?>
                        <li>
                            <p><?php echo $attribute['name']; ?></p>
<?php if ($attribute['name'] == $arr_attr[2]) : ?>
                            <a href="tel:<?php echo href_tel($attribute['value']); ?>"><?php echo $attribute['value']; ?></a>
<?php else : ?>
                            <span><?php echo $attribute['value']; ?></span>
<?php endif; ?>
                        </li>
<?php }} ?>
                    </ul>
<?php } ?>
                </div>
            </div>
<?php }
$products = ob_get_clean();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json['next'] = $more_show;
    $json['products'] = $products;
    $json['success'] = true;
    echo json_encode($json);
    exit();
}

if (is_front_page())
    $home_header = '<div class="block_header">снять</div>';

if ($query) {
?>
    <div class="take_off">
        <div class="container">
            <?php echo isset($home_header)? $home_header: ''; ?>
            <div class="row justify-content-between products-block">
            <?php echo $products; ?>
            </div>
        </div>
<?php
if ($more_show) :
    $id_cat = $category_id? '-' . $category_id: '';
?>
                <a id="more-products<?php echo $id_cat; ?>" data-page="<?php echo ++$paged; ?>" class="take_off_button button_hover" href="#">Загрузить еще</a>
<?php endif; ?>
    </div>
<?php } ?>