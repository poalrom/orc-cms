<?php

namespace admin\controllers\widgets\htmlBlock;

use admin\controllers\widgets\BaseController;
use common\models\core\ar\Lang;
use common\widgets\models\htmlBlock\HtmlBlock;
use common\widgets\models\htmlBlock\HtmlBlockSearch;
use common\widgets\models\htmlBlock\HtmlBlockTranslation;
use Yii;

/**
 * Admin controller for simple HTML block widget
 *
 * @package admin\controllers\widgets\htmlBlock
 */
class HtmlBlockController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@admin/views/widgets/htmlBlock');
    }

    /**
     * Route to html block actions
     */
    const HTML_BLOCK_ROUTE = 'widgets/htmlBlock/html-block/<action>';

    /**
     * Route to main action
     */
    const MAIN_ROUTE = 'widgets/htmlBlock/html-block/index';

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new HtmlBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Create HTML block
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $block = new HtmlBlock([
            'is_active' => true,
        ]);
        /** @var Lang[] $languages */
        $languages = Lang::find()->orderBy('is_default DESC')->all();
        $translations = [];
        foreach ($languages as $language) {
            $translations[$language->id] = new HtmlBlockTranslation();
        }
        if ($block->fullSave($translations)) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'block'        => $block,
                'languages'    => $languages,
                'translations' => $translations,
            ]);
        }
    }

    /**
     * Update HTML block
     *
     * @param int $id Block ID
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $block = HtmlBlock::findOrFail($id);
        /** @var Lang[] $languages */
        $languages = Lang::find()->orderBy('is_default DESC')->all();
        $translations = [];
        foreach ($languages as $language) {
            if (($translation = HtmlBlockTranslation::find()->where([
                    'html_block_id' => $id,
                    'lang_id'       => $language['id'],
                ])->one()) !== null
            ) {
                $translations[$language->id] = $translation;
            } else {
                $translations[$language->id] = new HtmlBlockTranslation();
            }
        }
        if ($block->fullSave($translations)) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'block'        => $block,
                'languages'    => $languages,
                'translations' => $translations,
            ]);
        }
    }

    /**
     * Delete block
     *
     * @param int $id Block ID
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        HtmlBlock::findOrFail($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @inheritdoc
     */
    public static function info()
    {
        return [
            'alias'            => 'html-block',
            'title'            => 'HTMLBlock',
            'version'          => '1.3.0',
            'className'        => self::getClassNameWithModule(),
            'front_controller' => \front\controllers\widgets\htmlBlock\HtmlBlockController::class,
            'mainRoute'        => static::MAIN_ROUTE,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function install()
    {
        Yii::$app->db->createCommand()->createTable(HtmlBlock::tableName(), [
            'id'        => 'pk',
            'alias'     => 'string not null',
            'is_active' => 'boolean',
        ])->execute();

        Yii::$app->db->createCommand()->createTable(HtmlBlockTranslation::tableName(), [
            'id'       => 'pk',
            'html_block_id' => 'integer',
            'lang_id'  => 'integer',
            'content'  => 'text',
        ])->execute();

        Yii::$app->db->createCommand()->addForeignKey(
            'block_translation_to_lang',
            HtmlBlockTranslation::tableName(),
            'lang_id',
            Lang::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        )->addForeignKey(
            'block_translation_to_block',
            HtmlBlockTranslation::tableName(),
            'html_block_id',
            HtmlBlock::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        )->execute();

        return true;
    }

    /**
     * @inheritdoc
     */
    public static function uninstall()
    {
        Yii::$app->db->createCommand()->dropTable(HtmlBlockTranslation::tableName())->execute();
        Yii::$app->db->createCommand()->dropTable(HtmlBlock::tableName())->execute();

        return true;
    }

}
