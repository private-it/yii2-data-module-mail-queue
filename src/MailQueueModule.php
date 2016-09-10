<?php
/**
 * Created by ERDConverter
 */
namespace PrivateIT\modules\mailQueue;

use PrivateIT\modules\mailQueue\models\Item;
use PrivateIT\modules\mailQueue\models\Log;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\console\Application;
use yii\helpers\StringHelper;
use yii\helpers\Inflector;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class MailQueueModule
 *
 * @package PrivateIT\modules\mailQueue
 */
class MailQueueModule extends Module implements BootstrapInterface
{
    /**
     * Table prefix for ActiveRecord tables
     * @var string|array|callable
     */
    public $tablePrefix = 'mail_queue_';

    /**
     * Custom table name for ActiveRecord by className
     * @var array
     */
    public $tableNames = [];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@PrivateIT/modules/mailQueue', __DIR__);
        if ($app instanceof Application) {
            $this->controllerNamespace = 'PrivateIT\modules\mailQueue\commands';
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['mail-queue/*'])) {
            Yii::$app->i18n->translations['mail-queue/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }

    /**
     * @return string
     */
    static function id()
    {
        return Inflector::slug(__NAMESPACE__);
    }

    /**
     * @return string
     */
    public static function getInstance()
    {
        /** @var static $module */
        if (!Yii::$app->hasModule(static::id())) {
            Yii::$app->setModule(static::id(), [
                'class' => static::className()
            ]);
        }
        return Yii::$app->getModule(static::id());
    }

    /**
     * @param string|ActiveRecord $class
     * @return string
     */
    public static function tableName($class)
    {
        /** @var static $module */
        $module = static::getInstance();

        if (array_key_exists($class::className(), $module->tableNames)) {
            return $module->tableNames[$class::className()];
        }

        if (is_callable($module->tablePrefix)) {
            $tableName = call_user_func($module->tablePrefix, $class);
            if ($tableName) {
                return $tableName;
            }
        }

        $tableName = Inflector::camel2id(StringHelper::basename($class), '_');
        return '{{%' . $module->tablePrefix . $tableName . '}}';
    }

    /**
     * @param string $uniqueName
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $view
     * @param ActiveRecord[]|array $data
     * @return Item
     */
    public function addItem($uniqueName, $subject, $from, $to, $view, $data)
    {
        $item = Item::find()->andWhere(['name' => $uniqueName])->one();
        if (!$item) {
            $item = new Item([
                'name' => $uniqueName,
                'subject' => $subject,
                'from' => $from,
                'to' => $to,
                'view' => $view,
                'status' => Item::STATUS_ACTIVE
            ]);
            $params = [];
            foreach ($data as $varName => $callbackData) {
                if ($callbackData instanceof ActiveRecord) {
                    $params[$varName] = [
                        [get_class($callbackData), 'findOne'], [$callbackData->id]
                    ];
                } else {
                    $params[$varName] = $callbackData;
                }
            }
            $item->setData(json_encode($params));
            $item->save(false);
        }
        return $item;
    }

    /**
     * @param Item $item
     * @return bool
     * @throws \Exception
     */
    public function runItem($item)
    {
        $log = new Log([
            'item_id' => $item->id
        ]);

        try {
            if (
            Yii::$app->mailer
                ->compose($item->view, $this->prepareData($item->data))
                ->setFrom($item->from)
                ->setTo($item->to)
                ->setSubject($item->subject)
                ->send()
            ) {

                $log->setStatus(Log::STATUS_SUCCESS);
                $log->setInfo('Success!');
                $log->save(false);
                $item->setStatus(Item::STATUS_ARCHIVED);
                $item->save(false);
                return true;

            } else {

                $log->setStatus(Log::STATUS_ERROR);
                $log->setInfo('Не удалось отправить');
                $log->save(false);
                $item->setStatus(Item::STATUS_DELETED);
                $item->save(false);
                return false;

            }
        } catch (\Exception $e) {

            $log->setStatus(Log::STATUS_ERROR);
            $log->setInfo($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            $log->save(false);
            $item->setStatus(Item::STATUS_DELETED);
            $item->save(false);

            throw $e;

        }
    }

    /**
     * @param string $data
     * @return array
     */
    private function prepareData($data)
    {
        $params = [];
        if (!is_array($data)) {
            $data = json_decode($data);
        }
        foreach ($data as $name => $item) {
            if (is_array($item)) {
                $params[$name] = call_user_func_array($item[0], $item[1]);
            } else {
                $params[$name] = $item;
            }
        }
        return $params;
    }
}