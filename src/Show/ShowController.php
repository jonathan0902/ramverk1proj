<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-24
 * Time: 17:55
 */

namespace Anax\Show;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Post\Post;
use Anax\Post\Users;
use Anax\Post\TotalTags;
use Anax\Post\Tags;
use Anax\Post\Comments;

class ShowController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function userActionGet($app) : object
    {
        $page = $this->di->get("page");
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        $users = new Users();
        $users->setDb($this->di->get("dbqb"));
        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));
        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));

        $page->add("show/index", [
            "posts" => $post->findAll(),
            "users" => $users->findAll(),
            "tags" => $tag->findAll(),
            "comments" => $comments->findAll(),
            "app" => $app
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function tagsActionGet() : object
    {
        $page = $this->di->get("page");
        $tags = new TotalTags();
        $tags->setDb($this->di->get("dbqb"));

        $page->add("show/tags", [
            "tags" => $tags->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function tagActionGet($get) : object
    {
        $page = $this->di->get("page");
        $tag = new Tags();
        $post = new Post();
        $comments = new Comments();
        $users = new Users();
        $tag->setDb($this->di->get("dbqb"));
        $post->setDb($this->di->get("dbqb"));
        $comments->setDb($this->di->get("dbqb"));
        $users->setDb($this->di->get("dbqb"));

        $page->add("show/tag", [
            "tag" => $tag->findAll(),
            "posts" => $post->findAll(),
            "comments" => $comments->findAll(),
            "users" => $users->findAll(),
            "current" => $get,
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
