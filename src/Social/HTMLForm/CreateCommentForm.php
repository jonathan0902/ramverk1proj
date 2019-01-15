<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-24
 * Time: 18:39
 */

namespace Anax\Social\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Post\Post;

class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $post = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "",
                "class" => "col-md-4 offset-md-4 form"
            ],
            [
                "fromwho" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $this->di->get("session")->get("user"),
                    "class" => "form-control"
                ],

                "receiver" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $post->username,
                    "class" => "form-control"
                ],

                "message" => [
                    "type" => "textarea",
                    "class" => "form-control"
                ],

                "sub" => [
                    "type" => "number",
                    "validation" => ["not_empty"],
                    "value" => $post->id,
                    "readonly" => true,
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

    public function getItemDetails($id) : object
    {
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        $post->find("id", $id);
        return $post;
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
        $fromwho = $this->form->value("fromwho");
        $receiver = $this->form->value("receiver");
        $message = $this->form->value("message");
        $sub = $this->form->value("sub");

        // Save to database
        $db = $this->di->get("dbqb");
        $db->connect()
            ->insert("comments", ["fromwho", "receiver", "message", "sub"])
            ->execute([$fromwho, $receiver, $message, $sub]);

        return true;
    }
}
