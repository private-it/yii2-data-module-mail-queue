<?php
/**
 * Created by ERDConverter
 */
namespace PrivateIT\modules\mailQueue\models\query;

use PrivateIT\modules\mailQueue\models\Item;

/**
 * ItemActiveQuery
 *
 */
class ItemActiveQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Item[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Item|array|null
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
