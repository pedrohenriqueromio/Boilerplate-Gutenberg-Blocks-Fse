<?php
/**
 * Abstract class to instance classes from Init file.
 *
 * Using Reflection.
 *
 * @package Init
 */

namespace DEV\Theme;

use ReflectionClass;

/**
 * Init
 *
 * @package    Init
 * @subpackage src
 * @author     pedro henrique romio <pedrohenriqueromio@gmail.com>
 */
abstract class Load {


	/**
	 * Get namespace this class.
	 *
	 * @return string
	 */
	public function get_namespace() {
		return ( new ReflectionClass( $this ) )->getNamespaceName();
	}

	/**
	 * Create instance of controllers.
	 *
	 * @param string $class class name.
	 */
	private function instance( $class ) {
		new $class();
	}

	/**
	 * Initialize classes in MVC.
	 *
	 * @param array $controllers list of classes.
	 */
	public function load_classes( $controllers ) {
		$namespace = $this->get_namespace();

		if ( ! empty( $controllers ) ) :
			foreach ( $controllers as $name ) {
				$this->instance( sprintf( "{$namespace}\%s", $name ) );
			}
		endif;
	}
}
