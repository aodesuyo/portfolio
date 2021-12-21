<?php
add_action( 'init', 'create_post_type_portfolio' );
function create_post_type_portfolio() {
    $labels = array(
      'name'               => 'portfolio',
      'singular_name'      => 'portfolio',
      'menu_name'          => 'portfolio',
      'name_admin_bar'     => 'portfolio',
      'add_new'            => 'Add New portfolio',
      'add_new_item'       => 'Add New portfolio',
      'new_item'           => 'New portfolio',
      'edit_item'          => 'Edit portfolio',
      'view_item'          => 'View',
      'all_items'          => 'All portfolio',
      'search_items'       => 'Search portfolio',
      'parent_item_colon'  => 'Parent portfolio:',
      'not_found'          => 'No portfolio found.',
      'not_found_in_trash' => 'No portfolio found in Trash.',
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,// パブリックにするかどうか。初期値: false
        'publicly_queryable' => true,// post_typeクエリが実行可能かどうか。初期値: public引数の値
        'show_ui'            => true,// 管理するデフォルトUIを生成するかどうか。初期値: public引数の値
        'show_in_menu'       => true,
        'show_in_rest' => true,//ブロックエディタを有効にする
        'query_var'          => true, // query_varキーの名前。初期値: true - $post_typeの名前
        'rewrite'            => array( 'slug' => 'portfolio' ),
        'capability_type'    => 'post',// 権限の指定。初期値: 'post'
        'has_archive'        => true, // アーカイブページを有効にするかどうか。初期値: false
        'hierarchical'       => false,// 階層構造を持つかどうか。初期値: false
        'menu_position'      => null, // メニューの表示位置。初期値: null - コメントの下
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )// 投稿できる項目。初期値: titleとeditor
    );

    register_post_type( 'portfolio', $args );
}
?>
