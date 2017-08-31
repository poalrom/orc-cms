<?php

namespace admin\models\core\ar;

use common\interfaces\core\UserInterface;
use common\traits\ModelFindOrFail;
use common\traits\ModelGetList;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Admin model class
 *
 * @property int    $id Admin ID
 * @property string $username Admin login
 * @property string $name Nickname
 * @property string $email Email
 * @property string $password_hash Password hash
 * @property string $auth_key Key for authentication
 * @property string $access_token Key for recovering password
 *
 * @package admin\models\core\ar
 */
class Admin extends ActiveRecord implements IdentityInterface, UserInterface
{
    use ModelFindOrFail,
        ModelGetList;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => \Yii::t('core/attributes', 'id'),
            'username' => \Yii::t('core/attributes', 'username'),
            'name'     => \Yii::t('core/attributes', 'name'),
            'email'    => \Yii::t('core/attributes', 'email'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamps' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * Generate auth key before saving new record
     *
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Find admin by login
     *
     * @param string $username Admin login
     *
     * @return null|static
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Password validation
     *
     * @param string $password Password for validation
     *
     * @return bool
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Setting password
     *
     * @param string $password New password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generating auth token
     *
     * @return void
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

}