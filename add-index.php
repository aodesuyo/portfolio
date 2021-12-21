
<?php function add_index( $content ) {
	/**
 * 目次.
 *
 * @param string $content 記事の内容.
 * @return string $content 目次追加後の内容.
 */
    if ( is_single() ) {
		$pattern = '/<h[1-6]>(.+?)<\/h[1-6]>/s';
		preg_match_all( $pattern, $content, $elements, PREG_SET_ORDER );

		if ( count( $elements ) >= 1 ) {
			$toc          = '';
			$i            = 0;
			$currentlevel = 0;
			$id           = 'chapter-';

			foreach ( $elements as $element ) {
				$id           .= $i + 1;
				$regex         = '/' . preg_quote( $element[0], '/' ) . '/su';
				$replace_title = preg_replace( '/<(h[1-6])>(.+?)<\/(h[1-6])>/s', '<$1 id="' . $id . '">$2</$3>', $element[0], 1 );
				$content       = preg_replace( $regex, $replace_title, $content, 1 );

				if ( strpos( $element[0], '<h2' ) !== false ) {
					$level = 1;
				} elseif ( strpos( $element[0], '<h3' ) !== false ) {
					$level = 2;
				} elseif ( strpos( $element[0], '<h4' ) !== false ) {
					$level = 3;
				} elseif ( strpos( $element[0], '<h5' ) !== false ) {
					$level = 4;
				} elseif ( strpos( $element[0], '<h6' ) !== false ) {
					$level = 5;
				}

				while ( $currentlevel < $level ) {
					if ( 0 === $currentlevel ) {
						$toc .= '<ul class="p-single-index__list">';
					} else {
						$toc .= '<ul class="p-single-index__list-child">';
					}
					$currentlevel++;
				}

				while ( $currentlevel > $level ) {
					$toc .= '</li></ul>';
					$currentlevel--;
				}

				// 目次の項目で使用する要素を指定
				$toc .= '<li class="p-single-index__item"><a href="#' . $id . '" class="p-single-index__link">' . $element[1] . '</a>';
				$i++;
				$id = 'chapter-';
			} // foreach

			// 目次の最後の項目をどの要素から作成したかによりタグの閉じ方を変更
			while ( $currentlevel > 0 ) {
				$toc .= '</li></ul>';
				$currentlevel--;
			}

			$index = '<div class="p-single-index index" id="toc"><div class="p-single-index__title">目次<button class="p-single-index__button">開く</button></div>' . $toc . '</div>';
			$h2    = '/<h2.*?>/i';

			if ( preg_match( $h2, $content, $h2s ) ) {
				$content = preg_replace( $h2, $index . $h2s[0], $content, 1 );
			}
		}
	}
	return $content;
}
add_filter( 'the_content', 'add_index' );
