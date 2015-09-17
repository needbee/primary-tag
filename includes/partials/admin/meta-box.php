<div id="primary-tag">
    <select>
        <option>(none)</option>
        <?php foreach( $tags as $tag ): ?>
            <option><?php echo $tag->name ?></option>
        <?php endforeach ?>
    </select>
</div><!-- #primary-tag -->