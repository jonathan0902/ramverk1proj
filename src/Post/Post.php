<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-12-21
 * Time: 23:30
 */

namespace Anax\Post;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Post extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "post";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $username;
    public $id;
    public $message;
    public $datum;
}
