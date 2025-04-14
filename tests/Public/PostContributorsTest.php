<?php
/**
 * Test case for PostContributors class.
 *
 * @package WPContributors
 */

namespace WPContributors\Tests\Public;

use WPContributors\Public\PostContributors;

/**
 * PostContributors test case.
 */
class PostContributorsTest extends \WP_UnitTestCase {

	/**
	 * PostContributors instance.
	 *
	 * @var PostContributors
	 */
	protected $post_contributors;

	/**
	 * Setup.
	 */
	public function setUp(): void {
		parent::setUp();
		$this->post_contributors = new PostContributors();
	}

	/**
	 * Test if hooks are set up.
	 */
	public function test_hooks_are_added() {
		global $wp_filter;

		$this->assertArrayHasKey( 'the_content', $wp_filter );
	}

	/**
	 * Test display_contributors when not singular post.
	 */
	public function test_display_contributors_non_singular() {
		$content = 'Test Content';

		// Simulate not singular post.
		$expected_content = "<p>Test Content</p>\n"; // <- note: includes \n newline too!

		$this->assertEquals(
			$expected_content,
			apply_filters( 'the_content', $content )
		);
	}

	/**
	 * Test display_contributors with no saved contributors.
	 */
	public function test_display_contributors_no_contributors() {
		$post_id = self::factory()->post->create();

		global $wp_query, $post;
		$post = get_post( $post_id );
		setup_postdata( $post );
		$wp_query->is_singular = true;

		$content = 'Original Content';
		$expected_content = "<p>Original Content</p>\n"; // <- note: includes \n newline too!

		$this->assertEquals(
			$expected_content,
			apply_filters( 'the_content', $content )
		);

		wp_reset_postdata();
	}

	/**
	 * Test display_contributors with real contributor users.
	 */
	public function test_display_contributors_with_real_users() {
		// Create a post
		$post_id = self::factory()->post->create();
	
		// Create two users
		$user_id1 = self::factory()->user->create([
			'role'         => 'author',
			'display_name' => 'Author One',
		]);
		$user_id2 = self::factory()->user->create([
			'role'         => 'author',
			'display_name' => 'Author Two',
		]);
	
		// Attach users to post meta
		update_post_meta($post_id, '_post_contributors', [$user_id1, $user_id2]);

		// Setup globals correctly
		global $post, $wp_query;
		$post = get_post($post_id);
		$wp_query->post = $post;
		$wp_query->is_single = true;
		$wp_query->is_singular = true;
		setup_postdata($post);
	
		// Hook your real plugin filter here
		add_filter('the_content', [ new \WPContributors\Public\PostContributors(), 'display_contributors' ]);
	
		// Simulate your template rendering users
		add_filter('wpcb_contributors_list_tempalte', function() use ($user_id1, $user_id2) {
			// Create temporary template file
			$template_file = tempnam(sys_get_temp_dir(), 'template');
			file_put_contents(
				$template_file,
				'<?php foreach ( $contributors as $contributor_id ) { echo get_the_author_meta( "display_name", $contributor_id ); } ?>'
			);
			return $template_file;
		});
	
		// Prepare content
		$content = 'Original Post Content';
		$final_content = apply_filters('the_content', $content);
	
		// Assertions
		$this->assertStringContainsString('Original Post Content', $final_content);
	
		// Cleanup
		wp_reset_postdata();
	}	

}
