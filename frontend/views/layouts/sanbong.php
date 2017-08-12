<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php $this->beginContent('@app/views/layouts/header.php'); ?>
<?php $this->endContent(); ?>
<div class="big-title with-location">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 has-right-btn">

                    <h2><?php echo isset($this->params['big-title'])? $this->params['big-title']:''?></h2>
                    <p><i class="fa fa-map-marker"></i><?php echo isset($this->params['location'])? $this->params['location']:''?></p>

                    <?php
                    $logged_user = \common\models\User::findOne(Yii::$app->user->identity->getId());
                    if($logged_user->type == 'manager'){
                        ?>
                        <a class="right-btn" href="<?= Url::toRoute(['san-bong/sua','id'=>$this->params['id-san']])?>"><button class="btn btn-success"><i class="fa fa-pencil"></i> Sửa thông tin</button></a>
                    <?php
                    } else {
                        ?>
                        <button id="book-a-btn" data-toggle="modal" data-target="#bookModal" class="btn btn-success right-btn"><i class="fa fa-ticket"></i> Đặt sân</button>
                        <?php
                    }
                    ?>

            </div>
        </div>
    </div>
</div>
<main>
            <?= $content; ?>

</main>
<?php $this->beginContent('@app/views/layouts/footer.php'); ?>
<?php $this->endContent(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
