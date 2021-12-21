<?php
    function create_tag_taxonomy(){
        $args = array(
        'label'        => '制作カテゴリ',           // タクソノミー名
        'public'       => true,               // 公開するかどうか
        'hierarchical' => false,              // 階層を持たせるかどうか
        'show_in_rest' => true                //ブロックエディタにカスタムタクソノミを表示させる
        );
        register_taxonomy(
        'portfolio_tag',// $taxonomyタクソノミーのスラッグ
        'portfolio', // $object_typeどの投稿タイプに追加するか
        $args
        );
    }
    add_action('init', 'create_tag_taxonomy');
?>
