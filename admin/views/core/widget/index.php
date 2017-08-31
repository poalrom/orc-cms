<?php

use yii\helpers\Url;

/**
 * @var array $widgets
 * @var array $installedWidgets
 * @var array $errors
 */
$this->title = Yii::t('core/titles', 'widgets');
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu-active'][] = '/admin/widgets/index';
?>
<div class="widgets-index">
    <?php if (count($errors) !== 0): ?>
        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endforeach ?>
    <?php elseif (count($widgets)): ?>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center"><?= Yii::t('core/attributes', 'title') ?></th>
                <th class="text-center"><?= Yii::t('core/attributes', 'version') ?></th>
                <th class="text-center"><?= Yii::t('core/attributes', 'status') ?></th>
                <th class="text-center"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($widgets as $i => $widget): ?>
            	<?php $isWidgetInstalled = isset($installedWidgets[$widget['alias']]) ?>
                <tr>
                    <td class="text-center"><?= $i+1 ?></td>
                    <td><?= $widget['title'] ?></td>
                    <td class="text-center"><?= $widget['version'] ?></td>
                    <td class="text-center">
                        <?php if ($isWidgetInstalled): ?>
                            <?= Yii::t('core/statuses', 'installed') ?>
                        <?php else: ?>
                            <?= Yii::t('core/statuses', 'not_installed') ?>
                        <?php endif ?>
                    </td>
                    <td class="action-column">
                        <?php if ($isWidgetInstalled): ?>
                            <?php if (\Yii::$app->user->can('widget.use.'.$widget['alias'])): ?>
                                <a href="<?= Url::to([$widget['mainRoute']]) ?>"
                                   title="<?= Yii::t('core/buttons', 'view') ?>"
                                   aria-label="<?= Yii::t('core/buttons', 'view') ?>">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                <a href="<?= Url::to(['uninstall', 'class' => $widget['className']]) ?>"
                                   title="<?= Yii::t('core/buttons', 'uninstall') ?>"
                                   aria-label="<?= Yii::t('core/buttons', 'uninstall') ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            <?php endif ?>
                        <?php else: ?>
                            <a href="<?= Url::to(['install', 'class' => $widget['className']]) ?>"
                               title="<?= Yii::t('core/buttons', 'install') ?>"
                               aria-label="<?= Yii::t('core/buttons', 'install') ?>">
                                <span class="glyphicon glyphicon-download-alt"></span>
                            </a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
