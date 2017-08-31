<?php

use yii\db\Migration;
use yii\di\Instance;

/**
 * Handles the creation of table `page`.
 */
class m170806_094604_create_page_table extends Migration
{
    private $table = '{{%page}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id'             => $this->primaryKey(),
            'parent_id'      => $this->integer()->null(),
            'preview'        => $this->string(255)->null(),
            'is_active'      => $this->boolean()->defaultValue(true),
            'template'       => $this->string(255)->null(),
            'items_per_page' => $this->integer()->null(),
            'created_at'     => $this->integer()->null(),
            'updated_at'     => $this->integer()->null(),
            'order'          => $this->integer()->null(),
        ]);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('pages.seeList');
        $authManager->createAdminPermission('pages.create');
        $authManager->createAdminPermission('pages.update');
        $authManager->createAdminPermission('pages.delete');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('pages.seeList');
        $authManager->removeAdminPermission('pages.create');
        $authManager->removeAdminPermission('pages.update');
        $authManager->removeAdminPermission('pages.delete');
    }
}
