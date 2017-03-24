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
 * 1年以上更新されていない記事の期間（年）を計算
 */
function my_old_post_year() {
	// 投稿日で調べる
	// $diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_date( 'Ymd' ) );

	// 更新日で調べる
	$diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_modified_time( 'Ymd' ) );
	$diff = $diff / 60 / 60 / 24;
	$diff = ( $diff > 365 ) ? floor( $diff / 365 ) : '';

	return $diff;
}

/**
 * ショートコードを登録
 */
function my_old_post_message_shortcode() {
	$year = my_old_post_year();

	if ( !empty( $year ) ) {
		$text = sprintf( 'この記事は%d年以上前の記事です。内容が古い可能性がありますのでお気を付け下さい。', $year );
		$text = '<div class="old-post-message"><p>' . esc_attr( $text ) . '</p></div>';
	} else {
		$text = '';
	}

	return $text;
}
add_shortcode( 'my_old_post_message', 'my_old_post_message_shortcode' );

/**
 * ウィジェットでショートコードを使用する
 */
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * フィルターフックを使って本文の前にメッセージを表示
 */
function my_old_post_message_content( $content ) {
	$year = my_old_post_year();

	if ( !empty( $year ) ) {
		$text = sprintf( 'この記事は%d年以上前の記事です。内容が古い可能性がありますのでお気を付け下さい。', $year );
		$text = '<div class="old-post-message"><p>' . esc_attr( $text ) . '</p></div>';
	} else {
		$text = '';
	}

	return $text . $content;
}
add_filter( 'the_content', 'my_old_post_message_content' );

/**
 * スタイルシートの登録
 */
function my_plugin_enqueue_scripts() {
	wp_enqueue_style( 'my-plugin', plugins_url( 'css/my-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_scripts' );