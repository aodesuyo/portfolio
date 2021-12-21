<?php

//ブロックエディタのパスとURL定数化
define( 'MY_DIR_URL', get_stylesheet_directory_uri() );
define( 'MY_DIR_PATH', get_stylesheet_directory() );

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
      add_theme_support( 'automatic-feed-links' );
      add_theme_support( 'wp-block-styles' );
      add_theme_support( 'custom-header' );
      add_theme_support( 'responsive-embeds' );
      add_theme_support( 'align-wide' );
      add_theme_support( 'custom-logo' );
      add_theme_support( 'custom-background') ;
      register_nav_menus(array(
          'sidebar'=>'ナビメニュー',
          'footerMenu'=>'フッターメニュー',
          'archive_postMenu'=>'投稿記事一覧サイドバーメニュー',
          'postMenu'=>'投稿記事サイドバーメニュー'
      ));//メニュー位置を呼び出す
            //色パレット管理
            add_theme_support( 'editor-color-palette', [
              [
                  'name'  => '青',
                  'slug'  => 'blue',
                  'color' => '#2B3DB1',
              ],
              [
                'name'  => '薄青',
                'slug'  => 'lightblue',
                'color' => '#3C56FD',
              ],
              [
                'name'  => '水色',
                'slug'  => 'skyblue',
                'color' => '#546BFF',
              ],
              [
                'name'  => '白',
                'slug'  => 'white',
                'color' => '#FCFCFC',
              ],
              [
                'name'  => '灰色',
                'slug'  => 'gray',
                'color' => '#E0E0E0',
              ],
              [
                'name'  => '濃黄色',
                'slug'  => 'darkyellow',
                'color' => '#CDCD79',
              ],
              [
                'name'  => '黄色',
                'slug'  => 'yellow',
                'color' => '#FFFF7C',
              ],
              [
                  'name'  => '黒',
                  'slug'  => 'black',
                  'color' => '#000',
              ],
          ] );
  }
  add_action( 'after_setup_theme','custom_theme_support');

  add_action( 'enqueue_block_editor_assets', function() {
    // ブロックエディタ用CSSの読み込み
    wp_enqueue_style( 'my-block-style', MY_DIR_URL . '/block/block-style.css', array(), "" );

    // ブロックエディタ用JSの読み込み
    wp_enqueue_script( 'my-block-script', MY_DIR_URL . '/block/block-script.js', array(), "", "true" );
} );
  function admin_css(){
    echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/admin.css">';
    }
    add_action('admin_head', 'admin_css');

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
  wp_enqueue_style( 'google_fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300&display=swap', false );
  wp_enqueue_style('mytheme',get_template_directory_uri().'/css/style.css',array(),$theme_version);//css
  wp_enqueue_style('fontawesome','//use.fontawesome.com/releases/v5.2.0/css/all.css',array(),"");//fontawesome
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',"","",true);//jQuery
  wp_enqueue_script('script',get_template_directory_uri().'/script.js','jquery',$theme_version,true);//jQuery
  $timestamp = date_i18n( 'Ymdgis', filemtime( MY_DIR_PATH . '/block/block-style.css' ) );
  wp_enqueue_style( 'my-block-style', MY_DIR_URL . '/block/block-style.css', array(), $timestamp );
}
add_action('wp_enqueue_scripts','mysite_script');

//カスタム投稿の追加
get_template_part( 'add-portfolio-post' );

//カスタムタクソノミーの追加
get_template_part( 'add-portfoilo-taxonomy' );

// 固定カスタムフィールドボックス
get_template_part( 'add-portfolio-fild' );

// getの値を追加
function add_query_vars_filter( $vars ){
  $vars[] = "portfolio_tag";
  $vars[] = "qux";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

// アーカイブページにクエリを追加
add_action( 'pre_get_posts', 'add_archive_custom_query' ); // pre_get_posts(投稿記事一覧を取得する直前に動くフック)
// フック時に使う関数
function add_archive_custom_query( $query ) {
  if ( ! is_admin() && $query->is_main_query() && is_post_type_archive('portfolio_tag') ) {

    // nonce検証
    $nonce = $_REQUEST['nonce'];
    if(!wp_verify_nonce($nonce, 'my-archive-nonce')) {
      die();
    }

    // GETの引数を取得
    $get_qux = get_query_var('portfolio_tag');    
    // meta_query を追加

    // チェックボックス
    if(!empty($get_qux)) {
      array_push($meta_query, array(
      'relation' => 'AND',
      'post_type' => 'portfolio',
      'tax_query' => array(
        array(
          'taxonomy' => 'portfolio_tag',
          'field'    => 'slug',
          'terms'    => $my_qux,
        ),
      ),
      'compare' => 'LIKE' // チェックボックスの場合はLIKE検索になるので注意
      ));
    }

    $query->set('meta_query', $meta_query);
  }
}

class My_Walker_Comment extends Walker_Comment {
	function html5_comment( $comment, $depth, $args ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

    $commenter = wp_get_current_commenter();
      if ( $commenter['comment_author_email'] ) {
        $moderation_note = 'Your comment is awaiting moderation.';
        } else {
        $moderation_note = 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.';
		}
    ?>
		<!-- コメント-->
    <<?php echo $tag; ?> class="c-comment__item">
		<article class="c-comment__body">
				<div class="c-comment__info">
					<!-- コメント投稿者名 -->
						<div class="c-comment__author">
								<?php
                        if( get_comment_author( $comment) == get_the_author() ){
                          echo '記事執筆者 ' . get_comment_author( $comment );
                        }else{
                          echo 'コメント投稿者 ' . get_comment_author( $comment );
                        }
                       ?>
						</div>
            <time><?php echo get_comment_date( '', $comment ); ?></time>
						<?php edit_comment_link( 'コメントを編集  ', '<span class="edit-link">', '</span>' ); ?>
        </div>
				<?php if ( '0' == $comment->comment_approved ) : ?> <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
				<?php endif; ?>
				<!-- コメント本文 -->
				<div class="c-comment__content">
						<?php 
                    $comment_text = esc_html(get_comment_text());
					echo  '<p class="c-text">' . $comment_text . '</p>';
                    ?> </div>
		</article>
		<?php
    }
}
//投稿記事一覧のURLをsingleで表示する
function archive( $args, $post_type ) {

	if ( 'post' == $post_type ) {
		$args['rewrite'] = true;
		$args['has_archive'] = 'single'; //任意のスラッグ名
	}
	return $args;

}
add_filter( 'register_post_type_args', 'archive', 10, 2 );

//投稿ページに目次
get_template_part( 'add-index' );

//ブロックスタイルの追加
add_action( 'init', function() {
  register_block_style(
      'core/paragraph',//対象ブロックのスラッグ名(エディター画面>ブロック部分のDOM>data-type属性)
      [
          'name' => 'black-bg',//スタイル名（付与するクラス名）
          'label' => '黒背景',//スタイルの表示名
          // 'inline_style' => '.is-style-black-bg { 
          //     background: #000;
          //     color: #fff;
          // }',block-style.cssに記述する。クラス名はis-style- + スタイル名 となる
      ]
  );
} );
