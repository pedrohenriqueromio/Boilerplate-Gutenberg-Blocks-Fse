<?php
/**
 * Gutenberg loader classes.
 *
 * Using Reflection.
 *
 * @package Init
 */
namespace DEV\Theme\Blocks;

/**
 * Class BlockInit
 *
 * Initialize Blocks to instance, inicialized on init.php and classes extending.
 */
class BlockInit {

	public $context;
	public $className;
	public $blockPath;
	public $blockJsonPath;
	public $blockArgs;
	public $block;
	public $themeJson;
	public $args;

	/**
	 * Register a block from $blockPath
	 *
	 * @return void
	 */
	public function __construct() {
		if ( method_exists( $this, 'onLoad' ) ) {
			$this->onLoad();
		}

		$this->context       = strpos( __DIR__, get_stylesheet_directory() ) !== false ? 'theme' : 'plugin';
		$this->className     = $this->get_class_name();
		$this->blockPath     = $this->get_block_path();
		$this->blockJsonPath = $this->get_block_json_path();
		$this->blockArgs     = $this->get_block_args();

		/**
		 * Register blocks ( front or backend )
		 */
		add_action(
			'init',
			function () {
				$this->block = register_block_type(
					$this->blockJsonPath,
					$this->blockArgs // Server Side Callback!
				);
			},
			1
		);

		if ( method_exists( $this, 'initRestApi' ) ) {
			add_action(
				'rest_api_init',
				array( $this, 'initRestApi' )
			);
		}

		if ( method_exists( $this, 'initSettings' ) ) {
			add_action(
				'admin_init',
				array( $this, 'initSettings' )
			);
		}

		add_action(
			'enqueue_block_assets',
			array( $this, 'enforceDefaultAssets' )
		);

		$this->themeJson = json_decode(
			file_get_contents(
				get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'theme.json',
			),
			true
		);
	}

	/**
	 * Get current class name
	 * May be overriden by a descendant class
	 *
	 * @return string Class name without namespace
	 */
	public function get_class_name() {
		$nameParts = explode( '\\', get_class( $this ) );
		return $nameParts[ count( $nameParts ) - 1 ];
	}

	/**
	 * Get block path
	 * May be overriden by a descendant class
	 *
	 * @return string Path to block assets
	 */
	public function get_block_path() {
		return implode(
			DIRECTORY_SEPARATOR,
			array( get_stylesheet_directory(), 'build', 'src', 'blocks', $this->get_class_name() )
		);
	}

	/**
	 * Get block JSON path
	 * May be overriden by a descendant class
	 *
	 * @return string Path to block assets
	 */
	public function get_block_json_path() {
		if ( empty( $this->blockPath ) ) {
			$this->blockPath = $this->get_block_path();
		}
		$blockJsonSearch = array(
			$this->blockPath . DIRECTORY_SEPARATOR . 'block.json',
			implode( DIRECTORY_SEPARATOR, array( $this->blockPath, 'build', 'block.json' ) ),
			implode( DIRECTORY_SEPARATOR, array( $this->blockPath, 'dist', 'block.json' ) ),

		);
		foreach ( $blockJsonSearch as $blockJsonPath ) {
			if ( file_exists( $blockJsonPath ) ) {
				return $blockJsonPath;
			}
		}
		trigger_error(
			sprintf(
				'%s cant find a block.json file under %s.' .
				' *** Make sure you builded your block in javascript. ***',
				get_class( $this ),
				$this->blockPath
			),
			E_USER_ERROR
		);
	}

	/**
	 * Get block args
	 * May be overriden by a descendant class
	 *
	 * @return string Path to block assets
	 */
	public function get_block_args() {
		if ( isset( $this->args ) ) {
			return $this->args;
		}
		$blockJsonPath = $this->get_block_json_path();
		$args          = json_decode(
			file_get_contents( $blockJsonPath ),
			true
		);
		// TODO: Documentar serverSideCallback
		if ( method_exists( $this, 'serverSideCallback' ) ) {
			$args['render_callback'] = array( $this, 'serverSideCallback' );
		}
		$this->args = $args;
		return $args;
	}

	/**
	 * Assures default enqueues are enqueued
	 * Builds and enqueue asset handles according to default names
	 */
	public function enforceDefaultAssets() {
		/**
		 * @todo
		 * Are we loading block styles in any site call?
		 * There is a selecting block loader hook to filter this?
		 * How to load this styles alson in block editor?
		 */
		$styleHandle = str_replace( '/', '-', $this->block->name ) . '-style';
		wp_enqueue_style( $styleHandle );
	}
}
