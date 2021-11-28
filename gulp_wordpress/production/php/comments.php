<?php if( comments_open() ){ ?>
    <section class="c-comment">
    <h2 class="c-title--small">コメント</h2>
<?php if( have_comments() ): ?>
    <ul class="c-comment__list">
    <?php 
        $args = array(
            'walker' => new My_Walker_Comment,
        );
        wp_list_comments($args);?>
    </ul>
        <?php if (get_comment_pages_count() > 1) : ?>
            <ul class="c-comment-pagination">
                <li class="c-comment-pagination__prev"><?php previous_comments_link('&lt;&lt; 前のコメント'); ?></li>
                <li class="c-comment-pagination__next"><?php next_comments_link('次のコメント &gt;&gt;'); ?></li>
            </ul>
        <?php endif ;?>
    <?php else :?>
        <p class="c-text">コメントはありません</p>
<?php endif ;?>
<article class="c-comment__area">
    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $args = array(
        'fields' => array(
        'author' => '<p class="c-comment__form comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><br>' .
        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="c-comment__form comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span><br>' : '<br>' ) .
        '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
        'url'    => '',
        ),
        'comment_field' => '<p class="c-comment__form comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . 
        '</label><br><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'title_reply' => '',
        'comment_notes_before' => '<p class="c-comment__form">メールアドレスは公開されませんのでご安心ください。<br />また、<span class="required">*</span> が付いている欄は必須項目となりますので、必ずご記入をお願いします。</p>',
    );
    comment_form($args);
    ?>
</article>
</section>
<?php } ?>

