<?php

namespace admin\models\core;

use common\traits\ModelFindOrFail;
use yii\base\Model;
use yii\rbac\Role;

/**
 * Admin role model
 *
 * @package admin\models\core
 */
class AdminRole extends Model
{

    use ModelFindOrFail;

    /**
     * @var string Role name
     */
    public $name = '';
    /**
     * @var string Role description
     */
    public $description = '';
    /**
     * @var string Old role name
     */
    public $oldName = '';
    /**
     * @var string Old role description
     */
    public $oldDescription = '';
    /**
     * @var bool New record flag
     */
    public $isNewRecord = true;
    /**
     * @var array Permissions for role
     */
    public $permissions = [];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => \Yii::t('admin/user', 'attr_name'),
            'description' => \Yii::t('admin/user', 'attr_description'),
            'permissions' => \Yii::t('admin/user', 'attr_permissions'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 64],
            ['description', 'string'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z]*$/'],
            ['permissions', 'each', 'rule' => ['string', 'max' => 64]],
        ];
    }

    /**
     * Find role model by role name
     *
     * @param string $name Role name
     *
     * @return static|null
     */
    public static function findOne($name)
    {
        $role = \Yii::$app->authManager->getRole($name);

        return self::cast($role);
    }

    /**
     * Get permission list for role
     *
     * @return array Array of permissions with format [permission name => permission description]
     */
    public static function getPermissionList()
    {
        $permissions = [];
        foreach (\Yii::$app->authManager->getPermissions() as $permission) {
            $permissions[$permission->name] = $permission->description;
        }
        asort($permissions);

        return $permissions;
    }

    /**
     * Get all roles
     *
     * @return static[];
     */
    public static function getAll()
    {
        $roles = \Yii::$app->authManager->getRoles();
        $data = [];
        foreach ($roles as $role) {
            $data[] = static::cast($role);
        }

        return $data;
    }

    /**
     * Cast [[Role]] to AdminRole instance
     *
     * @param Role $role RBAC role instance
     *
     * @return static|null Return NULL if given role isn't RBAC role instance
     */
    private static function cast($role)
    {
        if (!is_a($role, Role::className())) {
            return null;
        }

        $castedRole = new static();
        $permissions = [];
        foreach (\Yii::$app->authManager->getPermissionsByRole($role->name) as $item) {
            $permissions[] = $item->name;
        }
        $castedRole->setAttributes([
            'name'           => $role->name,
            'description'    => $role->description,
            'oldName'        => $role->name,
            'oldDescription' => $role->description,
            'permissions'    => $permissions,
        ], false);

        return $castedRole;
    }

    /**
     * Save role
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $role = \Yii::$app->authManager->getRole($this->oldName);
            if ($role) {
                $role->name = $this->name;
                $role->description = $this->description;
                \Yii::$app->authManager->update($this->name, $role);
            } else {
                $role = \Yii::$app->authManager->createRole($this->name);
                $role->description = $this->description;
                \Yii::$app->authManager->add($role);
            }
            \Yii::$app->authManager->removeChildren($role);
            foreach ($this->permissions as $permission) {
                $permissionItem = \Yii::$app->authManager->getPermission($permission);

                \Yii::$app->authManager->addChild($role, $permissionItem);
            }

            return true;
        }

        return false;
    }

    /**
     * Delete role
     *
     * @return bool
     */
    public function delete()
    {
        $role = \Yii::$app->authManager->getRole($this->name);

        return \Yii::$app->authManager->remove($role);
    }
}