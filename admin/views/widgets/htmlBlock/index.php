<?php

/**
 * @var \yii\web\View                                    $this
 * @var \yii\data\ActiveDataProvider                     $dataProvider
 * @var \common\widgets\models\htmlBlock\HtmlBlockSearch $searchModel
 */

use admin\helpers\GridHelper;
use common\widgets\models\htmlBlock\HtmlBlock;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

$this->title = Yii::t('widgets/htmlBlock', 'title');
$this->params['breadcrumbs'][] = $this->title;
$this->params['activeRoute'] = 'core/widget/index';
?>
<div class="widget-html-block-index">
    <p>
        <?= Html::a(
            Yii::t('widgets/htmlBlock', 'button_create'),
            ['create'],
            ['class' => 'btn btn-success']
        ); ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => SerialColumn::class],
            [
                'attribute'     => 'alias',
                'headerOptions' => [
                    'class' => 'text-center',
                ],
            ],
            [
                'attribute'      => 'alias',
                'label'          => Yii::t('core/attributes', 'shortcode'),
                'value'          => function ($data) {
                    /** @var HtmlBlock $data */
                    return $data->getShortCode();
                },
                'headerOptions'  => [
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'clipboardable',
                ],
            ],
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
                    ['class' => 'btn btn-success btn-block']),
                'headerOptions'  => [
                    'class' => 'text-center',
                ],
            ],
        ],
    ]); ?>
</div>