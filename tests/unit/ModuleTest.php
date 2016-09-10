<?php
/**
 * ModuleTest.php
 */
namespace tests\unit;

use PrivateIT\modules\mailQueue\MailQueueModule;
use PrivateIT\modules\mailQueue\models\Item;
use PrivateIT\modules\mailQueue\models\Log;
use tests\DbTestCase;
use tests\fixtures\module\ItemFixture;
use tests\fixtures\module\LogFixture;

/**
 * Class ModuleTest
 * @package PrivateIT\modules\mailQueue\tests\unit
 */
class ModuleTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            ItemFixture::className(),
            LogFixture::className(),
        ];
    }

    public function testFirstSend()
    {
        /** @var MailQueueModule $mailQueue */
        $mailQueue = \Yii::$app->getModule('mailQueue');
        $item = $mailQueue->addItem('test-name', 'Test subject!', 'from@private-it.ru', 'to@private-it.ru', 'test/view-1', [
            'item' => Item::find()->one(),
            'origin' => [[Item::className(), 'findOne'], [1]]
        ]);

        $this->assertInstanceOf(Item::className(), $item);
        $this->assertEquals(1, $item->id);

        $item = Item::findOne(1);
        $this->assertEquals('test-name', $item->name);
        $this->assertEquals('Test subject!', $item->subject);
        $this->assertEquals('from@private-it.ru', $item->from);
        $this->assertEquals('to@private-it.ru', $item->to);
        $this->assertEquals('test/view-1', $item->view);
        $this->assertEquals('{"item":[["PrivateIT\\\modules\\\mailQueue\\\models\\\Item","findOne"],[10000]],"origin":[["PrivateIT\\\modules\\\mailQueue\\\models\\\Item","findOne"],[1]]}', $item->data);

        $logCounter = Log::find()->count();
        $this->assertTrue($mailQueue->runItem($item));
        $this->assertEquals($logCounter + 1, Log::find()->count());
    }

    public function testExceptionSend()
    {
        /** @var MailQueueModule $mailQueue */
        $mailQueue = \Yii::$app->getModule('mailQueue');
        $item = $mailQueue->addItem('test-exception-1', 'Test subject!', 'from', 'to', 'exception', [
            'item' => Item::find()->one(),
            'origin' => [[Item::className(), 'findOne'], [1]]
        ]);

        $logCounter = Log::find()->count();
        $e = null;
        try {
            $mailQueue->runItem($item);
        } catch (\Exception $e) {
        }
        $this->throwException($e);
        $this->assertContains('The view file does not exist', $e->getMessage());
        $this->assertEquals($logCounter + 1, Log::find()->count());

        /** @var MailQueueModule $mailQueue */
        $mailQueue = \Yii::$app->getModule('mailQueue');
        $item = $mailQueue->addItem('test-exception-2', 'Test subject!', 'from', 'to', 'test/view-1', [
            'item' => Item::find()->one(),
            'origin' => [[Item::className(), 'findOne'], [1]]
        ]);

        $logCounter = Log::find()->count();
        $e = null;
        try {
            $mailQueue->runItem($item);
        } catch (\Exception $e) {
        }
        $this->throwException($e);
        $this->assertEquals('Address in mailbox given [from] does not comply with RFC 2822, 3.6.2.', $e->getMessage());
        $this->assertEquals($logCounter + 1, Log::find()->count());
    }
}
