<?php get_header(); ?><!--header.phpを読み込むテンプレートタグ（インクルードタグ）-->
<main class="l-main">
    <h2 class="c-title">制作物一覧</h2>

<!-- フォームパーツ -->
<form class="p-archive__form" action="<?=esc_url(home_url('/portfolio/'))?>">

    <label><input type="checkbox" name="portfolio_tag[]" value="コーディング" <?=in_array('コーディング',(array)get_query_var('portfolio_tag'))?' checked':''?>><span class="c-category__item">コーディング</span></label>
    <label><input type="checkbox" name="portfolio_tag[]" value="デザイン" <?=in_array('デザイン',(array)get_query_var('portfolio_tag'))?' checked':''?>><span class="c-category__item">デザイン</span></label>
    <label><input type="checkbox" name="portfolio_tag[]" value="ライティング" <?=in_array('ライティング',(array)get_query_var('portfolio_tag'))?' checked':''?>><span class="c-category__item">ライティング</span></label>

    <?php wp_nonce_field('my-archive-nonce', 'nonce'); ?>
    
    <button class="c-button-wide" type="submit">検索する</button>

</form>

<ul class="l-archive-list">
    <?php
        if(have_posts()):
            while(have_posts()):
                the_post();?>
                <li class="c-archive">
                <?php if ( has_post_thumbnail() ) : ?>
                    <img class="c-archive__thumbnail" src=<?php echo get_the_post_thumbnail_url(); ?>>
                <?php else : ?>
                    <img class="c-archive__thumbnail" src="<?php echo get_template_directory_uri(); ?>/img/p0337_l.jpg">
                <?php endif; ?>
                <div class="c-archive__wrapper">
                    <?php the_title
                        ( '<h3 class="c-title--small"><a href="'.esc_url( get_permalink()).'">','</a></h3>');
                    ?>
                    <ul class="p-portfolio-list__category">
                        <?php
                            if ($terms = get_the_terms($post->ID, 'portfolio_tag')) {
                            foreach ( $terms as $term ) {echo '<li>'.esc_html($term->name).'</li>';}
                            }
                        ?>
                    </ul>
                    <p class="c-text--bold"><?php echo esc_html( $post->portfolio_url ); ?></p>
                    <p class="c-text--bold"><?php echo esc_html( $post->portfolio_about ); ?></p>
                </div>
            </li>
    <?php endwhile;
        else:
            echo '<p class="c-common__text">記事はありません</p>';
        endif;
    ?><!--カテゴリに記事があればループ開始、なければ記事はありませんと返す-->
</ul>
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
