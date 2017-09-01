<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;

class m170805_183809_add_redirector_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => 'core/redirects/index',
            'title_category' => 'core/titles',
            'title'          => 'redirects',
            'permission'     => 'redirect.seeList',
            'fa_icon'        => 'compass',
            'order'          => 8,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => 'core/redirects/index']);
    }

}
