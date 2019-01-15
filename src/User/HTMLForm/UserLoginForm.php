<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use phpDocumentor\Reflection\Location;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "id" => __CLASS__
            ],
            [
                "user" => [
                    "type"        => "text",
                    "class"        => "logininput",
                    //"description" => "Here you can place a description.",
                    "placeholder" => "Username",
                ],
                        
                "password" => [
                    "type"        => "password",
                    "class"        => "logininput",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                    "placeholder" => "*********",
                ],

                "submit" => [
                    "type" => "submit",
                    "class" => "btn btn-outline",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
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
        $username      = $this->form->value("user");
        $password      = $this->form->value("password");

        // Try to login
        $db = $this->di->get("dbqb");
        $db->connect();
        $user = $db->select("password, id")
            ->from("user")
            ->where("username = ?")
            ->execute([$username])
            ->fetch();

        // $user is null if user is not found
        if (!$user || $password != $user->password) {
            $this->form->rememberValues();
            $this->form->addOutput("<div class='danger-warning'>Username or password did not match.</div>");
            return false;
        }

        $this->di->get("session")->set("access", true);
        $this->di->get("session")->set("user", $username);
        $this->di->get("session")->set("id", $user->id);
        return true;
    }
}
