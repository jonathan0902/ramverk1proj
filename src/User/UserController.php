<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\UpdateUserForm;
use Anax\Post\Post;
use Anax\Post\Comments;
use Anax\Post\Users;
use Anax\Post\Tags;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
    public function indexActionGet()
    {
        $page = $this->di->get("page");
        $post = new Post();
        $comments = new Comments();
        $users = new Users();
        $tags = new Tags();
        $post->setDb($this->di->get("dbqb"));
        $comments->setDb($this->di->get("dbqb"));
        $users->setDb($this->di->get("dbqb"));
        $tags->setDb($this->di->get("dbqb"));

        $page->add("feed/index", [
            "items" => $post->findAll(),
            "comments" => $comments->findAll(),
            "users" => $users->findAll(),
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
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("login/login", [
            "content" => $form->getHTML(),
        ]);

        $url = explode('/', $_SERVER['REQUEST_URI']);
        if ($this->di->get("session")->get("access") && $url[count($url) - 1] = "login") {
            header('Refresh: 0, url = ../');
        }

        return $page->render([
            "title" => "A login page",
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
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("login/create", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id)
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("login/update", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
