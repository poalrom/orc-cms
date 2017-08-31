<?php

use common\models\core\ar\Lang;
use common\models\core\ar\Menu;
use yii\db\Migration;
use yii\di\Instance;

/**
 * Handles the creation of table `lang`.
 */
class m170805_225346_create_menu_tables extends Migration
{
    private $menuTable = '{{%menu}}';
    private $menuItemTable = '{{%menu_link}}';
    private $langForeignKey = 'link_to_lang';
    private $menuForeignKey = 'link_to_menu';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->menuTable, [
            'id'    => $this->primaryKey(),
            'alias' => $this->string(255)->notNull()->unique(),
            'title' => $this->string(255)->null(),
        ]);

        $this->createTable($this->menuItemTable, [
            'id'        => $this->primaryKey(),
            'menu_id'   => $this->integer()->notNull(),
            'lang_id'   => $this->integer()->notNull(),
            'title'     => $this->string(255)->null(),
            'link'      => $this->string(255)->null(),
            'order'     => $this->integer()->defaultValue(0),
            'parent_id' => $this->integer()->defaultValue(0),
            'css_class' => $this->string(255)->defaultValue('common'),
        ]);

        $this->addForeignKey(
            $this->langForeignKey,
            $this->menuItemTable,
            'lang_id',
            Lang::tableName(),
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey(
            $this->menuForeignKey,
            $this->menuItemTable,
            'menu_id',
            Menu::tableName(),
            'id',
            'CASCADE',
            'CASCADE');

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->createAdminPermission('menu.seeList');
        $authManager->createAdminPermission('menu.create');
        $authManager->createAdminPermission('menu.update');
        $authManager->createAdminPermission('menu.delete');

        $authManager->createAdminPermission('menuItem.seeList');
        $authManager->createAdminPermission('menuItem.create');
        $authManager->createAdminPermission('menuItem.update');
        $authManager->createAdminPermission('menuItem.delete');

        $mainMenu = new Menu([
            'id'    => 1,
            'alias' => Menu::MAIN_MENU_ALIAS,
            'title' => 'Главное меню',
        ]);
        $mainMenu->save();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($this->menuForeignKey, $this->menuItemTable);
        $this->dropForeignKey($this->langForeignKey, $this->menuItemTable);
        $this->dropTable($this->menuItemTable);
        $this->dropTable($this->menuTable);

        /** @var \admin\components\AdminAuthManager $authManager */
        $authManager = Instance::ensure('adminAuthManager');
        $authManager->removeAdminPermission('menu.seeList');
        $authManager->removeAdminPermission('menu.create');
        $authManager->removeAdminPermission('menu.update');
        $authManager->removeAdminPermission('menu.delete');

        $authManager->removeAdminPermission('menuItem.seeList');
        $authManager->removeAdminPermission('menuItem.create');
        $authManager->removeAdminPermission('menuItem.update');
        $authManager->removeAdminPermission('menuItem.delete');
    }
}
