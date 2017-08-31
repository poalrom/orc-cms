<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;

class m170805_230132_add_menu_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => 'core/menu/index',
            'title_category' => 'core/titles',
            'title'          => 'menu',
            'permission'     => 'menu.seeList',
            'fa_icon'        => 'bars',
            'order'          => 2,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => 'pages/page/index']);
    }

}
