<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin_menu_item`.
 */
class m170805_175707_create_admin_menu_item_table extends Migration
{
    private $table = '{{%admin_menu_item}}';
    private $parentForeignKey = 'admin_menu_item_to_parent';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'route' => $this->string(255)->notNull(),
            'title_category' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'permission' => $this->string(255)->notNull(),
            'fa_icon' => $this->string(255)->notNull(),
            'order' => $this->integer()->null(),
            'parent_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            $this->parentForeignKey,
            $this->table,
            'parent_id',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($this->parentForeignKey, $this->table);
        $this->dropTable($this->table);
    }
}
