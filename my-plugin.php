<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: https://github.com/mignonstyle/my-plugin
 * Description: My Plugin is a practice plugin
 * Version: 0.1
 * Author: Mignon Style
 * Author URI: http://mignonstyle.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package My Plugin
 */

/**
 * Calculate the period (year) of articles not updated more than 1 year.
 */
function my_old_post_year() {
	// Investigate by posting date.
	/*
	$diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_date( 'Ymd' ) );
	*/

	// Investigate by update date.
	$diff = strtotime( date( 'Ymd' ) ) - strtotime( get_the_modified_time( 'Ymd' ) );
	$diff = $diff / 60 / 60 / 24;
	$diff = ( $diff > 365 ) ? floor( $diff / 365 ) : '';

	return $diff;
}

/**
 * Register shortcode.
 *
 * @return string
 */
function my_old_post_message_shortcode() {
	$year = my_old_post_year();

	if ( ! empty( $year ) ) {
		$text = sprintf( 'This article is an article over% d years ago. Please be aware that the contents may be old.', $year );
		$text = '<div class="old-post-message"><p>' . esc_attr( $text ) . '</p></div>';
	} else {
		$text = '';
	}

	return $text;
}
add_shortcode( 'my_old_post_message', 'my_old_post_message_shortcode' );

/**
 * Use shortcode in widget.
 */
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Display message in front of text using filterhook.
 *
 * @return string
 */
function my_old_post_message_content( $content ) {
	$year = my_old_post_year();

	if ( ! empty( $year ) ) {
		$text = sprintf( 'This article is an article over% d years ago. Please be aware that the contents may be old.', $year );
		$text = '<div class="old-post-message"><p>' . esc_attr( $text ) . '</p></div>';
	} else {
		$text = '';
	}

	return $text . $content;
}
add_filter( 'the_content', 'my_old_post_message_content' );

/**
 * Create style sheet.
 */
function my_plugin_enqueue_scripts() {
	wp_enqueue_style( 'my-plugin', plugins_url( 'css/my-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_scripts' );
