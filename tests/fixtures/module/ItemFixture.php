<?php
/**
 * ItemFixture.php
 */
namespace tests\fixtures\module;
use tests\fixtures\ActiveFixture;

/**
 * Class ItemFixture
 * @package tests\fixtures\module
 */
class ItemFixture extends ActiveFixture
{
    public $modelClass = 'PrivateIT\modules\mailQueue\models\Item';
}
