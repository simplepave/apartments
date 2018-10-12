<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <title><?php is_home() ? bloginfo('description') : wp_title('|', true, 'right') . bloginfo('name');?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
    <body <?php body_class(); ?>>
        <div class="container">
            <div class="row">
                <div class="header">
                    <div class="logo_block">
                        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
                        <div class="header_text">Управляющая компания по недвижимости «Rentex»</div>
                    </div>
                    <div class="header_phone">
                        <p class="head_p">Телефон службы поддержки</p>
                        <a class="link_phone" href="tel:<?php echo href_tel(get_option('phone', '' )); ?>"><?php echo esc_html(get_option('phone', '')); ?></a>
                    </div>
                </div>
            </div>
        </div>
<?php
if (has_nav_menu('header-menu'))
    get_template_part('template-parts/navigation/navigation', 'top');
?>