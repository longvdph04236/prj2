<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\HomeAsset;
use yii\helpers\Url;
use common\models\Schedule;
use common\models\Stadiums;

AppAsset::register($this);
HomeAsset::register($this);
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

    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            FB.api('/me?fields=name,picture,email', function(response) {
                $.ajax({
                    url: '<?= Url::toRoute('user/fb')?>',
                    data: {id:response.id, name: response.name, email: response.email, ava: response.picture.data.url},
                    method: 'Post',
                    success: function(data){
                        if(data){
                            window.location.reload();
                        } else {
                            window.location.href = '<?= Url::toRoute(['user/dang-ky'])?>'
                        }
                    }
                })
            });
        } else if (response.status === 'not_authorized') {
            console.log('not_auth');
        } else {
            console.log('user not login to fb');
        }
    }

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>
<div class="full-screen">
    <div id="background_video" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=fYlaY14BhsM',containment:'#background_video',quality:'hd720',startAt:39.7,mute:true,autoPlay:true,loop:true,opacity:1}"></div>
    <div class="bg-full-screen"></div>
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
                            <?php
                            if(Yii::$app->user->isGuest) {
                                ?>
                                <li><a href="" id="login-a-btn" data-toggle="modal" data-target="#loginModal"><i
                                                class="fa fa-sign-in"></i> Đăng nhập</a></li>
                                <li><a class="btn btn-default" href="<?= Url::toRoute('user/dang-ky') ?>"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                                <?php
                            } else {
                                $user = \common\models\User::findIdentity(Yii::$app->user->identity->getId());
                                if(substr($user->avatar,0,8) == 'https://'){
                                    $link = $user->avatar;
                                } else {
                                    $link = Yii::$app->params['appFolder'].'/uploads/images/'.$user->avatar;
                                }
                                ?>
                                <li class="has-sub"><a href="<?= Url::toRoute('user/') ?>"><span class="header-user-photo"><img src="<?= $link ?>" alt=""></span> <?= $user->fullname?></a>
                                    <ul class="sub-menu ">
                                        <li><a href="<?= Url::toRoute('user/index')?>"><i class="fa fa-pencil"></i>Chỉnh sửa thông tin</a></li>
                                        <li><a href="<?= Url::toRoute('user/dang-xuat')?>"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                                    </ul>
                                </li>
                                <li class="li-notify"><a title="Thông báo" href="<?= Url::toRoute('thong-bao/') ?>"><i class="fa fa-bell" aria-hidden="true"></i><span class="badge"><?php
                                            if($user->type == 'manager'){
                                                $stadiums = Stadiums::findAll(['manager_id'=>$user->id]);
                                                $fid = array();
                                                foreach ($stadiums as $stadium){
                                                    $fields = $stadium['fields'];
                                                    foreach ($fields as $field){
                                                        $fid[] = $field['id'];
                                                    }
                                                }

                                                $query = Schedule::find()->where(['in','field_id',$fid])->andWhere(['status'=>'new'])->count();
                                            } else {
                                                $query = Schedule::find()->where(['user_id'=>$user->id,'status'=>'new'])->count();
                                            }
                                            echo $query;
                                            ?></span></a></li>
                                <?php
                                if($user->type == 'manager'){
                                    ?>
                                <li><a class="btn btn-default" href="<?= Url::toRoute('quan-ly-san/') ?>">Quản lý sân bóng</a></li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">
                        Copyright &copy; www.yeubongda.com. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Đăng nhập</h4>
            </div>
            <div class="modal-body">
                <div class="login-form-container">
                    <div class="fb-login-button" data-width="300" data-scope="email, public_profile" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                    <span>hoặc</span>
                    <div class="login-form-2" data-content="<?= Url::toRoute('user/dang-nhap',true)?>">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
