<?php

use yii\db\Migration;
use yii\di\Instance;

/**
 * Handles the creation of table `lang`.
 */
class m170805_221346_create_lang_table extends Migration
{
    private $table = '{{%lang}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'url'        => $this->string(255)->notNull(),
            'local'      => $this->string(255)->notNull(),
            'title'      => $this->string(255)->notNull(),
            'icon'       => $this->string(255)->notNull(),
            'is_default' => $this->boolean(),
        ]);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('languages.seeList');
        $authManager->createAdminPermission('languages.create');
        $authManager->createAdminPermission('languages.update');
        $authManager->createAdminPermission('languages.delete');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('languages.seeList');
        $authManager->removeAdminPermission('languages.create');
        $authManager->removeAdminPermission('languages.update');
        $authManager->removeAdminPermission('languages.delete');
    }
}
