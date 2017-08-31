<?php

namespace common\widgets\models\htmlBlock;

use common\interfaces\core\TranslatableEntityInterface;
use common\traits\EntityTranslations;
use common\validators\RegexpAliasValidator;
use common\widgets\models\BaseModel;
use Yii;
use yii\base\Model;

/**
 * Simple HTML block model
 *
 * @property int                  $id Widget ID
 * @property int                  $is_active Is widget active
 * @property string               $alias Block alias
 * @property HtmlBlockTranslation $currentTranslation Block current translation
 *
 * @package common\widgets\models\htmlBlock
 */
class HtmlBlock extends BaseModel implements TranslatableEntityInterface
{
    use EntityTranslations;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_html_block}}';
    }

    /**
     * @inheritdoc
     */
    public static function getTranslationClassname()
    {
        return HtmlBlockTranslation::className();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['alias', 'string', 'max' => 255],
            ['alias', 'unique'],
            [['alias'], RegexpAliasValidator::class],
            [['is_active'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('widgets/htmlBlock', 'attr_id'),
            'is_active' => Yii::t('widgets/htmlBlock', 'attr_is_active'),
            'alias'     => Yii::t('widgets/htmlBlock', 'attr_alias'),
        ];
    }

    /**
     * Full save HTML block with translations
     *
     * @param HtmlBlockTranslation[] $translations Translations array
     *
     * @return bool
     * @throws \Exception
     */
    public function fullSave(&$translations)
    {
        if ($this->load(Yii::$app->request->post()) &&
            Model::loadMultiple($translations, Yii::$app->request->post()) &&
            $this->validate() &&
            Model::validateMultiple($translations)
        ) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$this->save()) {
                    return false;
                }
                foreach ($translations as $key => $translation) {
                    $translation->html_block_id = $this->id;
                    $translation->lang_id = $key;
                    $translation->save(false);
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getShortCode($params = [])
    {
        return '[{widget html-block alias="' . $this->alias . '"}]';
    }

}
