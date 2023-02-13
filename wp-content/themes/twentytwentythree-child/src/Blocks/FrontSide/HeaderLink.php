<?php
/**
 * Gutenberg Front side.
 *
 * Demo Front side block.
 *
 * @package Init
 */

namespace DEV\Theme\Blocks\FrontSide;

/**
 * Custom block HeaderLink
 *
 * Inicialized on init.php.
 */
class HeaderLink extends \DEV\Theme\Blocks\BlockInit {

	/**
	 * Override block path
	 *
	 * @return string Block path
	 */
	public function get_block_path() {
		return implode(
			DIRECTORY_SEPARATOR,
			array( get_stylesheet_directory(), 'build', 'src', 'blocks', 'repetidor-links' )
		);
	}
}
