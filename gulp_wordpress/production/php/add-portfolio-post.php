<?php
add_action( 'init', 'create_post_type_portfolio' );
function create_post_type_portfolio() {
    $labels = array(
      'name'               => _x( 'portfolio', 'post type general name', 'your-plugin-textdomain' ),
      'singular_name'      => _x( 'portfolio', 'post type singular name', 'your-plugin-textdomain' ),
      'menu_name'          => _x( 'portfolio', 'admin menu', 'your-plugin-textdomain' ),
      'name_admin_bar'     => _x( 'portfolio', 'add new on admin bar', 'your-plugin-textdomain' ),
      'add_new'            => _x( 'Add New portfolio', 'portfolio', 'your-plugin-textdomain' ),
      'add_new_item'       => __( 'Add New portfolio', 'your-plugin-textdomain' ),
      'new_item'           => __( 'New portfolio', 'your-plugin-textdomain' ),
      'edit_item'          => __( 'Edit portfolio', 'your-plugin-textdomain' ),
      'view_item'          => __( 'View', 'your-plugin-textdomain' ),
      'all_items'          => __( 'All portfolio', 'your-plugin-textdomain' ),
      'search_items'       => __( 'Search portfolio', 'your-plugin-textdomain' ),
      'parent_item_colon'  => __( 'Parent portfolio:', 'your-plugin-textdomain' ),
      'not_found'          => __( 'No portfolio found.', 'your-plugin-textdomain' ),
      'not_found_in_trash' => __( 'No portfolio found in Trash.', 'your-plugin-textdomain' )
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
