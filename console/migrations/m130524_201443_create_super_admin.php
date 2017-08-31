<?php

use admin\models\core\ar\Admin;
use yii\db\Migration;

class m130524_201443_create_super_admin extends Migration
{
    public function safeUp()
    {
        echo "    > add super admin with login 'admin' and password 'admin' ...";
        $superAdmin = new Admin([
            'id'       => 1,
            'username' => 'admin',
            'name'     => 'Admin',
            'email'    => 'admin@admin.ru',
        ]);
        $superAdmin->setPassword('admin');
        $superAdmin->save();
    }

    public function safeDown()
    {
        echo "    > delete super admin ...";
        Admin::findOne(1)->delete();
    }
}
