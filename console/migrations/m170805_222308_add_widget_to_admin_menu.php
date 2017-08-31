<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;

class m170805_222308_add_widget_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => 'core/widget/index',
            'title_category' => 'core/titles',
            'title'          => 'widgets',
            'permission'     => 'widget.seeList',
            'fa_icon'        => 'puzzle-piece',
            'order'          => 6,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => 'core/widget/index']);
    }

}
