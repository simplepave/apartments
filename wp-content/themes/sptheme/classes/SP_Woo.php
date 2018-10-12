<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

if (!class_exists('SP_Woo')) :

class SP_Woo {

    /**
     *
     */

    public function __construct(){}

    /**
     *
     */

    public function create_order_woo($data = false){
        $data = [
            'name'       => isset($_POST['author'])? $_POST['author']: 'No name',
            'phone'      => $_POST['phone']?: '',
            'product_id' => is_numeric($_POST['apartment'])? $_POST['apartment']: 0,
            'arrival'    => isset($_POST['arrival'])? $_POST['arrival']: '',
            'departure'  => isset($_POST['departure'])? $_POST['departure']: '',
            'comment'    => isset($_POST['comment'])? $_POST['comment']: '',
        ];

        $address = [
            'first_name' => $data['name'],
            'last_name'  => '',
            'company'    => '',
            'email'      => '',
            'phone'      => $data['phone'],
            'address_1'  => '',
            'address_2'  => '',
            'city'       => '',
            'state'      => '',
            'postcode'   => '',
            'country'    => ''
        ];

        $order = wc_create_order();

        update_post_meta($order->id, 'arrival', sanitize_text_field($data['arrival']));
        update_post_meta($order->id, 'departure', sanitize_text_field($data['departure']));
        update_post_meta($order->id, 'comment', sanitize_text_field($data['comment']));

        $product = wc_get_product($data['product_id']);
        $order->add_product($product, 1);

        $order->set_address($address, 'billing');
        // $order->set_address($address, 'shipping');
        $order->update_status('completed', _x('Completed', 'Order status', 'woocommerce'));
        $order->calculate_totals();
        $order->save();

        if ($order->id)
            $response['success'] = 'Квартира забронирована!';
        else
            $response['error'] = '<strong>Ошибка</strong>, обратитесь к администратору.';

        return $response;
    }

    /**
     *
     */

    public function is_reservation($product_id){
        global $wpdb;
        $product_id = esc_sql((int)$product_id);

        $query = "SELECT COUNT(oi.order_id) as `count`
        FROM {$wpdb->prefix}woocommerce_order_items as oi,
            {$wpdb->prefix}woocommerce_order_itemmeta as oim,
            {$wpdb->prefix}posts as wp,
            {$wpdb->prefix}postmeta as wpm,
            {$wpdb->prefix}postmeta as wpd
        WHERE wp.post_status = 'wc-completed'
            AND wp.ID = oi.order_id
            AND wpm.post_id = oi.order_id
            AND wpd.post_id = oi.order_id
            AND wpm.meta_key = 'arrival'
            AND wpd.meta_key = 'departure'
            AND (STR_TO_DATE(wpm.meta_value,'%d.%m.%Y') < NOW() AND
                STR_TO_DATE(CONCAT(wpd.meta_value, '23:59'),'%d.%m.%Y %H:%i') >= NOW())
            AND oi.order_item_id = oim.order_item_id
            AND oi.order_item_type = 'line_item'
            AND oim.meta_key = '_product_id'
            AND oim.meta_value = $product_id";

        $result = $wpdb->get_row($query);
        $wpdb->flush();

        return $result? (int)$result->count: false;
    }
}

endif;