<?php
  function custom_theme_support() {
      add_theme_support('html5',array(
          'search-form',
          'comment-form',
          'comment-list',
          'gallery',
          'caption',
      ));//html5
      add_theme_support('post-thumbnails');//アイキャッチ画像
      add_theme_support('title-tag');//タイトルを投稿ページに合わせて出力する
      add_theme_support('menus');//メニュー機能を有効にする

      register_nav_menus(array(
          'sidebar'=>'ナビメニュー',
          'footerMenu'=>'フッターメニュー'
      ));//メニュー位置を呼び出す

  }
  add_action( 'after_setup_theme','custom_theme_support');

  function my_theme_widgets_init() {
    register_sidebar( array(
      'name' => 'footer_widgets',
      'id' => 'footer_widgets',
      'before_widget' => '<nav class="p-footer__navi">',
      'after_widget' => '</nav>'
    ) );
  }
  add_action( 'widgets_init', 'my_theme_widgets_init' );

function mysite_script() {
  $theme_version = wp_get_theme()->get('Version');
  wp_enqueue_style( 'style', get_template_directory_uri().'/style.css', array(), '1.0.0');
  wp_enqueue_style('ress',get_template_directory_uri().'/css/ress.css',array(),$theme_version);//ress.css
  wp_enqueue_style('fonts',get_template_directory_uri().'/fonts/MOBO.otf',array(),"");//fonts
  wp_enqueue_style('mytheme',get_template_directory_uri().'/css/style.css',array(),$theme_version);//css
  wp_enqueue_style('fontawesome','//use.fontawesome.com/releases/v5.2.0/css/all.css',array(),"");//fontawesome
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',"","",true);//jQuery
  wp_enqueue_script('script',get_template_directory_uri().'/script.js','jquery',$theme_version,true);//jQuery
}
add_action('wp_enqueue_scripts','mysite_script');

//カスタム投稿の追加
get_template_part( 'add-portfolio-post' );

//カスタムタクソノミーの追加
get_template_part( 'add-portfoilo-taxonomy' );

// 固定カスタムフィールドボックス
get_template_part( 'add-portfolio-fild' );
