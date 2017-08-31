<?php

/**
 * @var \yii\web\View $this
 * @var string        $content
 */

use admin\assets\core\CoreAsset;
use admin\controllers\core\LoginController;
use admin\controllers\core\MainController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

//use app\modules\Menu;

CoreAsset::register($this);

/** @var \common\interfaces\core\UserInterface $user */
$user = $this->params['user'];

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body class="skin-red sidebar-mini <?= $this->params['isSidebarCollapsed'] ?: 'sidebar-collapse' ?>">
<?php $this->beginBody(); ?>

<div class="wrapper">
    <header class="main-header">
        <a href="<?= Url::toRoute(MainController::MAIN_PAGE_ROUTE) ?>" class="logo">
            <span class="logo-mini">
                OC
            </span>
            <span class="logo-lg">
                ORC.CMS
            </span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"></a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#"><?= Html::encode($user->getName()) ?></a>
                    </li>
                    <li>
                        <a href="/" target="_blank"><?= Yii::t('core/titles', 'go_to_site') ?></a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(LoginController::LOGOUT_PAGE_ROUTE) ?>">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar" style="height: auto;">
            <?= Menu::widget([
                'items'           => $this->params['menuItems'],
                'activateParents' => true,
                'encodeLabels'    => false,
                'options'         => [
                    'class' => 'sidebar-menu',
                ],
                'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                'route'           => $this->params['activeRoute'],
            ]) ?>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
            <?php echo Breadcrumbs::widget([
                'links'    => $this->params['breadcrumbs'],
                'homeLink' => [
                    'label' => Yii::t('core/titles', 'main_page'),
                    'url'   => Url::toRoute(MainController::MAIN_PAGE_ROUTE),
                ],
                'options'  => [
                    'class' => 'pull-left breadcrumb',
                ],
            ]); ?>
        </section>
        <section class="content">
            <?php echo $content; ?>
        </section>
    </div>

    <footer class="main-footer">
        <div class="container-fluid">
            <?php if (YII_DEBUG): ?>
                <div class="text-danger pull-left"><?= Yii::t('core/titles', 'debug_enabled') ?></div>
            <?php endif ?>
            <div class="pull-right">
                &copy; 2015 - <?= date('Y') ?> Ralt
            </div>
        </div>
    </footer>

</div>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
