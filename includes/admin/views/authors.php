<?php
/**
 * Metabox Author View .
 *
 * @package WPContributors
 */

// Prevent direct access.
defined( 'ABSPATH' ) || exit; ?>

<div class="posttypediv editor-post-taxonomies__hierarchical-terms-list">
	<div class="tabs-panel">
		<ul>
			<?php foreach ( $authors as $author ) { ?>
				<li>
					<label>
						<input 
							type="checkbox" 
							name="post_contributors[]" 
							value="<?php echo esc_attr( $author->ID ); ?>" 
							<?php esc_attr( checked( in_array( $author->ID, $saved_contributors, true ) ) ); ?>> 
							<?php echo esc_html( $author->display_name ); ?>
					</label>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
