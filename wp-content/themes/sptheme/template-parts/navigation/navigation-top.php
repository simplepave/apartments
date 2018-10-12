        <div class="container">
            <div class="row">
                <div class="menu">
                    <div class="icon-menu">
                        <div class="sw-topper"></div>
                        <div class="sw-bottom"></div>
                        <div class="sw-footer"></div>
                    </div>
<?php
    wp_nav_menu([
        'theme_location'  => 'header-menu',
        'container_class' => 'nav_block',
        'fallback_cb'     => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 1,
    ]);
?>
                </div>
            </div>
        </div>