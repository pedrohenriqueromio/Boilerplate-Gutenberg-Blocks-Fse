<?php
/**
 * Gutenberg Front side.
 *
 * Demo Front side block.
 *
 * @package Init
 */

namespace DEV\Theme\Blocks\ServerSide;

/**
 * Custom block DailyPostWithInputText
 *
 * Inicialized on init.php!
 */
class DailyPostWithInputText extends \DEV\Theme\Blocks\BlockInit {


	/**
	 * Override block path
	 *
	 * @return string Block path
	 */
	public function get_block_path() {
		return implode(
			DIRECTORY_SEPARATOR,
			array( get_stylesheet_directory(), 'build', 'src', 'blocks', 'daily-post-with-input-text' )
		);
	}

	/**
	 * To render a server side Block, needs to create a serversideCallback method
	 */
	function serverSideCallback( $atts ) {

		$count = $atts['count'];
		$title = $atts['textinput'];
		$posts = get_transient( 'block_daily_post_ids' );

		if ( ! $posts || ! is_array( $posts ) ) {
			$posts = DailyPostWithInputTextInit::block_generate_daily_post( $count );
		}

		if ( count( $posts ) !== $count ) {
			$posts = DailyPostWithInputTextInit::block_generate_daily_post( $count );
		}

		ob_start(); ?>
		
		<h1><?php echo $title; ?></h1>
		
		<?php foreach ( $posts as $id ) : ?>
			<div class="wp-block-udemy-plus-daily-post">
				<a href="<?php the_permalink( $id ); ?>">
					<img src="<?php echo get_the_post_thumbnail_url( $id, 'full' ); ?>" alt="">
					<p><?php echo get_the_title( $id ); ?></p>
				</a>
			</div>
		<?php endforeach; ?>
		
		<?php
		return ob_get_clean();
	}
}



