<?php
/**
 * Subtitle Block.
 *
 * @package Newspack_Block_Theme
 */

namespace Newspack_Block_Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Subtitle Block class.
 */
final class Subtitle_Block extends Block {
	const POST_META_NAME = 'newspack_post_subtitle';

	/**
	 * Initializer.
	 */
	public function init() {
		\add_action( 'init', [ $this, 'register_post_meta' ] );
	}

	/**
	 * Register post meta.
	 */
	public function register_post_meta() {
		register_post_meta(
			'post',
			self::POST_META_NAME,
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			]
		);
	}

	/**
	 * Block render callback.
	 */
	public function render_block() {
		$post_subtitle = get_post_meta( get_the_ID(), self::POST_META_NAME, true );
		return sprintf( '<p %1$s>%2$s</p>', get_block_wrapper_attributes(), $post_subtitle );
	}

	/**
	 * Get block editor data.
	 */
	public function get_block_editor_data() {
		return [
			'post_meta_name' => self::POST_META_NAME,
		];
	}
}
( new Subtitle_Block() )->init();
