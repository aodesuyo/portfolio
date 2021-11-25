<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
    <main class="l-main">
    <h2 class="c-title">"<?php the_search_query(); ?>"を含む記事一覧</h2>
        <?php if (! have_posts()): ?>
            <p class="c-text--bold">記事はありません</p>
            <a class="c-button" href="/single">投稿一覧に戻る</a>
        <?php endif; ?> 
        <article class="p-archive">
        <ul class="p-archive__post">
            <?php if (have_posts()):
                while (have_posts()):
                the_post(); ?>
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
                endif; ?><!--検索結果があればループ開始-->
                </ul>
                <section class="p-archive__option">
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
            <section class="p-archive__search">
                <h2 class="c-title--small">キーワード検索</h2>
                <?php get_search_form(); ?>
            </section>
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
        <a class="c-button" href="/single">投稿一覧に戻る</a>
    </main>
<?php get_footer(); ?><!--footer.phpを読み込むテンプレートタグ（インクルードタグ）-->

