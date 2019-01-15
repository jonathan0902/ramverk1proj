<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-23
 * Time: 13:44
 */

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Post\Users;

class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "",
                "class" => "col-md-4 offset-md-4 form"
            ],
            [
                "id" => [
                    "type"        => "hidden",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id
                ],
                "username" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->username,
                    "class" => "form-control"
                ],

                "firstname" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->firstname,
                    "class" => "form-control"
                ],

                "lastname" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->lastname,
                    "class" => "form-control"
                ],

                "gravatar" => [
                    "type"        => "text",
                    "value" => $user->gravatar,
                    "class" => "form-control"

                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "btn btn-success",
                ],
                "reset" => [
                    "type"      => "reset",
                    "class" => "btn btn-secondary"
                ],
            ]
        );
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Users
     */
    public function getItemDetails($id) : object
    {
        $user = new Users();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $user = new Users();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));
        $user->username = $this->form->value("username");
        $user->firstname = $this->form->value("firstname");
        $user->lastname = $this->form->value("lastname");
        $user->gravatar = $this->form->value("gravatar");
        $user->save();
        return true;
    }
}
