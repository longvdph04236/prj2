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
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '130033160929313',
            xfbml      : true,
            version    : 'v2.10'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<header class="transparent-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 clearfix">
                <div class="center-logo">
                    <a href="<?= Url::toRoute('home/') ?>"><img src="<?= Yii::getAlias('@web')?>/img/logo.png" alt=""></a>
                </div>
                <div class="pull-left">
                    <nav id="main-nav">
                        <ul class="clearfix">
                            <li><a href="<?= Url::toRoute('home/') ?>">Trang chủ</a></li>
                            <li><a href="<?= Url::toRoute('danh-sach-san/') ?>">Danh sách sân</a></li>
                            <li><a href="<?= Url::toRoute('tim-doi/') ?>">Tìm đối</a></li>
                            <li><a href="<?= Url::toRoute('ve-chung-toi/') ?>">Về chúng tôi</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="pull-right">
                    <ul id="right-nav" class="clearfix">
                        <li><a href="<?= Url::toRoute('user/dang-ky') ?>"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                        <li><a href="#" id="login-a-btn" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="big-title">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo isset($this->params['big-title'])? $this->params['big-title']:''?></h2>
                <?=
                Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Trang chủ'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                   ]) 
                ?>
            </div>
        </div>
    </div>
</div>
<main>
    <div class="container">

            <?= $content; ?>

    </div>
</main>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="footer-col-heading">
                    <h4>Về chúng tôi</h4>
                </div>
                <div class="footer-col-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut distinctio earum eligendi fuga hic illum libero, magnam nobis porro provident quaerat quibusdam quos sed similique voluptatem? Ducimus ex nisi rerum?</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-col-heading">
                    <h4>Danh mục</h4>
                </div>
                <div class="footer-col-content">
                    <ul class="ul-flex-item">
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Danh sách sân</a></li>
                        <li><a href="#">Tìm đối thủ</a></li>
                        <li><a href="#">Tra cứu mã đặt sân</a></li>
                        <li><a href="#">Đăng ký</a></li>
                        <li><a href="#">Đăng nhập</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-col-heading">
                    <h4>Liên hệ</h4>
                </div>
                <div class="footer-col-content contact-col">
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> contact@yeubongda.com</p>
                    <p><i class="fa fa-phone" aria-hidden="true"></i> 0987 654 321</p>
                    <p><i class="fa fa-globe" aria-hidden="true"></i> www.yeubongda.com</p>
                    <p>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-google-plus"></i></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                Copyright © www.yeubongda.com. All rights reserved.
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
