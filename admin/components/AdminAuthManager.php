<?php
/**
 * Created by PhpStorm.
 * User: UOP-PopkovAR
 * Date: 23.08.2017
 * Time: 16:31
 */

namespace admin\components;

use yii\rbac\DbManager;

/**
 * Admin auth manager
 *
 * @package admin\components
 */
class AdminAuthManager extends DbManager
{
    /**
     * Title of super admin role
     */
    const ADMIN_SUPER_USER_ROLE = 'superAdmin';

    /**
     * Title of super admin role
     */
    const USE_ADMIN_PANEL_PERMISSION = 'adminPanel.use';

    /**
     * Install admin auth manager
     */
    public function install()
    {
        $superAdminRole = $this->createRole(static::ADMIN_SUPER_USER_ROLE);
        $useAdminPanelPermission = $this->createPermission(static::USE_ADMIN_PANEL_PERMISSION);

        $this->add($superAdminRole);
        $this->add($useAdminPanelPermission);
        $this->addChild($superAdminRole, $useAdminPanelPermission);
        $this->assign($superAdminRole, 1);
    }

    /**
     * Uninstall admin auth manager
     */
    public function uninstall()
    {
        $superAdminRole = $this->createRole(static::ADMIN_SUPER_USER_ROLE);
        $useAdminPanelPermission = $this->createPermission(static::USE_ADMIN_PANEL_PERMISSION);

        $this->revoke($superAdminRole, 1);
        $this->removeChild($superAdminRole, $useAdminPanelPermission);
        $this->remove($useAdminPanelPermission);
        $this->remove($superAdminRole);
    }

    /**
     * Add permission and attach it to super admin
     *
     * @param string $title
     *
     * @return bool
     */
    public function createAdminPermission($title)
    {
        $superAdminRole = $this->getRole(static::ADMIN_SUPER_USER_ROLE);
        $permission = $this->createPermission($title);
        $this->add($permission);
        $this->addChild($superAdminRole, $permission);

        return true;
    }

    /**
     * Remove permission and remove it from super admin
     *
     * @param string $title
     *
     * @return bool
     */
    public function removeAdminPermission($title)
    {
        $superAdminRole = $this->getRole(static::ADMIN_SUPER_USER_ROLE);
        $permission = $this->getPermission($title);
        $this->removeChild($superAdminRole, $permission);
        $this->remove($permission);

        return true;
    }
}