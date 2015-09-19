<?php if( $primary_tag ): ?>
<div class="primary-tag">
    <?php
    /*
     * Escape to protect against cross-site scripting.
     *
     * $primary_tag is also sanitized at time of input, but
     * sanitize_text_field() provides more protection since a tag should never
     * contain HTML.
     */
    ?>
    <?php echo sanitize_text_field($primary_tag) ?>
</div>
<?php endif ?>