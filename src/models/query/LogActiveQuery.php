<?php
/**
 * Created by ERDConverter
 */
namespace PrivateIT\modules\mailQueue\models\query;

use PrivateIT\modules\mailQueue\models\Log;

/**
 * LogActiveQuery
 *
 */
class LogActiveQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Log[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Log|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /*
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }
    */
}
