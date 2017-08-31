<?php

$this->title = \Yii::t('admin/login', 'error_access_denied');
?>
<div class="col-sm-12 site-login">
    <div class="col-sm-12 myForm">
        <div class="jumbotron">
            <div class="container">
                <h1><?= $this->title ?></h1>
                <p><?= \Yii::t('admin/login', 'error_access_denied_message') ?></p>
                <p>
                    <a class="btn btn-success btn-lg"
                       href="/admin/login"><?= \Yii::t('admin/login', 'button_to_login_form') ?></a>
                    <a class="btn btn-primary btn-lg"
                       href="<?= \yii\helpers\Url::previous('previous') ?>"><?= \Yii::t('admin/login', 'button_go_back') ?></a>
                </p>
            </div>
        </div>
    </div>
</div>