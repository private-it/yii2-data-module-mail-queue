<?php
/**
 * Created by ERDConverter
 */

use yii\db\Schema;
use yii\db\Migration;

/**
 * m160910_062656_001_create_log
 *
 */
class m160910_062656_001_create_log extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(\PrivateIT\modules\mailQueue\models\Log::tableName(), [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->defaultValue(0),
            'info' => $this->text()->defaultValue(""),
            'status' => $this->integer()->defaultValue(0),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultValue(null),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(\PrivateIT\modules\mailQueue\models\Log::tableName());
    }
}