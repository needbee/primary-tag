<div id="primary-tag">
	<select name="primary_tag">
		<option value="">(none)</option>
		<?php foreach ( $data['tags'] as $tag ) :  ?>
		<option value="<?php echo esc_attr( $tag->name ) ?>" <?php if ( $tag->name === $data['primary_tag'] ) { echo 'selected'; } ?>>
			<?php
			/*
			 * Escape to protect against cross-site scripting.
			 *
			 * $primary_tag is also sanitized at time of input, but
			 * sanitize_text_field() provides more protection since a tag should never
			 * contain HTML.
			 */
			echo esc_html( sanitize_text_field( $tag->name ) );
			?>
		</option>
		<?php endforeach ?>
	</select>

	The primary tag will show at the top of the post page.
</div><!-- #primary-tag -->
