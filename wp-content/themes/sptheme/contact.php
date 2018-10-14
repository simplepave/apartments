<?php

/**
 * Template name: Контакты
 */

get_header();
?>
        <div class="apartment_reservation_title"></div>
        <div class="contacts">
            <div class="container">
                <div class="block_header"><?php the_title(); ?></div>
                <div class="row_flex">
                    <div class="map">
                        <iframe src="<?php echo esc_html(get_option('google_maps', '')); ?>" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <div class="cont_text">
                        <p>Телефон службы поддержки</p>
                        <a class="link_phone" href="tel:<?php echo href_tel(get_option('phone', '' )); ?>"><?php echo esc_html(get_option('phone', '')); ?></a>
                        <div class="cont_address"><?php echo esc_html(get_option('address', '')); ?></div>
                        <a class="cont_mail" href="mailto:<?php echo esc_html(get_option('admin_email', '')); ?>"><?php echo esc_html(get_option('admin_email', '')); ?></a>
                    </div>
                </div>
            </div>
            <?php get_template_part('template-parts/mail/form', 'feedback'); ?>
        </div>
<?php get_footer(); ?>