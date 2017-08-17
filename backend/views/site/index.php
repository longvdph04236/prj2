<?php
use backend\models\Users;
use backend\models\City;
use backend\models\District;
use backend\models\Comments;
use backend\assets\AppAsset;
AppAsset::register($this);

$countUser = Users::find()->count();
$countCity = City::find()->count();
$countDistrict = District::find()->count();
$countComment = Comments::find()->count();

$host = 'http://'.$_SERVER['HTTP_HOST'];
$homeUrl = yii::$app->urlManager->baseUrl;
$this->title = 'Admin system';
?>
<div class="row index-admin">
    <div class="col-md-3">
        <a  title="Quản lý User" href="<?=$host.$homeUrl?>/user/index" class="tile-box tile-box-shortcut btn-danger">

            <div class="title-header"><i class="fa fa-users" aria-hidden="true"></i> User</div>
            <span class="bs-badge badge-absolute"><?= $countUser?></span>
        </a>
    </div>
    <div class="col-md-3">
        <a  title="Quản lý Khu vực" href="<?=$host.$homeUrl?>/city/index" class="tile-box tile-box-shortcut btn-success">

            <div class="title-header"><i class="fa fa-globe"></i> City</div>
            <span class="bs-badge badge-absolute"><?= $countCity?></span>

        </a>
    </div>
    <div class="col-md-3">
        <a  title="Quản Lý Khu vực" href="<?=$host.$homeUrl?>/district/index" class="tile-box tile-box-shortcut btn-info">

            <div class="title-header"><i class="fa fa-map-signs"></i> District</div>
            <span class="bs-badge badge-absolute"><?= $countDistrict?></span>

        </a>
    </div>
    <div class="col-md-3">
        <a title="Quản lÝ Comments" href="<?=$host.$homeUrl?>/comment/index" class="tile-box tile-box-shortcut btn-primary">

            <div class="title-header"><i class="fa fa-comments" aria-hidden="true"></i> Comments</div>
            <span class="bs-badge badge-absolute"><?= $countComment?></span>

        </a>
    </div>
</div>
