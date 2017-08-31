<?php

use common\models\core\ar\Lang;
use common\models\pages\Page;
use yii\db\Migration;

/**
 * Handles the creation of table `page_translation`.
 */
class m170806_094611_create_page_translation_table extends Migration
{
    private $table = '{{%page_translation}}';
    private $langForeignKey = 'page_translation_to_lang';
    private $pageForeignKey = 'page_translation_to_page';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id'               => $this->primaryKey(),
            'page_id'          => $this->integer()->notNull(),
            'lang_id'          => $this->integer()->notNull(),
            'meta_title'       => $this->string(255)->null(),
            'meta_keywords'    => $this->string(255)->null(),
            'meta_description' => $this->string(255)->null(),
            'title'            => $this->string(255)->null(),
            'description'      => $this->text()->null(),
            'content'          => $this->text()->null(),
        ]);

        $this->addForeignKey(
            $this->langForeignKey,
            $this->table,
            'lang_id',
            Lang::tableName(),
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey(
            $this->pageForeignKey,
            $this->table,
            'page_id',
            Page::tableName(),
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($this->pageForeignKey, $this->table);
        $this->dropForeignKey($this->langForeignKey, $this->table);
        $this->dropTable($this->table);
    }
}
