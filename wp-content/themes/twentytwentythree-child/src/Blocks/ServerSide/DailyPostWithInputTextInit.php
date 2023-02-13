<?php
/**
 * Gutenberg Server side block.
 *
 * Demo Server side Options to block.
 *
 * @package Init
 */

namespace DEV\Theme\Blocks\ServerSide;

/**
 * Custom block DailyPostWithInputText
 *
 * Inicialized on init.php!
 */
class DailyPostWithInputTextInit {


	function __construct() {
		add_action( 'rest_api_init', array( $this, 'block_rest_api_init' ) );
	}

	public static function block_generate_daily_post( $count ) {

		$posts = new \WP_Query(
			array(
				'posts_per_page' => $count,
				'status'         => 'publish',
				'post_type'      => 'post',
				'orderby'        => 'rand',
			)
		);

		$post_ids = array();

		if ( $posts->have_posts() ) :
			while ( $posts->have_posts() ) :
				$posts->the_post();
				array_push( $post_ids, get_the_ID() );

			endwhile;
		endif;
		wp_reset_postdata();

		$transient_value = $post_ids;

		set_transient( 'block_daily_post_ids', $transient_value, DAY_IN_SECONDS );

		return $transient_value;
	}

	/**
	 * block_rest_api_init
	 */
	public function block_rest_api_init() {
		register_rest_route(
			'fsd/v1',
			'/daily-post',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'block_rest_daily_post_handler' ),
				'permission_callback' => '__return_true',
			),
			false
		);
	}

	/**
	 * block_rest_daily_post_handler
	 */
	public function block_rest_daily_post_handler( $request ) {

		$count    = intval( $request->get_param( 'count' ) );
		$response = array();
		$ids      = false || get_transient( 'block_daily_post_ids' );

		if ( ! $ids || ! is_array( $ids ) ) {
			$ids = $this->block_generate_daily_post( $count );
		}

		if ( count( $ids ) !== $count ) {
			$ids = $this->block_generate_daily_post( $count );
		}

		if ( ! empty( $ids ) ) {

			foreach ( $ids as $id ) {
				$post          = array();
				$post['url']   = get_permalink( $id );
				$post['title'] = get_the_title( $id );
				$post['img']   = get_the_post_thumbnail_url( $id, 'full' );

				array_push( $response, $post );
			}
		}

		return $response;
	}

}



