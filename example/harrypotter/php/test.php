<div class="test-php">
    <p><?= get_field('title') ? get_field('title') : 'no title'; ?></p>
    <p><?= get_field('title') ? get_field('subtitle') : 'no subtitle'; ?></p>
    <hr>
    <!-- We can use inner blocks add a block within this block -->
    <!-- Note: JSX is true in block.json for use with inner blocks -->
    <b>Inner Blocks</b>
    <p>Note: you can add a inner block to this block<p>
    <InnerBlocks />
</div>