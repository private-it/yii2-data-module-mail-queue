<?php
/**
 * Created by ERDConverter
 */
namespace PrivateIT\modules\mailQueue\models;

use PrivateIT\modules\mailQueue\MailQueueModule;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Log
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $info
 * @property integer $status
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Item $item
 */
class Log extends ActiveRecord
{
    const STATUS_ERROR = -1;
    const STATUS_SUCCESS = 1;

    /**
     * Get object statuses
     *
     * @return array
     */
    static function getStatuses()
    {
        return [
            static::STATUS_ERROR => Yii::t('mail-queue/log', 'const.status_error'),
            static::STATUS_SUCCESS => Yii::t('mail-queue/log', 'const.status_success'),
        ];
    }

    /**
     * @inheritdoc
     * @return query\LogActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return MailQueueModule::tableName(__CLASS__);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => TimestampBehavior::className(),
            'value' => new Expression('NOW()'),
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mail-queue/log', 'label.id'),
            'item_id' => Yii::t('mail-queue/log', 'label.item_id'),
            'info' => Yii::t('mail-queue/log', 'label.info'),
            'status' => Yii::t('mail-queue/log', 'label.status'),
            'updated_at' => Yii::t('mail-queue/log', 'label.updated_at'),
            'created_at' => Yii::t('mail-queue/log', 'label.created_at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'id' => Yii::t('mail-queue/log', 'hint.id'),
            'item_id' => Yii::t('mail-queue/log', 'hint.item_id'),
            'info' => Yii::t('mail-queue/log', 'hint.info'),
            'status' => Yii::t('mail-queue/log', 'hint.status'),
            'updated_at' => Yii::t('mail-queue/log', 'hint.updated_at'),
            'created_at' => Yii::t('mail-queue/log', 'hint.created_at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributePlaceholders()
    {
        return [
            'id' => Yii::t('mail-queue/log', 'placeholder.id'),
            'item_id' => Yii::t('mail-queue/log', 'placeholder.item_id'),
            'info' => Yii::t('mail-queue/log', 'placeholder.info'),
            'status' => Yii::t('mail-queue/log', 'placeholder.status'),
            'updated_at' => Yii::t('mail-queue/log', 'placeholder.updated_at'),
            'created_at' => Yii::t('mail-queue/log', 'placeholder.created_at'),
        ];
    }

    /**
     * Get value from Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value to Id
     *
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Get value from ItemId
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set value to ItemId
     *
     * @param $value
     * @return $this
     */
    public function setItemId($value)
    {
        $this->item_id = $value;
        return $this;
    }

    /**
     * Get value from Info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set value to Info
     *
     * @param $value
     * @return $this
     */
    public function setInfo($value)
    {
        $this->info = $value;
        return $this;
    }

    /**
     * Get value from Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set value to Status
     *
     * @param $value
     * @return $this
     */
    public function setStatus($value)
    {
        $this->status = $value;
        return $this;
    }

    /**
     * Get value from UpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set value to UpdatedAt
     *
     * @param $value
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        $this->updated_at = $value;
        return $this;
    }

    /**
     * Get value from CreatedAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set value to CreatedAt
     *
     * @param $value
     * @return $this
     */
    public function setCreatedAt($value)
    {
        $this->created_at = $value;
        return $this;
    }

    /**
     * Get relation Item
     *
     * @param string $class
     * @return query\ItemActiveQuery
     */
    public function getItem($class = '\Item')
    {
        return $this->hasOne(static::findClass($class, __NAMESPACE__), ['id' => 'item_id']);
    }

}
