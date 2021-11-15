<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset=<?php bloginfo( 'charset' )?>>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
</head>
<body>
<?php wp_body_open(); ?>
<header class="l-header">
        <div class="c-header">
            <button class="c-header__button">
                <span>menuボタン</span>
                MENU
            </button>
            <?php get_sidebar(); ?><!--sidebar.phpを読み込むテンプレートタグ（インクルードタグ）-->
        </div>
    </header> 
