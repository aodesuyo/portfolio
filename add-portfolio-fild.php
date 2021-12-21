<?php
function add_portfolio_fields() {
	add_meta_box(
    'portfolio_setting',//表示される入力ボックスのhtmlのID
    'ポートフォリオ情報',//ラベル
    'insert_portfolio_fields',//表示する内容を作成する関数名
    'portfolio',//投稿タイプ。postをpageに変更すれば固定ページにオリジナルカスタムフィールドが表示されます(custom_post_typeのslugを指定することも可能)。
    'normal'//表示方法。normal・side・advanced
  );
}
add_action('admin_menu', 'add_portfolio_fields');

function custom_metabox_edit_form_tag(){
  echo ' enctype="multipart/form-data"';
}
//画像をアップする場合は、multipart/form-dataの設定が必要なので、post_edit_form_tagをフックしてformタグに追加
add_action('post_edit_form_tag', 'custom_metabox_edit_form_tag');

// カスタムフィールドの入力エリア
function insert_portfolio_fields() {
	global $post;
  //get_post_meta関数を使ってpostmeta情報を取得
  $portfolio_url=get_post_meta($post->ID, 'portfolio_url', true);
  $portfolio_about=get_post_meta($post->ID, 'portfolio_about', true);

  $portfolio_image_pc1 = get_post_meta($post->ID,'portfolio_image_pc1',true);
  $portfolio_image_sp1 = get_post_meta($post->ID,'portfolio_image_sp1',true);
  $portfolio_image_pc2 = get_post_meta($post->ID,'portfolio_image_pc2',true);
  $portfolio_image_sp2 = get_post_meta($post->ID,'portfolio_image_sp2',true);

  $portfolio_image_type =array('_pc1','_sp1','_pc2','_sp2');

	//下記に管理画面に表示される入力エリアを作ります。「get_post_meta()」は現在入力されている値を表示するための記述です。
	echo 'URL： <input type="text" name="portfolio_url" value="'.$portfolio_url.'" size="50" /><br>';
	echo '概要： <textarea name="portfolio_about" cols="50">'.$portfolio_about.'</textarea><br>';

  $portfolio_image_type =array('_pc1','_sp1','_pc2','_sp2');
  
  echo '<table class="p-custom">';
  foreach ($portfolio_image_type as $value) {
    $portfolio_image_name = "portfolio_image".$value;
    echo '<tr><td><p>'.$portfolio_image_name.'</p><label class="p-custom__label">ファイルを選択<input type="file" name="'.$portfolio_image_name.'" accept="image/*"'.$portfolio_image_name.'/></label></td>';

    if(isset($portfolio_image_pc1) && strlen($portfolio_image_pc1) > 0){
      //portfolio_imageキーのpostmeta情報がある場合は、画像を表示
      //$portfolio_imageには、後述するattach_idが格納されているので、wp_get_attachment_url関数にそのattach_idを渡して画像のURLを取得する
      echo '<td><img style="width: 200px;display: block;margin: 1em;" src="'.wp_get_attachment_url(get_post_meta($post->ID , $portfolio_image_name ,true)).'"></td></tr>';
    }else{
      echo '</tr>';
    }
  }
  echo '</table>';
}


// カスタムフィールドの値を保存
function save_portfolio_fields( $post_id ) {
  if (isset($_POST['portfolio_url'])) {
    update_post_meta($post_id, 'portfolio_url', $_POST['portfolio_url']);
  }
  if (isset($_POST['portfolio_about'])) {
    update_post_meta($post_id, 'portfolio_about', $_POST['portfolio_about']);
  }

  $portfolio_image_type =array('_pc1','_sp1','_pc2','_sp2');

  foreach($portfolio_image_type as $value){
    $portfolio_image_name = "portfolio_image".$value;

    if(isset($_FILES[$portfolio_image_name]) && $_FILES[$portfolio_image_name]["size"] !== 0){
		update_post_meta($post_id, $portfolio_image_name, $_POST[$portfolio_image_name] );
    $file_name = basename($_FILES[$portfolio_image_name]['name']);
    $file_name = trim($file_name);
    $file_name = str_replace(" ", "-", $file_name);

    $wp_upload_dir = wp_upload_dir(); //現在のuploadディクレトリのパスとURLを入れた配列
    $upload_file = $_FILES[$portfolio_image_name]['tmp_name'];
    $upload_path = $wp_upload_dir['path'].'/'.$file_name; //uploadsディレクトリ以下などに配置する場合は$wp_upload_dir['basedir']を利用する
    //画像ファイルをuploadディクレトリに移動させる
    move_uploaded_file($upload_file,$upload_path);

    $file_type = $_FILES[$portfolio_image_name]['type'];
    //正規表現で拡張子なしのスラッグ名を生成
    $slug_name = preg_replace('/\.[^.]+$/', '', basename($upload_path));

    if(file_exists($upload_path)){
        //保存に成功してファイルが存在する場合は、wp_postsテーブルなどに情報を追加
        $attachment = array(
            'guid'           => $wp_upload_dir['url'].'/'.basename($file_name),
            'post_mime_type' => $file_type,
            'post_title' => $slug_name,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        //添付ファイルを追加
        $attach_id = wp_insert_attachment($attachment,$upload_path,$post_id);
        if(!function_exists('wp_generate_attachment_metadata')){
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        }
        //添付ファイルのメタデータを生成し、wp_postsテーブルに情報を保存
        $attach_data = wp_generate_attachment_metadata($attach_id,$upload_path);
        wp_update_attachment_metadata($attach_id,$attach_data);
        //wp_postmetaテーブルに画像のattachment_id(wp_postsテーブルのレコードのID)を保存
        update_post_meta($post_id, $portfolio_image_name,$attach_id);
    }else{
        //保存失敗
        echo '画像保存に失敗しました';
        exit;
    }
    }
  }
}
add_action('wp_insert_post', 'save_portfolio_fields');

function post_has_archive( $args, $post_type ) {
	if ( 'post' == $post_type ) {
		$args['rewrite'] = true;
		$args['has_archive'] = 'single'; // 任意のURL
	}
	return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );

?>
