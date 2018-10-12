<?php

/**
 *
 */

$sp = new SP_Woo();

$post = get_post(62);
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
?>
        <div id="to_pass" class="apartment_popup">
            <div class="head_popup">Сдать квартиру</div>
            <form id="rent-form" action="" method="post">
                <div class="row_flex">
                    <div class="input_row">
                        <label>Дата от</label>
                        <input name="from-data" id="from-data" class="input" type="text">
                    </div>
                    <div class="input_row">
                        <label>Дата до</label>
                        <input name="to-data" id="to-data" class="input" type="text">
                    </div>
                </div>
                <div class="row_flex">
                    <div class="input_row">
                        <label>Имя</label>
                        <input name="author" class="input" type="text" required="required">
                    </div>
                    <div class="input_row">
                        <label>Телефон</label>
                        <input name="phone" id="rent-phone-mask" class="input" type="text" required="required">
                    </div>
                </div>
                <textarea name="comment" placeholder="Комментарий"></textarea>
                <input type='hidden' name='subject' value='Сдать квартиру' />
                <div class="align_submit"><input class="submit button_hover" type="submit" value="Отправить"></div>
            </form>
        </div>
        <div id="take_off" class="apartment_popup">
            <div class="head_popup">Снять квартиру</div>
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
                    <div class="input_row">
                        <label>Дата заезда</label>
                        <input name="arrival" id="arrival-date" class="input" type="text" required="required">
                    </div>
                    <div class="input_row">
                        <label>Дата выезда</label>
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
                <div class="align_submit"><input class="submit button_hover" type="submit" value="Отправить"></div>
            </form>
        </div>