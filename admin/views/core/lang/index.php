<?php
/**
 * @var \yii\web\View                    $this
 * @var \yii\data\ActiveDataProvider     $dataProvider
 * @var \admin\models\core\ar\LangSearch $searchModel
 */

use admin\helpers\GridHelper;
use common\models\core\ar\Lang;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

$this->title = Yii::t('core/titles', 'languages');

$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a(Yii::t('core/titles', 'create_language'),
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'options'      => [
            'class' => 'table table-bordered table-hover dataTable',
        ],
        'columns'      => [
            ['class' => SerialColumn::class],

            GridHelper::headerCenteredColumn('url'),
            GridHelper::headerCenteredColumn('local'),
            GridHelper::headerCenteredColumn('title'),

            [
                'attribute'      => 'is_default',
                'format'         => 'raw',
                'value'          => function ($data) {
                    if ($data->is_default) {
                        return '<span aria-hidden="true" class="fa fa-check"></span>';
                    } else {
                        return '';
                    }
                },
                'filter'         => Html::dropDownList(
                    'LangSearch[is_default]',
                    $searchModel->is_default,
                    [Yii::t('core/prompts', 'no'), Yii::t('core/prompts', 'yes')],
                    ['prompt' => Yii::t('core/prompts', 'all'), 'class' => 'form-control']
                ),
                'headerOptions'  => [
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'action-column',
                ],
            ],
            GridHelper::centeredColumn('icon', function($model){
                return "<span class='flag-icon flag-icon-{$model->icon}'></span>";
            }, 'raw'),
            [
                'class'          => ActionColumn::class,
                'visibleButtons' => [
                    'view'   => false,
                    'delete' => function ($data) {
                        return Lang::find()->count() > 1;
                    },
                ],
                'contentOptions' => [
                    'class' => 'action-column',
                ],
                'header'         => Html::a(Yii::t('core/buttons', 'reset'), ['index'],
                    ['class' => 'btn btn-success btn-block']),
            ],
        ],
    ]); ?>
</div>
