<?php
/**
 * @var \yii\web\View $this
 */
use mihaildev\elfinder\ElFinder;
use common\components\LanguageComponent;

$this->title = Yii::t('core/titles', 'file_manager');

$defaultLang = LanguageComponent::getDefault();
echo ElFinder::widget([
    'language' => $defaultLang->local,
    'controller' => \admin\controllers\core\FileController::ADMIN_FILE_ROUTE,
    'containerOptions' => [
        'class' => 'file-manager__full-screen'
    ]
]);
