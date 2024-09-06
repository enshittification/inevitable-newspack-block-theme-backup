<?php
/**
 * A Block.
 *
 * @package Newspack_Block_Theme
 */

namespace Newspack_Block_Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Base Block class.
 */
abstract class Block implements Block_Interface {
	/**
	 * Block JSON file path.
	 *
	 * @var string
	 */
	protected $block_filepath = '';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->child_class = get_called_class();
		$reflector = new \ReflectionClass( $this->child_class );

		$this->block_filepath = dirname( $reflector->getFileName() ) . '/block.json';

		\add_action( 'init', [ $this, 'register_block' ] );
		\add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
	}

	/**
	 * Get block data.
	 */
	public function get_block_data() {
		$block_json = file_get_contents( $this->block_filepath ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		return json_decode( $block_json, true );
	}

	/**
	 * Register the block.
	 */
	public function register_block() {
		register_block_type_from_metadata(
			$this->block_filepath,
			[
				'render_callback' => [ $this, 'render_block' ],
			]
		);
	}

	/**
	 * Enqueue block editor assets, with data.
	 */
	public function enqueue_block_editor_assets() {
		$block_data = $this->get_block_data();

		$script_data = [];
		if ( method_exists( $this, 'get_block_editor_data' ) ) {
			$script_data = $this->get_block_editor_data();
		}

		$block_slug = substr( $block_data['name'], strrpos( $block_data['name'], '/' ) + 1 );
		$block_slug_snake_case = strtolower( str_replace( '-', '_', $block_slug ) );
		$localization_global_name = "newspack_block_theme_{$block_slug_snake_case}_block";

		$file_slug = 'site-editor';
		$has_site_editor_file = file_exists( get_theme_file_path( "/includes/blocks/$block_slug/$file_slug.js" ) );
		global $pagenow;
		if ( $has_site_editor_file && in_array( $pagenow, [ 'site-editor.php' ] ) ) {
			$handle = "newspack-block-theme-$block_slug-$file_slug";
			\wp_enqueue_script( $handle, \get_theme_file_uri( "dist/$block_slug-$file_slug.js" ), [], NEWSPACK_BLOCK_THEME_VERSION, true );
			\wp_localize_script( $handle, $localization_global_name, $script_data );
		}

		$file_slug = 'post-editor';
		$has_post_editor_file = file_exists( get_theme_file_path( "/includes/blocks/$block_slug/$file_slug.js" ) );
		$post_type = \get_current_screen()->post_type;
		if ( $has_post_editor_file && $post_type === 'post' ) {
			$handle = "newspack-block-theme-$block_slug-$file_slug";
			\wp_enqueue_script( $handle, \get_theme_file_uri( "dist/$block_slug-$file_slug.js" ), [], NEWSPACK_BLOCK_THEME_VERSION, true );
			\wp_localize_script( $handle, $localization_global_name, $script_data );
		}
	}
}
