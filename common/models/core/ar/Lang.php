<?php

namespace common\models\core\ar;

use Yii;

/**
 * Front language AR model
 *
 * @property int    $id Language ID
 * @property string $url Url to site version using this language. Isn't displayed in url if there is default language
 * @property string $local Language locale
 * @property string $title Language title
 * @property bool   $is_default Is this language default for site
 *
 * @package common\models\core\ar
 */
class Lang extends EntityModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'title'], 'required'],
            [['is_default'], 'integer'],
            [['url', 'local', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('core/attributes', 'id'),
            'url'        => Yii::t('core/attributes', 'url'),
            'local'      => Yii::t('core/attributes', 'local'),
            'title'      => Yii::t('core/attributes', 'title'),
            'is_default' => Yii::t('core/attributes', 'is_default'),
        ];
    }

    /**
     * Is language setted up as current?
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->local === Yii::$app->language;
    }

    /**
     * Full save language
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullSave()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->is_default == 1) {
                    Yii::$app->db->createCommand("UPDATE `lang` SET `is_default` = 0")->execute();
                }
                $this->save(false);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Full delete language. If language was default, first language in list set as default
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->delete();
            if (Lang::find()->where(['is_default' => 1])->count() === 0) {
                /** @var static $model */
                $model = static::find()->one();
                $model->is_default = 1;
                $model->save();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }
}
