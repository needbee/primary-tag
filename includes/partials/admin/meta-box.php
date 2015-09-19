<div id="primary-tag">
	<select name="primary_tag">
		<option value="">(<?php esc_html_e('none') ?>)</option>
		<?php foreach ( $data['tags'] as $tag ) :  ?>
		<?php
		/*
		 * This page needs to operate only in terms of tag names, and ignore
		 * tag IDs. This allows the JS to keep the list of tags updated based
		 * only on the tag names that show up in the Tags meta box. Behind the
		 * scenes, these names are mapped back to IDs.
		 */
		?>
		<option value="<?php echo esc_attr( $tag->name ) ?>" <?php if ( false !== $data['primary_tag'] && ( $tag->name === $data['primary_tag']->name ) ) { echo 'selected'; } ?>>
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

	<?php esc_html_e('The primary tag will show at the top of the post page.') ?>
</div><!-- #primary-tag -->
