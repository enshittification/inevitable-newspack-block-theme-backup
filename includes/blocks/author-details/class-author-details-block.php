<?php
/**
 * Author Details Block.
 *
 * @package Newspack_Block_Theme
 */

namespace Newspack_Block_Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Author Details Block class.
 */
final class Author_Details_Block extends Block {
	/**
	 * Block render callback.
	 */
	public function render_block() {
		$content = 'author details';
		return sprintf( '<div %1$s>%2$s</div>', get_block_wrapper_attributes(), $content );
	}
}
new Author_Details_Block();
