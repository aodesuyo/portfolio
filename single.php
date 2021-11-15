<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main class="l-main c-post">
<?php while (have_posts()):
        the_post(); ?>
        <h1 class="c-title"> 
            <?php the_title(); ?>
        </h1>
        <img src="<?php the_post_thumbnail_url("medium"); ?>">
        <?php the_content(); ?>
<?php endwhile;?>
</main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->
