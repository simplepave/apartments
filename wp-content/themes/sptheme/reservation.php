<?php

/**
 * Template name: Бронирование квартир
 */

$sp = new SP_Woo();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apartment'], $_POST['phone'])) {
    $response = $sp->create_order_woo();
    $json['response'] = isset($response['success'])? 1: 0;
    $json['message'] = isset($response['success'])? $response['success']: $response['error'];
    echo json_encode($json);
    exit();
}

$post = get_post();
$post_url = esc_url(home_url($post->post_name . '/'));

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => -1,
];

$query = new WP_Query($args);
wp_reset_query();
$query = $query->posts;

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="container">
            <div class="apartment_reservation">
                <div class="block_header"><?php the_title(); ?> квартир</div>
                <div class="apartment_reservation_form">
                    <div class="head_apartment">забронировать квартиру</div>
                    <form id="reservation-form" action="<?php echo $post_url; ?>" method="post">
                        <label>Квартира</label>
                        <select name="apartment" required="required">
<?php
foreach ($query as $product) {
    if ($sp->is_reservation($product->ID)) continue;
?>
    <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
<?php
}
?>
                        </select>
                        <div class="row_flex">
                            <div class="col_input">
                                <label>Дата заезда</label>
                                <input name="arrival" id="arrival-date" class="input" type="text" required="required">
                            </div>
                            <div class="col_input">
                                <label>Дата выезда</label>
                                <input name="departure" id="departure-date" class="input" type="text" required="required">
                            </div>
                        </div>
                        <div class="row_flex">
                            <div class="col_input">
                                <label>Имя</label>
                                <input name="author" class="input" type="text" required="required">
                            </div>
                            <div class="col_input">
                                <label>Телефон</label>
                                <input name="phone" id="phone-mask" class="input" type="text" required="required">
                            </div>
                        </div>
                        <textarea name="comment" placeholder="Комментарий"></textarea>
                        <div class="align_submit"><input class="submit button_hover" type="submit" value="Отправить"></div>
                    </form>
                </div>
            </div>
        </div>
        <?php get_template_part('template-parts/shop/shop', 'products'); ?>
<?php get_footer(); ?>