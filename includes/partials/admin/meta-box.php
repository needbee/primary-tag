<div id="primary-tag">
    <select name="primary_tag">
        <option value="">(none)</option>
        <?php foreach( $tags as $tag ): ?>
            <option value="<?php echo $tag->name ?>" <?php if( $tag->name == $primary_tag ) { echo 'selected'; } ?>><?php echo $tag->name ?></option>
        <?php endforeach ?>
    </select>
</div><!-- #primary-tag -->