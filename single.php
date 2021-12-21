<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main <?php post_class( 'l-main' ); ?>>
<article class="p-single">
    <section class="l-single__content c-post">
        <?php while (have_posts()):
                the_post(); ?>
                <h2 class="c-title"> 
                    <?php the_title(); ?>
                </h2>
                <img src="<?php the_post_thumbnail_url("large"); ?>">
                <?php the_content(); ?>
                <?php wp_link_pages(); ?>
        <?php endwhile;?>
    </section>
    <section class="l-archive__sideber c-menu-single">
    <h1 class="c-title--small"><a href="<?php echo home_url(); ?>/single/"><?php bloginfo( 'name' ); ?></a></h1>
    <section class="c-menu-single__content">
                <h2 class="c-title--small">新着記事</h2>
                <?php wp_get_archives( 'type=monthly&limit=12' ); ?>
            </section>
            <section class="c-menu-single__content">
                <h2 class="c-title--small">カテゴリ</h2>
                <?php wp_list_categories( 'title_li=' ); ?>
            </section>
    </section>
</article>
<a class="c-button" href="<?php echo home_url(); ?>/single/">投稿記事一覧に戻る</a>
<?php comments_template(); ?>
</main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->
