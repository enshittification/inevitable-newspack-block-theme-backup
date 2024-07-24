<?php
/**
 * Newspack Block Theme.
 *
 * @package Newspack
 */

namespace Newspack_Block_Theme\Hook;

/**
 * Register block.
 */
function register_block() {
	register_block_type(
		__DIR__ . '/block.json',
		[
			'render_callback' => __NAMESPACE__ . '\\render_block',
		]
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_block' );


function hook_list() {
	$hooks = [
		'name' => 'after_header',
		'name' => 'before_footer',
	];

	return apply_filters( 'newspack_block_theme_hooks', $hooks );
}

/**
 * Render block output
 */
function render_block( $attr ) {
	ob_start();

	$hookName = $attr[ 'hookName' ];
	do_action( $hookName );

	return ob_get_clean();
}