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
	const POST_META_NAME = 'newspack_post_subtitle';

	/**
	 * Initializer.
	 */
	public static function init() {
		\add_action( 'init', [ __CLASS__, 'register_block_and_post_meta' ] );
		\add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_block_editor_assets' ] );
	}

	/**
	 * Register the block.
	 */
	public static function register_block_and_post_meta() {
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

		register_post_meta(
			'post',
			self::POST_META_NAME,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
	}

	/**
	 * Block render callback.
	 */
	public static function render_block() {
		$post_subtitle = get_post_meta( get_the_ID(), self::POST_META_NAME, true );
		ob_start();
		?>
			<p><?php echo esc_html( $post_subtitle ); ?></p>
		<?php
		return ob_get_clean();
	}

	/**
	 * Enqueue block editor ad suppression assets for any post type considered
	 * "viewable".
	 */
	public static function enqueue_block_editor_assets() {
		$script_data = [
			'post_meta_name' => self::POST_META_NAME,
		];
		$post_type = \get_current_screen()->post_type;
		if ( $post_type !== 'post' ) {
			return;
		}
		$handle = 'newspack-block-theme-subtitle-block-post-editor';
		\wp_enqueue_script( $handle, \get_theme_file_uri( 'dist/subtitle-block-post-editor.js' ), [], NEWSPACK_BLOCK_THEME_VERSION, true );
		\wp_localize_script( $handle, 'newspack_block_theme_subtitle_block', $script_data );
	}
}
Subtitle_Block::init();
