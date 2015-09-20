<?php
/**
 * Renders the primary tag to the page.
 *
 * @package NeedBee\Primary_Tag
 */

?>
<?php if ( $data['primary_tag'] ) : ?>
<div class="primary-tag-container">
	<span class="screen-reader-text">Primary Tag</span>
	<?php

	/*
	 * Escape to protect against cross-site scripting.
	 */
	?>
	<a href="<?php echo esc_url( site_url( 'tag/'.$data['primary_tag']->slug.'/' ) ) ?>" class="primary-tag" rel="tag">
	<?php echo esc_html( $data['primary_tag']->name ) ?>
	</a>
</div>
<?php endif ?>
