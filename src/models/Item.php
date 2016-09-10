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
 * Item
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $subject
 * @property string $from
 * @property string $to
 * @property string $view
 * @property string $data
 * @property integer $status
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Log[] $logs
 */
class Item extends ActiveRecord
{
    const STATUS_ARCHIVED = -1;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Get object statuses
     *
     * @return array
     */
    static function getStatuses()
    {
        return [
            static::STATUS_ARCHIVED => Yii::t('mail-queue/item', 'const.status.archived'),
            static::STATUS_DELETED => Yii::t('mail-queue/item', 'const.status.deleted'),
            static::STATUS_ACTIVE => Yii::t('mail-queue/item', 'const.status.active'),
        ];
    }

    /**
     * @inheritdoc
     * @return query\ItemActiveQuery the newly created [[ActiveQuery]] instance.
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
            'id' => Yii::t('mail-queue/item', 'label.id'),
            'user_id' => Yii::t('mail-queue/item', 'label.user_id'),
            'name' => Yii::t('mail-queue/item', 'label.name'),
            'subject' => Yii::t('mail-queue/item', 'label.subject'),
            'from' => Yii::t('mail-queue/item', 'label.from'),
            'to' => Yii::t('mail-queue/item', 'label.to'),
            'view' => Yii::t('mail-queue/item', 'label.view'),
            'data' => Yii::t('mail-queue/item', 'label.data'),
            'status' => Yii::t('mail-queue/item', 'label.status'),
            'updated_at' => Yii::t('mail-queue/item', 'label.updated_at'),
            'created_at' => Yii::t('mail-queue/item', 'label.created_at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'id' => Yii::t('mail-queue/item', 'hint.id'),
            'user_id' => Yii::t('mail-queue/item', 'hint.user_id'),
            'name' => Yii::t('mail-queue/item', 'hint.name'),
            'subject' => Yii::t('mail-queue/item', 'hint.subject'),
            'from' => Yii::t('mail-queue/item', 'hint.from'),
            'to' => Yii::t('mail-queue/item', 'hint.to'),
            'view' => Yii::t('mail-queue/item', 'hint.view'),
            'data' => Yii::t('mail-queue/item', 'hint.data'),
            'status' => Yii::t('mail-queue/item', 'hint.status'),
            'updated_at' => Yii::t('mail-queue/item', 'hint.updated_at'),
            'created_at' => Yii::t('mail-queue/item', 'hint.created_at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributePlaceholders()
    {
        return [
            'id' => Yii::t('mail-queue/item', 'placeholder.id'),
            'user_id' => Yii::t('mail-queue/item', 'placeholder.user_id'),
            'name' => Yii::t('mail-queue/item', 'placeholder.name'),
            'subject' => Yii::t('mail-queue/item', 'placeholder.subject'),
            'from' => Yii::t('mail-queue/item', 'placeholder.from'),
            'to' => Yii::t('mail-queue/item', 'placeholder.to'),
            'view' => Yii::t('mail-queue/item', 'placeholder.view'),
            'data' => Yii::t('mail-queue/item', 'placeholder.data'),
            'status' => Yii::t('mail-queue/item', 'placeholder.status'),
            'updated_at' => Yii::t('mail-queue/item', 'placeholder.updated_at'),
            'created_at' => Yii::t('mail-queue/item', 'placeholder.created_at'),
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
     * Get value from UserId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set value to UserId
     *
     * @param $value
     * @return $this
     */
    public function setUserId($value)
    {
        $this->user_id = $value;
        return $this;
    }

    /**
     * Get value from Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value to Name
     *
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Get value from Subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set value to Subject
     *
     * @param $value
     * @return $this
     */
    public function setSubject($value)
    {
        $this->subject = $value;
        return $this;
    }

    /**
     * Get value from From
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set value to From
     *
     * @param $value
     * @return $this
     */
    public function setFrom($value)
    {
        $this->from = $value;
        return $this;
    }

    /**
     * Get value from To
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set value to To
     *
     * @param $value
     * @return $this
     */
    public function setTo($value)
    {
        $this->to = $value;
        return $this;
    }

    /**
     * Get value from View
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set value to View
     *
     * @param $value
     * @return $this
     */
    public function setView($value)
    {
        $this->view = $value;
        return $this;
    }

    /**
     * Get value from Data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set value to Data
     *
     * @param $value
     * @return $this
     */
    public function setData($value)
    {
        $this->data = $value;
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
     * Get relation Log[]
     *
     * @param string $class
     * @return query\LogActiveQuery
     */
    public function getLogs($class = '\Log')
    {
        return $this->hasMany(static::findClass($class, __NAMESPACE__), ['item_id' => 'id']);
    }

}
