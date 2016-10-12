<?php
/**
 * ServiceCmdController.php
 */
namespace PrivateIT\modules\mailQueue\commands;

use PrivateIT\modules\mailQueue\MailQueueModule;
use PrivateIT\modules\mailQueue\models\Item;
use yii\console\Controller;

/**
 * Class ServiceCmdController
 * @package PrivateIT\modules\mailQueue\commands
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        // clear duplicates
        Item::deleteAll([
            'AND',
            [
                'status' => Item::STATUS_ACTIVE,
            ],
            [
                'NOT IN', 'id',
                Item::find()
                    ->groupBy('name')
                    ->select('MIN(id)')
                    ->andWhere([
                        'status' => Item::STATUS_ACTIVE
                    ])
            ]
        ]);
        $items = Item::find()->andWhere(['status' => Item::STATUS_ACTIVE])->each();
        foreach ($items as $item) {
            /** @var MailQueueModule $mailQueue */
            $mailQueue = \Yii::$app->getModule('mailQueue');
            try {
                $mailQueue->runItem($item);
            } catch (\Exception $e) {
                echo $e->getMessage();
                echo PHP_EOL;
                echo $e->getTraceAsString();
                echo PHP_EOL . PHP_EOL;
            }
        }
    }
}
