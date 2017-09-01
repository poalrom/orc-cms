<?php

namespace common\models\core\ar;

use Yii;

/**
 * Redirect AR model
 *
 * @property integer $id Redirect ID
 * @property string  $from Closed url
 * @property string  $to Url to redirect
 * @property integer $status Redirect HTTP status
 *
 * @package common\models\core\ar
 */
class Redirect extends EntityModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%redirect}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['from', 'to'], 'string', 'max' => 500],
            [
                ['from'],
                'match',
                'pattern' => '/^\/.*$/i',
                'message' => Yii::t('core/errors', 'no_slash_in_front'),
            ],
            [
                ['to'],
                'match',
                'pattern' => '/^(?:\/|[a-zA-Z0-9]{1,6}\:).*$/i',
                'message' => Yii::t('core/errors', 'no_slash_or_protocol_in_front'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => Yii::t('core/attributes', 'id'),
            'status' => Yii::t('core/attributes', 'http_status'),
            'from'   => Yii::t('core/attributes', 'from'),
            'to'     => Yii::t('core/attributes', 'to'),
        ];
    }

    /**
     * Supported redirect statuses with their descriptions
     *
     * @return array
     */
    public static function getList()
    {
        return [
            301 => Yii::t('core/http_statuses', 301),
            302 => Yii::t('core/http_statuses', 302),
            303 => Yii::t('core/http_statuses', 303),
            307 => Yii::t('core/http_statuses', 307),
        ];
    }
}
