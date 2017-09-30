<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;
use admin\controllers\core\MainController;
use yii\di\Instance;

class m170805_230944_add_file_manager_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => MainController::FILE_MANAGER_ROUTE,
            'title_category' => 'core/titles',
            'title'          => 'file_manager',
            'permission'     => 'fileManager',
            'fa_icon'        => 'file',
            'order'          => 10,
        ]);
        $adminMenuItem->save();
        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('fileManager');
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => MainController::FILE_MANAGER_ROUTE]);
        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('fileManager');
    }

}
