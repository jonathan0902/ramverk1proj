<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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
                "legend" => "",
                "class" => "col-md-4 offset-md-4 form"
            ],
            [
                "username" => [
                    "type"        => "text",
                    "class" => "form-control"
                ],

                "firstname" => [
                    "type"        => "text",
                    "class" => "form-control"
                ],

                "lastname" => [
                    "type"        => "text",
                    "class" => "form-control"
                ],
                        
                "password" => [
                    "type"        => "password",
                    "class" => "form-control"
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                    "class" => "form-control"
                ],

                "gravatar" => [
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
        $firstname      = $this->form->value("firstname");
        $lastname      = $this->form->value("lastname");
        $gravatar      = $this->form->value("gravatar");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Save to database
        $db = $this->di->get("dbqb");
        $db->connect()
            ->insert("User", ["username", "firstname", "lastname", "gravatar", "password"])
            ->execute([$username, $firstname, $lastname, $gravatar, $password]);

        $this->form->addOutput("User was created.");
        return true;
    }
}
