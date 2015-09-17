<div id="primary-tag">
    <?php if( empty($tags) ): ?>
        To set a primary tag, first add tags and save the post.
    <?php else: ?>
        <select name="primary_tag">
            <option value="">(none)</option>
            <?php foreach( $tags as $tag ): ?>
                <option value="<?php echo $tag->name ?>" <?php if( $tag->name == $primary_tag ) { echo 'selected'; } ?>><?php echo $tag->name ?></option>
            <?php endforeach ?>
        </select>
    <?php endif ?>
</div><!-- #primary-tag -->