<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2019-01-06
 * Time: 18:39
 */

$tag = isset($tag) ? $tag : null;
$posts = isset($posts) ? $posts : null;
$comments = isset($comments) ? $comments : null;
$users = isset($users) ? $users : null;

$email = "jonathanh9826@gmail.com";
$default = "http://www.buskerbrownes.com/wp-content/uploads/2013/06/gravatar-60-grey.jpg";
$size = 40;

?>
<div class="container">
    <div class="col-md-12 text-center re">
        <h2>#<?= $current ?></h2>
    </div>
    <table>
<?php foreach ($tag as $tags) : ?>
    <?php if ($tags->tag == $current) : ?>
        <?php foreach ($posts as $post) : ?>
            <?php if ($tags->sub == $post->id && $tags->tag == $current) : ?>
                <tr class="table">
                    <td>
                        <div class="article">
                            <div class="article-text">
                                <div class="article-img">
                                    <?php foreach ($users as $user) : ?>
                                        <?php if ($user->username == $post->username) :?>
                                            <img class="img-circle" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->gravatar))) . "?d=" . urlencode($default) . "&s=" . $size; ?>">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="text">
                                    <a class="mention tiny" href="">@<?= $post->username ?></a>
                                </div>
                                <div class="text comment-text">
                                    <span><?= $post->message ?></span>
                                </div>
                                <div class="tags-likes">
                                    <div class="tag">
                                        <?php foreach ($tag as $tags) : ?>
                                            <?php if ($tags->sub == $post->id) :?>
                                                <a class="tags" href="">#<?= $tags->tag ?></a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tags-likes">
                                <div class="row">
                                    <div class="col-md-12 text-center ta">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-center ba">
                                        <a class="comhref" href="">
                                            <img src="/dbwebb/ramverk1/me/kmom10/htdocs/img/heart.png">
                                            <span class="btn fakebtn">Gilla</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-center ba">
                                        <a class="comhref" href="form/comment/<?= $post->id ?>">
                                            <img src="/dbwebb/ramverk1/me/kmom10/htdocs/img/heart.png">
                                            <span class="btn fakebtn">Svara</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center ta">
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($comments as $comment) : ?>
                                <?php if ($comment->sub == $post->id) : ?>
                                    <div class="article-text-arc">
                                        <div class="article-img">
                                            <?php foreach ($users as $user) : ?>
                                                <?php if ($user->username == $comment->fromwho) :?>
                                                    <img class="img-circle" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->gravatar))) . "?d=" . urlencode($default) . "&s=" . $size; ?>">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="text">
                                            <a class="mention tiny" href="">@<?= $comment->fromwho ?></a>
                                        </div>
                                        <div class="text comment-text">
                                            <a class="mention" href="">@<?= $comment->receiver ?></a>
                                            <span><?= $comment->message ?></span>
                                        </div>
                                        <div class="tags-likes">
                                            <div class="tag">

                                            </div>
                                            <div class="likes">
                                                <div class="like">
                                                    <a class="" href="form/comment/<?= $post->id ?>"><button class="btn">Svara</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
    </table>
</div>