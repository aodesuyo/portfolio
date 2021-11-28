<?php get_header(); ?>
  <main class="l-main">
  <?php while ( have_posts() ) : the_post(); ?>
 
  <?php $terms = get_the_terms($post->ID, 'tax_news'); ?>
 
  <article class="c-post">
    <div class="p-single-portfolio__title">
      <h1 class="c-title"><?php the_title(); ?></h1>
      <ul class="c-category"> 
          <?php
            if ($terms = get_the_terms($post->ID, 'portfolio_tag')) {
            foreach ( $terms as $term ) {echo '<li>'.esc_html($term->name).'</li>';}
            }
          ?>
      </ul>
    </div>
      <a class="c-text--bold" href="<?php echo esc_html( $post->portfolio_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $post->portfolio_url ); ?></a>
      <p class="c-text--bold"><?php echo esc_html( $post->portfolio_about ); ?></p>
      <div class="p-single-portfolio__mockup">
        <?php echo '<img src="'.wp_get_attachment_url(get_post_meta($post->ID , 'portfolio_image_pc1' ,true)). '">'; ?>
        <?php echo '<img src="'.wp_get_attachment_url(get_post_meta($post->ID , 'portfolio_image_sp1' ,true)). '">'; ?>
        <?php echo '<img src="'.wp_get_attachment_url(get_post_meta($post->ID , 'portfolio_image_sp2' ,true)). '">'; ?>
        <?php echo '<img src="'.wp_get_attachment_url(get_post_meta($post->ID , 'portfolio_image_pc2' ,true)). '">'; ?>
      </div>
      <div class="c-post p-single-portfolio__edit">
        <?php the_content(); ?>
        <?php wp_link_pages(); ?>
      </div>
    </article>
    
    <div class="c-paginate-post">
      <?php previous_post_link('%link','<< 前の制作物 %title'); ?>
      <?php next_post_link('%link','%title 次の制作物 >>'); ?>
    </div>
    <a class="c-button" href="<?php echo get_post_type_archive_link( 'portfolio' ); ?>">制作物一覧に戻る</a>
    </main>
  <?php endwhile; ?>
 
  <?php get_footer(); ?>
