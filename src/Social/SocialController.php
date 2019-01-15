<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-24
 * Time: 17:55
 */

namespace Anax\Social;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Social\HTMLForm\CreatePostForm;
use Anax\Social\HTMLForm\CreateCommentForm;

class SocialController implements ContainerInjectableInterface
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
    public function postAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreatePostForm($this->di);
        $form->check();

        $page->add("social/post", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function commentAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new CreateCommentForm($this->di, $id);
        $form->check();

        $page->add("social/comment", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }
}
