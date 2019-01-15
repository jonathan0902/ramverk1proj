<?php

namespace Anax\Social\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Post\Post;

/**
 * Example of FormModel implementation.
 */
class CreatePostForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Post",
                "class" => "col-md-4 offset-md-4 form"
            ],
            [
                "username" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $this->di->get("session")->get("user"),
                    "class" => "form-control"
                ],

                "message" => [
                    "type"        => "textarea",
                    "class" => "form-control"
                ],

                "tags" => [
                    "type"        => "text",
                    "class" => "form-control"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "btn btn-success"
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $username      = $this->form->value("username");
        $message       = $this->form->value("message");
        $tags      = $this->form->value("tags");
        $data = 0;

        $post = new Post();
        $post->setDb($this->di->get("dbqb"));

        foreach ($post->findAll() as $number) {
            if ($number->id > $data) {
                $data = $number->id;
            }
        }

        $data = $data + 1;

        // Save to database
        $db = $this->di->get("dbqb");
        $db->connect()
            ->insert("post", ["username", "message"])
            ->execute([$username, $message]);

        $pieces = explode(" ", $tags);

        for ($i = 0; $i < count($pieces); $i++) {
            // Save to database
            $db = $this->di->get("dbqb");
            $db->connect()
                ->insert("tags", ["tag", "sub"])
                ->execute([$pieces[$i], $data]);
        }

        return true;
    }
}
