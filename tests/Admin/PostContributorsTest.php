<?php
/**
 * Test case for ContributorsMetabox class.
 *
 * @package WPContributors
 */

namespace WPContributors\Tests\Admin;

use WPContributors\Admin\ContributorsMetabox;

/**
 * ContributorsMetabox test case.
 */
class ContributorsMetaboxTest extends \WP_UnitTestCase {

	/**
	 * ContributorsMetabox instance.
	 *
	 * @var ContributorsMetabox
	 */
	protected $contributors_metabox;

	/**
	 * Setup.
	 */
	public function setUp(): void {
		parent::setUp();
		$this->contributors_metabox = new ContributorsMetabox();
	}

	/**
	 * Test if hooks are set up.
	 */
	public function test_hooks_are_added() {
		global $wp_filter;

		$this->assertArrayHasKey( 'add_meta_boxes', $wp_filter );
		$this->assertArrayHasKey( 'save_post', $wp_filter );
	}

	/**
	 * Test adding contributors metabox.
	 */
	public function test_add_contributors_metabox() {
		// Trigger the hook manually.
		do_action( 'add_meta_boxes' );

		global $wp_meta_boxes;
		$this->assertArrayHasKey( 'post', $wp_meta_boxes );
		$this->assertArrayHasKey( 'side', $wp_meta_boxes['post'] );
		$this->assertArrayHasKey( 'high', $wp_meta_boxes['post']['side'] );

		$found = false;
		foreach ( $wp_meta_boxes['post']['side']['high'] as $metabox ) {
			if ( 'post_contributors' === $metabox['id'] ) {
				$found = true;
				break;
			}
		}

		$this->assertTrue( $found, 'Contributors metabox not registered.' );
	}

	/**
	 * Test saving contributors.
	 */
	public function test_save_contributors_metabox() {
		$post_id = self::factory()->post->create();

		// Now create a user and set as current
		$user_id = self::factory()->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $user_id );

		// Fake a $_POST request.
		$_POST['_wpnonce']          = wp_create_nonce( 'update-post_' . $post_id );
		$_POST['post_contributors'] = array( 1, 2, 3 );

		if ( function_exists( 'set_current_screen' ) ) {
			set_current_screen( 'post' );
		}

		$this->contributors_metabox = new \WPContributors\Admin\ContributorsMetabox();

		// Directly call save method instead of add_action
		$this->contributors_metabox->save_contributors_metabox( $post_id );

		// Refresh post meta cache.
		clean_post_cache( $post_id );

		// Fetch saved meta.
		$saved_contributors = get_post_meta( $post_id, '_post_contributors', true );

		// Assert
		$this->assertIsArray( $saved_contributors );
		$this->assertEquals( array( 1, 2, 3 ), $saved_contributors );
	}
	
	/**
	 * Test saving contributors with no contributors selected.
	 */
	public function test_save_no_contributors() {
		$post_id = self::factory()->post->create();
		
		// Now create a user
		$user_id = self::factory()->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $user_id );
	
		// First save contributors.
		update_post_meta( $post_id, '_post_contributors', array( 1, 2 ) );
	
		// Fake a $_POST request without 'post_contributors'.
		$_POST['_wpnonce'] = wp_create_nonce( 'update-post_' . $post_id );
		unset( $_POST['post_contributors'] );
	
		$this->contributors_metabox = new \WPContributors\Admin\ContributorsMetabox();
		$this->contributors_metabox->save_contributors_metabox( $post_id );
	
		clean_post_cache( $post_id );
	
		$saved_contributors = get_post_meta( $post_id, '_post_contributors', true );
	
		// Since delete_post_meta() leads to empty string
		$this->assertSame( '', $saved_contributors );
	}
	


}
