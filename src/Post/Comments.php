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
class Comments extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $fromwho;
    public $receiver;
    public $message;
    public $sub;
    public $datum;
}
