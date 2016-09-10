<?php
/**
 * LogFixture.php
 */
namespace tests\fixtures\module;
use tests\fixtures\ActiveFixture;

/**
 * Class LogFixture
 * @package tests\fixtures\module
 */
class LogFixture extends ActiveFixture
{
    public $modelClass = 'PrivateIT\modules\mailQueue\models\Log';
}
