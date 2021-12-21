<nav class="c-menu">
    <div class="c-menu__wrapper">
        <h2 class="c-title--noborder"><a href='<?php echo esc_url(home_url()); ?>'>青のポートフォリオ</a></h2>
        <?php  wp_nav_menu( array(
            'theme_location'=>'sidebar',
            'container' => 'false',
            'items_wrap' => '<ul class="c-menu__list">%3$s</ul>',
            'menu_class'=>'c-menu__wrapper'
            )
        );?>
    </div>
</nav>
