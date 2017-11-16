<?php

use common\models\core\ar\Lang;
use yii\db\Migration;

class m170805_221840_add_ru_lang extends Migration
{
    public function safeUp()
    {
        echo "    > add Russian language ...";
        $lang = new Lang([
            'id'         => 1,
            'url'        => 'ru',
            'local'      => 'ru-RU',
            'icon'       => 'ru',
            'title'      => 'Русский',
            'is_default' => 1,
        ]);

        $lang->save();
    }

    public function safeDown()
    {
        echo "    > delete Russian language ...";
        Lang::deleteAll(['id' => 1]);
    }

}
