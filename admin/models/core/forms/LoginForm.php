<?php

namespace admin\models\core\forms;

use admin\models\core\ar\Admin;
use Yii;
use yii\base\Model;

/**
 * Login form for admin panel
 *
 * @package admin\models\core\forms
 */
class LoginForm extends Model
{
    /**
     * @var string Login
     */
    public $username;
    /**
     * @var string Password
     */
    public $password;
    /**
     * @var bool Should be user remembered
     */
    public $rememberMe = true;

    /**
     * @var bool|null|Admin Admin models; NULL, if user not found; FALSE, if search isn't running
     */
    private $_admin = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'   => Yii::t('core/attributes', 'username'),
            'password'   => Yii::t('core/attributes', 'password'),
            'rememberMe' => Yii::t('core/attributes', 'remember_me'),
        ];
    }

    /**
     * Password validator
     *
     * @param string $attribute Attribute name
     * @param array  $params Validation parameters
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->findAdmin();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('core/errors', 'incorrect_login_or_password'));
            }
        }
    }

    /**
     * Login user
     *
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->findAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Find Admin model
     *
     * @return null|Admin Admin model or NULL if user not found
     */
    public function findAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::findByUsername($this->username);
        }

        return $this->_admin;
    }
}
