<?php

use yii\db\Migration;
use yii\di\Instance;

/**
 * Handles the creation of table `lang`.
 */
class m170805_222246_create_widget_table extends Migration
{
    private $table = '{{%widget}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id'               => $this->primaryKey(),
            'alias'            => $this->string(255)->notNull()->unique(),
            'admin_controller' => $this->string(255)->notNull()->unique(),
            'front_controller' => $this->string(255)->notNull()->unique(),
        ]);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('widget.seeList');
        $authManager->createAdminPermission('widget.install');
        $authManager->createAdminPermission('widget.uninstall');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('widget.seeList');
        $authManager->removeAdminPermission('widget.install');
        $authManager->removeAdminPermission('widget.uninstall');
    }
}
