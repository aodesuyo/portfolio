<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main <?php post_class( 'l-main c-post' ); ?>>
<?php while (have_posts()):
        the_post(); ?>
        <h1 class="c-title"> 
            <?php the_title(); ?>
        </h1>
        <img src="<?php the_post_thumbnail_url("medium"); ?>">
        <?php the_content(); ?>
        <?php wp_link_pages(); ?>
<?php endwhile;?>
<a class="c-button" href="/single">投稿一覧に戻る</a>
<?php comments_template(); ?>
</main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->
