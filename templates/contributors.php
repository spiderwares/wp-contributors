<?php
/**
 * Contributors box template.
 *
 * @package WPContributors
 */

// Prevent direct access.
defined( 'ABSPATH' ) || exit;

if ( empty( $contributors ) || ! is_array( $contributors ) ) {
	return;
} ?>

<div class="contributors">
	<h3><?php esc_html_e( 'Contributors', 'wp-contributors' ); ?></h3>

	<div >
		<ul class="wp-block-post-template is-flex-container is-flex-container columns-2">
			<?php foreach ( $contributors as $contributor ) { ?>
				<?php
				$user = get_userdata( $contributor );
				if ( ! $user ) {
					continue;
				}
				$author_avatar = get_avatar( $user->ID, 52 );
				?>

				<li class="is-layout-flex">
					<div class="wp-block-avatar">
						<?php echo wp_kses_post( $author_avatar ); ?>
					</div>
					<div class="wp-block-comment-author-name">
						<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
							<?php echo esc_html( $user->display_name ); ?>
						</a>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
