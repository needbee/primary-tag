<?php if( $primary_tag ): ?>
<div class="primary-tag-container">
    <span class="screen-reader-text">Primary Tag</span>
    <?php
    /*
     * Escape to protect against cross-site scripting.
     *
     * $primary_tag is also sanitized at time of input, but
     * sanitize_text_field() provides more protection since a tag should never
     * contain HTML.
     */
    ?>
    <a href="<?php echo site_url('tags/'.$primary_tag.'/') ?>" class="primary-tag" rel="tag">
    <?php echo sanitize_text_field($primary_tag) ?>
    </a>
</div>
<?php endif ?>