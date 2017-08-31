<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;

class m170805_220808_add_language_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => 'core/lang/index',
            'title_category' => 'core/titles',
            'title'          => 'languages',
            'permission'     => 'languages.seeList',
            'fa_icon'        => 'globe',
            'order'          => 6,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => 'core/lang/index']);
    }

}
