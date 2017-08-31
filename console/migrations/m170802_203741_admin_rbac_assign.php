<?php

use yii\db\Migration;
use yii\di\Instance;

class m170802_203741_admin_rbac_assign extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->install();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->uninstall();
    }
}
