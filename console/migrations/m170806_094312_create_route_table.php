<?php

use yii\db\Migration;

/**
 * Handles the creation of table `route`.
 */
class m170806_094312_create_route_table extends Migration
{

    private $table = '{{%route}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'alias' => $this->string(255)->null(),
            'module' => $this->string(255)->notNull(),
            'controller' => $this->string(255)->notNull(),
            'model' => $this->string(255)->notNull(),
            'action' => $this->string(255)->notNull(),
            'element_id' => $this->integer()->null(),
            'parent_tree' => $this->string(255)->defaultValue('0'),
            'is_active' => $this->boolean()->defaultValue(true),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);
    }
}
