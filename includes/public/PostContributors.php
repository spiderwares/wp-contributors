<?php
/**
 * Display Contributor Public class.
 *
 * @package WPContributors
 */

namespace WPContributors\Public;

// Prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Class to handle Contributors Metabox.
 */
class PostContributors {

	/**
	 * Constructor.
	 * Adds the_content filter hook.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Action / Filters to be declare here.
	 *
	 * @return void
	 */
	protected function setup_hooks() {
		add_filter( 'the_content', array( $this, 'display_contributors' ) );
	}

	/**
	 * Append contributors box to post content.
	 *
	 * @param  string $content Post content.
	 * @return string Modified post content.
	 */
	public function display_contributors( $content ) {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$contributors = $this->get_contributors( get_the_ID() );

		if ( empty( $contributors ) ) {
			return $content;
		}

		$contributors_box = $this->load_contributors_template( $contributors );

		return $content . $contributors_box;
	}

	/**
	 * Retrieve the saved contributors for a post.
	 *
	 * @param  int $post_id Post ID.
	 * @return array Array of user IDs.
	 */
	private function get_contributors( $post_id ) {
		$saved_contributors = get_post_meta( $post_id, '_post_contributors', true );
		$saved_contributors = apply_filters( 'wpcb_get_contributors_ids', $saved_contributors, $post_id );
		if ( empty( $saved_contributors ) || ! is_array( $saved_contributors ) ) {
			return array();
		}

		return $saved_contributors;
	}

	/**
	 * Load the contributors box template.
	 *
	 * @param  array $contributors Array of contributor user IDs.
	 * @return string HTML content of contributors box.
	 */
	private function load_contributors_template( $contributors ) { // @codingStandardsIgnoreLine
		ob_start();

		$template_path = apply_filters( 'wpcb_contributors_list_tempalte', WPCB_PATH . '/templates/contributors.php' );

		if ( file_exists( $template_path ) ) {
			// Pass contributors to template.
			include $template_path;
		}

		return ob_get_clean();
	}
}
