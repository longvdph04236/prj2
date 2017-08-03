<?php
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
$user = \common\models\User::findOne(Yii::$app->user->identity->getId());
$stadium_count = count($user->stadiums);
?>
<div class="row">
    <div class="col-md-12">
        <b>Bạn hiện có <?=$stadium_count?> sân bóng</b> <a href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/them-moi']) ?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Thêm mới</button></a>
    </div>
</div>
