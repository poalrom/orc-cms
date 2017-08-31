<?php
/**
 * @var \yii\web\View                   $this
 * @var \yii\data\ActiveDataProvider    $dataProvider
 * @var \common\models\pages\PageSearch $searchModel
 */

use admin\assets\core\SaveAllAsset;
use admin\helpers\GridHelper;
use common\models\pages\Page;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

SaveAllAsset::register($this);

$this->title = Yii::t('pages/titles', 'pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a(Yii::t('pages/titles', 'create_page'),
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => SerialColumn::class],
            GridHelper::urlColumn(),
            GridHelper::headerCenteredColumn('title', 'currentTranslation.title'),
            [
                'label'         => Yii::t('pages/attributes', 'parent_id'),
                'attribute'     => 'parent.currentTranslation.title',
                'filter'        => Html::dropDownList(
                    'PageSearch[parent_id]',
                    $searchModel->parent_id,
                    Page::getList(),
                    ['prompt' => Yii::t('core/prompts', 'all'), 'class' => 'form-control']
                ),
                'headerOptions' => [
                    'class' => 'text-center',
                ],
            ],
            [
                'attribute'     => 'order',
                'format'        => 'raw',
                'value'         => function ($model) {
                    return Html::textInput('Page[' . $model->id . '][order]', $model->order,
                        ['class' => 'form-control']);
                },
                'headerOptions' => [
                    'class' => 'text-center',
                ],
                'filter'        => Html::a(Yii::t('core/buttons', 'save'), '#',
                    ['class' => 'save-all btn btn-fill btn-success btn-block']),
            ],
            GridHelper::templateColumn($searchModel::className(), $searchModel->template, 'pages'),
            GridHelper::statusColumn($searchModel::className(), $searchModel->is_active),
            [
                'class'          => ActionColumn::class,
                'visibleButtons' => [
                    'view' => false,
                ],
                'contentOptions' => [
                    'class' => 'action-column',
                ],
                'header'         => Html::a(Yii::t('core/buttons', 'reset'), ['index'],
                    ['class' => 'btn btn-fill btn-success btn-block']),
            ],
        ],
    ]); ?>
</div>
