<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-18
 * Time: 22:42
 */

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class LoginController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction()
    {
        return "Test";
    }
}
