<?php

namespace common\widgets\models\htmlBlock;

use common\models\core\ar\Lang;
use Yii;
use yii\db\ActiveRecord;

/**
 * HTML block translation model
 *
 * @property int    $id Translation ID
 * @property int    $html_block_id Block ID
 * @property int    $lang_id Lang ID
 * @property string $content Block content
 *
 * @package common\widgets\models\htmlBlock
 */
class HtmlBlockTranslation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_html_block_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'html_block_id', 'lang_id'], 'integer'],
            [['content'], 'string'],
            [['html_block_id', 'lang_id'], 'unique', 'targetAttribute' => ['html_block_id', 'lang_id']],
            [
                ['lang_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Lang::className(),
                'targetAttribute' => ['lang_id' => 'id'],
            ],
            [
                ['html_block_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => HtmlBlock::className(),
                'targetAttribute' => ['html_block_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('widgets/htmlBlock', 'attr_id'),
            'html_block_id' => Yii::t('widgets/htmlBlock', 'attr_html_block_id'),
            'lang_id'  => Yii::t('widgets/htmlBlock', 'attr_lang_id'),
            'content'  => Yii::t('widgets/htmlBlock', 'attr_content'),
        ];
    }

    /**
     * Lang relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * Block relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(HtmlBlock::className(), ['id' => 'html_block_id']);
    }
}
