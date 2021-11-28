<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main <?php post_class( 'l-main' ); ?>>
<article class="p-single">
    <section class="p-single__content  c-post">
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
    <section class="p-archive__option">
        <h1 class="c-title--small"><a href="<?php echo home_url(); ?>/single/"><?php bloginfo( 'name' ); ?></a></h1>
        <section class="p-archive__monthly">
            <h2 class="c-title--small">アーカイブ</h2>
            <ul>
                <?php wp_get_archives( 'type=monthly&limit=12' ); ?>
            </ul>
        </section>
        <section class="p-archive__category">
            <h2 class="c-title--small">カテゴリー</h2>
            <ul>
                <?php wp_list_categories( 'title_li=' ); ?>
            </ul>
        </section>
    </section>
</article>
<a class="c-button" href="<?php echo home_url(); ?>/single/">投稿記事一覧に戻る</a>
<?php comments_template(); ?>
</main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->
