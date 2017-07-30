<?php
use yii\helpers\Url;
?>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '130033160929313',
            xfbml      : true,
            version    : 'v2.10'
        });
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                console.log(response.authResponse);
            } else if (response.status === 'not_authorized') {
                console.log('not_auth');
            } else {
                console.log('user not login to fb');
            }
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
<header>
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
                        <?php
                        if(Yii::$app->user->isGuest) {
                            ?>
                            <li><a href="" id="login-a-btn" data-toggle="modal" data-target="#loginModal"><i
                                        class="fa fa-sign-in"></i> Đăng nhập</a></li>
                            <li><a class="btn btn-default" href="<?= Url::toRoute('user/dang-ky') ?>"><i class="fa fa-user-plus"></i> Đăng
                                    ký</a></li>
                            <?php
                        } else {
                            $user = \common\models\User::findIdentity(Yii::$app->user->identity);
                            ?>
                            <li><a href=""><i class="fa fa-user"></i> <?= $user->fullname?></a></li>
                            <li><a href="<?= Url::toRoute('user/dang-xuat')?>"><i
                                        class="fa fa-sign-out"></i> Đăng xuất</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>