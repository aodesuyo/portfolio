<?php if( comments_open() ){ ?>
    <h3>コメント</h3>
<?php if( have_comments() ): ?>
    <ul class="c-comment">
    <?php wp_list_comments();?>
    </ul>
        <?php if (get_comment_pages_count() > 1) : ?>
            <ul id="c-comments__pagination">
                <li id="prev-comments"><?php previous_comments_link('&lt;&lt; 前のコメント'); ?></li>
                <li id="next-comments"><?php next_comments_link('次のコメント &gt;&gt;'); ?></li>
            </ul>
        <?php endif ;?>
    <?php else :?>
        <p>コメントはありません</p>
<?php endif ;?>

<?php
  // コメントフォームの設定
  $args = array(
    'title_reply' => 'コメントを書く',
    'comment_notes_before' => 'コメントを書くtextareaの前に出力される',
    'comment_notes_after' => 'コメントを書くtextareaの後に出力される',
    'label_submit' => 'コメントを送信する'
  );
  // コメントフォームの呼び出し
  comment_form( $args );
?>
</div>
<?php } ?>
