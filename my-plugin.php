<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: https://github.com/mignonstyle/my-plugin
 * Description: 練習用のプラグインです
 * Version: 0.1
 * Author: Mignon Style
 * Author URI: http://mignonstyle.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * 1年以上更新されていない記事の更新期間（年）を計算
 */
function my_old_post_message() {
	// 更新日で調べる
	// $diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_modified_time( 'Ymd' ) );
	$diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_date( 'Ymd' ) );
	$diff = $diff / 60 / 60 / 24;
	$diff = ( $diff > 365 ) ? floor( $diff / 365 ) : '';

	return $diff;
}

/**
 * ショートコードを登録
 */
function my_old_post_message_shortcode() {
	$year = my_old_post_message();

	if ( !empty( $year ) ) {
		$text = sprintf( 'この記事は%d年以上前の記事です。内容が古い可能性がありますのでお気を付け下さい。', $year );
		$text = '<div class="old-post-message"><p>' . esc_attr( $text ) . '</p></div>';
	} else {
		$text = '';
	}

	return $text;
}
add_shortcode( 'my_old_post_message', 'my_old_post_message_shortcode' );