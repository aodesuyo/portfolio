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
            <a href="<?php echo esc_url(home_url ('/'));?>">
            <img src="<?php 
            if ( has_post_thumbnail() ) { // 投稿にアイキャッチ画像が割り当てられているかチェックします。
	        the_post_thumbnail();
            } 
            ?>>
            </a>
            <button class="c-header__button">
                <span>menuボタン</span>
                MENU
            </button>
            <?php get_sidebar(); ?><!--sidebar.phpを読み込むテンプレートタグ（インクルードタグ）-->
            <div class="c-menu__layer"></div> 
        </div>
        <div class="c-header__title">
                <h1 class="c-header__title-text p-title__index"> 
                    <span><?php bloginfo( 'description' );?></span>
                    <?php bloginfo( 'name' );?>

                </h1>
            </div>
            <div class="c-header__layer">
            </div>        
    </header> 