<?php
/**
 * @var \yii\web\View                 $this
 * @var \common\models\core\ar\Menu   $menu
 * @var array                         $links
 * @var \common\models\core\ar\Lang[] $languages
 */

use admin\assets\core\SaveAllAsset;
use admin\helpers\GridHelper;
use common\models\core\ar\MenuLink;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

SaveAllAsset::register($this);

$this->title = Yii::t('core/titles', 'menu') . ': ' . $menu->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/titles', 'menu'), 'url' => ['admin/menu/menu/index']];
$this->params['breadcrumbs'][] = $menu->title;
$this->params['activeRoute'] = 'core/menu/index';
?>
<div class="menu-items-list">

    <div class="nav-tabs-custom">

        <ul class="nav nav-tabs" id="translation_tabs" role="tablist">
            <?php foreach ($languages as $language): ?>
                <li role="presentation" <?= $language->is_default ? 'class="active"' : '' ?>>
                    <a href="#<?= $language['url']; ?>" aria-controls="<?= $language->url; ?>" role="tab"
                       data-toggle="tab">
                        <?= $language->title ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content">
            <?php foreach ($languages as $language): ?>
                <div role="tabpanel" class="tab-pane fade clearfix <?= $language->is_default ? 'in active' : ''; ?>"
                     id="<?= $language->url; ?>">
                    <p>
                        <?= Html::a(
                            Yii::t('core/titles', 'create_menu_item'),
                            ['create', 'lang_id' => $language->id, 'menu_id' => $menu->id],
                            ['class' => 'btn btn-success']
                        ); ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $links[$language->id]['dataProvider'],
                        'filterModel'  => $links[$language->id]['searchModel'],
                        'options'      => [
                            'class' => 'table table-bordered table-hover dataTable',
                        ],
                        'columns'      => [
                            ['class' => SerialColumn::class],
                            GridHelper::headerCenteredColumn('title'),
                            GridHelper::headerCenteredColumn('link', function ($model) {
                                /** @var \common\models\core\ar\MenuLink $model */
                                return Html::a($model->link, \yii\helpers\Url::to($model->link, true), [
                                    'target' => '_blank',
                                ]);
                            }, 'raw'),
                            [
                                'label'         => Yii::t('core/attributes', 'parent'),
                                'attribute'     => 'parent.title',
                                'filter'        => Html::dropDownList('MenuLinkSearch[parent_id]',
                                    $links[$language->id]['searchModel']->parent_id,
                                    [
                                        Yii::t('core/prompts', 'without_parent'),
                                    ] + $menu->getLinkList($language->id),
                                    ['prompt' => Yii::t('core/prompts', 'all'), 'class' => 'form-control']),
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                            ],
                            [
                                'attribute'     => 'order',
                                'format'        => 'raw',
                                'value'         => function ($model) {
                                    return Html::textInput('MenuLink[' . $model->id . '][order]', $model->order,
                                        ['class' => 'form-control']);
                                },
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'filter'        => Html::a(Yii::t('core/buttons', 'save'), '#',
                                    ['class' => 'save-all btn btn-success btn-block']),
                            ],
                            [
                                'attribute'     => 'target',
                                'value'         => function ($model) {
                                    /** @var MenuLink $model */
                                    return $model->getTargetDescription();
                                },
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'filter'        => Html::dropDownList('MenuLinkSearch[target]',
                                    $links[$language->id]['searchModel']->target,
                                    MenuLink::getLinkTargets(),
                                    ['prompt' => Yii::t('core/prompts', 'all'), 'class' => 'form-control']),
                            ],
                            [
                                'class'          => ActionColumn::class,
                                'visibleButtons' => [
                                    'view' => false,
                                ],
                                'contentOptions' => [
                                    'class' => 'action-column',
                                ],
                                'headerOptions'  => [
                                    'class' => 'text-center',
                                ],
                                'header'         => Html::a(Yii::t('core/buttons', 'reset'),
                                    ['index', 'id' => Yii::$app->request->getQueryParam('id')],
                                    ['class' => 'btn btn-success btn-block']),
                            ],
                        ],
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>