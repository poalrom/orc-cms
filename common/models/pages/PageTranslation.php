<?php

namespace common\models\pages;

use common\interfaces\core\EntityTranslationInterface;
use common\models\core\ar\Lang;
use Yii;
use yii\db\ActiveRecord;

/**
 * Pages translation AR model
 *
 * @property int    $id Translation ID
 * @property int    $page_id Page ID
 * @property int    $lang_id Language ID
 * @property string $meta_title SEO title
 * @property string $meta_keywords SEO keywords
 * @property string $meta_description SEO description
 * @property string $title Page title
 * @property string $description Short description
 * @property string $content Page content
 *
 * @property Lang   $lang Translation language model
 * @property Page   $page Page model
 *
 * @package common\models\pages
 */
class PageTranslation extends ActiveRecord implements EntityTranslationInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{page_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['page_id', 'lang_id'], 'integer'],
            [['meta_title', 'meta_keywords', 'meta_description', 'title'], 'string', 'max' => 250],
            [['description', 'content'], 'string'],
            [
                ['page_id', 'lang_id'],
                'unique',
                'targetAttribute' => ['page_id', 'lang_id'],
            ],
            [
                ['page_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Page::class,
                'targetAttribute' => ['page_id' => 'id'],
            ],
            [
                ['lang_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Lang::className(),
                'targetAttribute' => ['lang_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('pages/attributes', 'id'),
            'page_id'          => Yii::t('pages/attributes', 'page_id'),
            'lang_id'          => Yii::t('pages/attributes', 'lang_id'),
            'meta_title'       => Yii::t('pages/attributes', 'meta_title'),
            'meta_keywords'    => Yii::t('pages/attributes', 'meta_keywords'),
            'meta_description' => Yii::t('pages/attributes', 'meta_description'),
            'title'            => Yii::t('pages/attributes', 'title'),
            'description'      => Yii::t('pages/attributes', 'description'),
            'content'          => Yii::t('pages/attributes', 'content'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return empty($this->content) && empty($this->description) && !$this->lang->is_default;
    }

    /**
     * Page model relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }

    /**
     * Lang model relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }
}
