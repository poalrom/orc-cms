<?php
/* @var $exception \yii\web\HttpException|\Exception */
$handler = new \yii\web\ErrorHandler();
if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
} else {
    $code = $exception->getCode();
}
$name = $handler->getExceptionName($exception);
if ($name === null) {
    $name = 'Error';
}
if ($code) {
    $name .= " (#$code)";
}
if ($exception instanceof \yii\base\UserException) {
    $message = $exception->getMessage();
} else {
    $message = 'An internal server error occurred.';
}
if (method_exists($this, 'beginPage')) {
    $this->beginPage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $handler->htmlEncode($name) ?></title>
</head>

<body>
<div class="container-fluid error-page">
<!--noindex-->
    <div class="col-sm-12">
    <h1>Упс! Кажется Вы ошиблись </h1>

    <a href="/" class="button cancel">Вернуться</a>
    <img src="../img/error-page.png" alt="">
    </div>

    <?php
    if (method_exists($this, 'endBody')) {
        $this->endBody(); // to allow injecting code into body (mostly by Yii Debug Toolbar)
    }
    ?>
<!--/noindex-->
</div>
</body>
</html>
<?php
if (method_exists($this, 'endPage')) {
    $this->endPage();
}