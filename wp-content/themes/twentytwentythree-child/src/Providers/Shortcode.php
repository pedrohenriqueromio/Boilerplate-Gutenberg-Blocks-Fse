<?php
/**
 * Shortcode class.
 *
 * Add Shortcode example to autoload.
 */
namespace DEV\Theme\Providers;

/**
 * Example of pattern shortcode
 */
class Shortcode {

	/**
	 * Add shotcode
	 */
	function __construct() {
		add_shortcode( 'youtube', array( &$this, 'youtube_shortcode_func' ) );
	}

	/**
	 * Callback of content of shortcode
	 */
	public function youtube_shortcode_func( $atts ) {

		/**
		 * set attrs as variables
		 */
		extract(
			shortcode_atts(
				array(
					'video' => '',
				),
				$atts
			)
		);

		$output = '<h1>' . $title . '</h1>
		<iframe width="420" height="345" src="https://www.youtube.com/embed/' . $video . '?autoplay=1&mute=1"></iframe>';

		return $output;
	}
}
