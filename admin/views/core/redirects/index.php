<?php
/**
 * @var \yii\web\View                         $this
 * @var \yii\data\ActiveDataProvider          $dataProvider
 * @var \common\models\core\ar\RedirectSearch $searchModel
 */
use common\models\core\ar\Redirect;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('core/titles', 'redirects');
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/redirects/index';
?>
<div class="redirect-index">

    <p>
        <?= Html::a(
            Yii::t('core/titles', 'create_redirect'),
            ['create'],
            ['class' => 'btn btn-success']
        ); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => SerialColumn::class],
            [
                'attribute'     => 'from',
                'format'        => 'raw',
                'value'         => function ($model) {
                    return Html::a(Url::base(true) . $model->from, $model->from, ['target' => '_blank']);
                },
                'headerOptions' => [
                    'class' => 'text-center',
                ],
            ],
            [
                'attribute'     => 'to',
                'format'        => 'raw',
                'value'         => function ($model) {
                    if (substr($model->to, 0, 1) == '/') {
                        $link = Url::base(true) . $model->to;
                    } else {
                        $link = $model->to;
                    }

                    return Html::a($link, $model->to, ['target' => '_blank']);
                },
                'headerOptions' => [
                    'class' => 'text-center',
                ],
            ],
            [
                'attribute'      => 'status',
                'filter'         => Html::dropDownList(
                    'RedirectSearch[status]',
                    $searchModel->status,
                    Redirect::getList(),
                    ['prompt' => Yii::t('core/prompts', 'all'), 'class' => 'form-control']
                ),
                'value'          => function ($model) {
                    /** @var Redirect $model */
                    return Yii::t('core/http_statuses', $model->status);
                },
                'headerOptions'  => [
                    'class' => 'text-center',
                ],
            ],
            [
                'class'          => ActionColumn::class,
                'visibleButtons' => [
                    'view' => false,
                ],
                'contentOptions' => [
                    'class' => 'action-column',
                ],
                'header'         => Html::a(Yii::t('core/buttons', 'reset'),
                    ['index'],
                    ['class' => 'btn btn-success btn-block']),
            ],
        ],
    ]); ?>
</div>
