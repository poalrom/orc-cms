<?php

use yii\db\Migration;
use common\models\core\ar\Redirect;
use yii\di\Instance;

/**
 * Handles the creation of table `redirect`.
 */
class m170805_183709_create_redirect_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(Redirect::tableName(), [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->defaultValue(302),
            'from' => $this->string(255)->notNull(),
            'to' => $this->string(255)->notNull(),
        ]);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('redirect.seeList');
        $authManager->createAdminPermission('redirect.install');
        $authManager->createAdminPermission('redirect.uninstall');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(Redirect::tableName());
        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('redirect.seeList');
        $authManager->removeAdminPermission('redirect.install');
        $authManager->removeAdminPermission('redirect.uninstall');
    }
}
