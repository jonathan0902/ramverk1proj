<?php
    $posts = isset($posts) ? $posts : null;
    $users = isset($users) ? $users : null;
    $app = isset($app) ? $app : null;
    $tags = isset($tags) ? $tags : null;
    $comments = isset($comments) ? $comments : null;

$default = "http://www.buskerbrownes.com/wp-content/uploads/2013/06/gravatar-60-grey.jpg";
$size = 40;
?>
<?php foreach ($users as $user) : ?>
    <?php if ($app == $user->username) : ?>
        <div class="col-md-12 text-center re">
            <img class="img-circ" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->gravatar))) . "?d=" . urlencode($default) . "&s=80"; ?>">
            <p class="mention">@<?= $user->username?></p>
            <a href="/dbwebb/ramverk1/me/kmom10/htdocs/user/update/<?= $this->di->get("session")->get("id"); ?>">Update Your Profile</a>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<table>
<?php foreach ($posts as $post) : ?>
    <?php if ($app == $post->username) : ?>
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
                                <?php foreach ($tags as $tag) : ?>
                                    <?php if ($tag->sub == $post->id) :?>
                                        <a class="tags" href="">#<?= $tag->tag ?></a>
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
        </div>
    <?php endif; ?>
<?php endforeach; ?>
    </div>
</table>
</div>
