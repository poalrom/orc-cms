<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;
use admin\controllers\core\MainController;
use admin\components\AdminAuthManager;

class m170805_230944_add_file_manager_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => MainController::FILE_MANAGER_ROUTE,
            'title_category' => 'core/titles',
            'title'          => 'file_manager',
            'permission'     => AdminAuthManager::USE_ADMIN_PANEL_PERMISSION,
            'fa_icon'        => 'file',
            'order'          => 10,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => MainController::FILE_MANAGER_ROUTE]);
    }

}
