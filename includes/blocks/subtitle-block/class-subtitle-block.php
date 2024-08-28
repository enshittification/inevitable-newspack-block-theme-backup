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
final class Subtitle_Block {
	/**
	 * Initializer.
	 */
	public static function init() {
		\add_action( 'init', [ __CLASS__, 'register_block' ] );
	}

	/**
	 * Register the block.
	 */
	public static function register_block() {
		$block_json = json_decode(
			file_get_contents( __DIR__ . '/block.json' ), // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			true
		);
		register_block_type(
			$block_json['name'],
			[
				'attributes'      => $block_json['attributes'],
				'render_callback' => [ __CLASS__, 'render_block' ],
			]
		);
	}

	/**
	 * Block render callback.
	 */
	public static function render_block() {
		$post_subtitle = get_post_meta( get_the_ID(), 'newspack_post_subtitle', true );
		ob_start();
		?>
			<p><?php echo esc_html( $post_subtitle ); ?></p>
		<?php
		return ob_get_clean();
	}
}
Subtitle_Block::init();
