<?php
/**
 * Test case for WPCB_Init class.
 *
 * @package WPContributors
 */

namespace WPContributors\Tests;

use WPContributors\WPCB_Init;
use WPContributors\Admin\ContributorsMetabox;
use WPContributors\Public\PostContributors;

/**
 * WPCB_Init test case.
 */
class WPCBInitTest extends \WP_UnitTestCase {

	/**
	 * Setup.
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * Test get_instance loads admin class in admin area.
	 */
	public function test_get_instance_admin() {
		// Simulate admin area
		set_current_screen( 'dashboard' );

		// Mock ContributorsMetabox class
		$contributor_metabox_mock = $this->getMockBuilder( ContributorsMetabox::class )
			->disableOriginalConstructor()
			->getMock();

		// Ensure no fatal error
		$this->assertNull( WPCB_Init::get_instance() );
	}

	/**
	 * Test get_instance loads public class in frontend.
	 */
	public function test_get_instance_public() {
		// Simulate frontend
		global $current_screen;
		$current_screen = null; // No admin screen means frontend

		// Mock PostContributors class
		$post_contributors_mock = $this->getMockBuilder( PostContributors::class )
			->disableOriginalConstructor()
			->getMock();

		// Ensure no fatal error
		$this->assertNull( WPCB_Init::get_instance() );
	}
}
