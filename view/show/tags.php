<?php
$tags = isset($tags) ? $tags : null;
?>
<div class="container">
    <div class="col-md-12 text-center re">
        <h1>Tags</h1>
    </div>
    <div class="col-md-6 offset-md-3 re">
<?php foreach ($tags as $tag) : ?>
        <h4>
            <a class="" href="tag/<?= $tag->tag ?>">
                <?= $tag->count ?>
                #<?= $tag->tag ?>
            </a>
        </h4>
        <hr/>
<?php endforeach; ?>
    </table>
    </div>
</div>