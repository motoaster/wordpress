<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" 　href="<?php echo get_stylesheet_uri(); ?>">
    <!-- Wordpress 設定およびプラグイン等読み込み実施。「wp_footer」とセット -->
    <?php wp_head(); ?>
</head>

<body>
    <header>
        <?php
        // 管理画面で設定したメニューを表示
        // 
        if (has_nav_menu('main-menu')) :
            wp_nav_menu(
                array(
                    'theme_location'  => 'main-menu',
                    'menu_class'      => 'menu-wrapper',
                    'container_class' => 'primary-menu-container',
                    'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                    'fallback_cb'     => false,
                )
            );
        endif;
        ?>
    </header>