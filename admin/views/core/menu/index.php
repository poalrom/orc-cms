<?php
/**
 * @var \yii\web\View                $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use admin\helpers\GridHelper;
use common\models\core\ar\Menu;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

$this->title = Yii::t('core/titles', 'menu');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-index">
    <p>
        <?= Html::a(
            Yii::t('core/titles', 'create_menu'),
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'options'      => [
            'class' => 'table table-bordered table-hover dataTable',
        ],
        'columns'      => [
            ['class' => SerialColumn::class],
            GridHelper::headerCenteredColumn('alias'),
            GridHelper::headerCenteredColumn('title'),
            [
                'class'          => ActionColumn::class,
                'buttons'        => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>',
                            ['admin/menu-items/index', 'id' => $model->id]
                        );
                    },
                ],
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        /** @var \common\models\core\ar\Menu $model */
                        return $model->alias !== Menu::MAIN_MENU_ALIAS;
                    },
                    'delete' => function ($model, $key, $index) {
                        /** @var \common\models\core\ar\Menu $model */
                        return $model->alias !== Menu::MAIN_MENU_ALIAS;
                    },
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
