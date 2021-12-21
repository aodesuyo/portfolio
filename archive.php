<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main class="l-main">
    <h2 class="c-title">投稿記事一覧</h2>
    <article class="p-archive">
        <ul class="l-archive__content">
            <?php
                if(have_posts()):
                    while(have_posts()):
                        the_post();?>
                        <li class="c-archive">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img class="c-archive__thumbnail" src=<?php echo esc_url(get_the_post_thumbnail_url()); ?>>
                        <?php else : ?>
                            <img class="c-archive__thumbnail" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/p0337_l.jpg">
                        <?php endif; ?>
                        <div class="c-archive__wrapper">
                            <?php the_title
                                ( '<h3 class="c-title--small"><a href="'.esc_url( get_permalink()).'">','</a></h3>');
                            ?>
                            <p class="c-text--bold"><?php echo get_the_excerpt(); ?></p>
                        </div>
                    </li>
            <?php endwhile;
                else:
                    echo '<p class="c-text">記事はありません</p>';
                endif;
            ?><!--カテゴリに記事があればループ開始、なければ記事はありませんと返す-->
        </ul>
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
                <?php get_search_form(); ?>

        </section>
    </article>
    <div class="c-paginate">
    <?php echo paginate_links( array(
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'type' => 'list',
            'prev_next'          => true,
            'prev_text'          => __( '＜', 'textdomain' ),
            'next_text'          => __( '＞', 'textdomain' ),
            'total' => $wp_query->max_num_pages
    ) ); ?>
    </div>
</main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->
