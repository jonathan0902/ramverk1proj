<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-21
 * Time: 23:26
 */

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$comments = isset($comments) ? $comments : null;
$users = isset($users) ? $users : null;
$tags = isset($tags) ? $tags : null;

$email = "jonathanh9826@gmail.com";
$default = "http://www.buskerbrownes.com/wp-content/uploads/2013/06/gravatar-60-grey.jpg";
$size = 40;
?>
<div class="container">
    <div class="makePost">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <a href="form/post"><button style="width: 100%;" class="btn btn-primary">Make a new Post</button></a>
            </div>
        </div>
    </div>
    <?php if (!$items) : ?>
        <p>There are no items to show.</p>
        <?php
        return;
    endif; ?>

    <table>
        <?php foreach ($items as $item) : ?>
        <tr class="table">
        <td>
        <div class="article">
            <div class="article-text">
                <div class="article-img">
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user->username == $item->username) :?>
                            <img class="img-circle" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->gravatar))) . "?d=" . urlencode($default) . "&s=" . $size; ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="text">
                    <a class="mention tiny" href="">@<?= $item->username ?></a>
                </div>
                <div class="text comment-text">
                    <span><?= $item->message ?></span>
                </div>
                <div class="tags-likes">
                    <div class="tag">
                        <?php foreach ($tags as $tag) : ?>
                            <?php if ($tag->sub == $item->id) :?>
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
                            <a class="comhref" href="form/comment/<?= $item->id ?>">
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
                <?php if ($comment->sub == $item->id) : ?>
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
                                <a class="" href="form/comment/<?= $item->id ?>"><button class="btn">Svara</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </td>
            </tr>
        </div>
        <?php endforeach; ?>
    </div>
</table>
</div>
