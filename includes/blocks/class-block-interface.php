<?php
/**
 * Interface for a Block.
 *
 * @package Newspack
 */

namespace Newspack_Block_Theme;

/**
 * Block Interface.
 */
interface Block_Interface {
	/**
	 * Block render callback.
	 *
	 * @return string The block HTML.
	 */
	public function render_block();
}
