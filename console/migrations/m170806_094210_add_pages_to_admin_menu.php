<?php

use admin\models\core\ar\AdminMenuItem;
use yii\db\Migration;

class m170806_094210_add_pages_to_admin_menu extends Migration
{
    public function safeUp()
    {
        $adminMenuItem = new AdminMenuItem([
            'route'          => 'pages/page/index',
            'title_category' => 'pages/titles',
            'title'          => 'pages',
            'permission'     => 'pages.seeList',
            'fa_icon'        => 'file',
            'order'          => 1,
        ]);
        $adminMenuItem->save();
    }

    public function safeDown()
    {
        AdminMenuItem::deleteAll(['route' => 'pages/page/index']);
    }

}
