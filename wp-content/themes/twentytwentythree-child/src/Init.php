<?php
/**
 * Initialize Classes.
 *
 * Add Shortcode example to autoload.
 *
 * @package Init
 */
namespace DEV\Theme;

 /**
  * Init
  *
  * @package    Init
  * @subpackage src
  * @author     pedro henrique romio <pedrohenriqueromio@gmail.com>
  */
class Init extends Load {

	public function __construct() {
		/**
		 * Array of Controller Class
		 */
		$class_list = array(
			// Shortcodes
			'Providers\Shortcode',

			// Blocks ',
			'Blocks\FrontSide\HeaderLink',
			'Blocks\ServerSide\DailyPostWithInputText',

			// Block Configurations
			'Blocks\ServerSide\DailyPostWithInputTextInit',
		);

		$this->load_classes( $class_list );
	}

}
