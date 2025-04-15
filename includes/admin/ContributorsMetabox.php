<?php
/**
 * Metabox class.
 *
 * @package WPContributors
 */

namespace WPContributors\Admin;

// Prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Class to handle Contributors Metabox.
 */
class ContributorsMetabox {


	/**
	 * Constructor.
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
		add_action( 'add_meta_boxes', array( $this, 'add_contributors_metabox' ) );
		add_action( 'save_post', array( $this, 'save_contributors_metabox' ) );
	}

	/**
	 * Add the contributors metabox.
	 */
	public function add_contributors_metabox() {
		add_meta_box(
			'post_contributors',
			__( 'Contributors', 'wp-contributors' ),
			array( $this, 'render_contributors_metabox' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * Render the contributors metabox content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_contributors_metabox( $post ) {
		// Retrieve existing contributors.
		$saved_contributors = get_post_meta( $post->ID, '_post_contributors', true );
		$saved_contributors = is_array( $saved_contributors ) ? $saved_contributors : array();

		// Get all users with author or higher role.
		$authors = apply_filters( 
			'wpcb_get_metabox_contributors',
			get_users(
				array(
					'who'     => 'authors',
					'orderby' => 'display_name',
					'order'   => 'ASC',
				)
			)
		);

		if ( ! empty( $authors ) ) {
			include_once WPCB_PATH . '/includes/admin/views/authors.php';
		} else {
			echo esc_html__( 'No authors found.', 'wp-contributors' );
		}
	}

	/**
	 * Save the contributors when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_contributors_metabox( $post_id ) {

		// Check if nonce is set.
		if ( ! isset( $_POST['_wpnonce'] ) ) {
			return;
		}

		// Verify WordPress's default post nonce.
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'update-post_' . $post_id ) ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		
		// Sanitize and save the contributors.
		if ( isset( $_POST['post_contributors'] ) && is_array( $_POST['post_contributors'] ) ) {
			$contributor_ids = array_map( 'intval', $_POST['post_contributors'] );
			update_post_meta( $post_id, '_post_contributors', $contributor_ids );
		} else {
			// If no contributors are selected, delete the meta.
			delete_post_meta( $post_id, '_post_contributors' );
		}

		do_action( 'wpcb_after_contributors_saved', $contributor_ids, $post_id );
	}
}
