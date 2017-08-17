<?php
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
$user = \common\models\User::findOne(Yii::$app->user->identity->getId());
$stadium_count = count($user->stadiums);
?>
<div class="row">
    <div class="col-md-12">
        <span>Bạn hiện có <b><?=$stadium_count?></b> sân bóng</span> <a href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/them-moi']) ?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Thêm mới</button></a>
        <?php
        if($stadium_count != 0){
            ?>
            <hr>
            <ul class="stadium-list">
            <?php
            $stadiums = \common\models\Stadiums::find()->where(['manager_id'=>Yii::$app->user->identity->getId()])->all();
            foreach ($stadiums as $stadium){
                $d = \common\models\District::findOne($stadium['district_id']);
                $c = \common\models\City::findOne($d->getAttribute('city_id'));
                ?>
                <li class="row">
                    <div class="thumb-container col-md-3">
                        <img src="<?= Yii::getAlias('@web') ?>/img/002.png" alt="">
                    </div>
                    <div class="stadium-info col-md-9">
                        <h3><a href="<?= \yii\helpers\Url::toRoute(['san-bong/chi-tiet/'.$stadium['id']]) ?>"><?= $stadium['name']?></a></h3>
                        <p><b><i class="fa fa-map-marker"></i> Địa chỉ:</b> <?= $stadium['address'] ?></p>
                        <p><b><i class="fa fa-map-signs"></i> Quận/huyện:</b> <?= $d->getAttribute('name') ?></p>
                        <p><b><i class="fa fa-globe"></i> Tỉnh/thành phố:</b> <?= $c->getAttribute('name') ?></p>
                    </div>
                    <div class="action-group">
                        <a href="<?= \yii\helpers\Url::toRoute(['san-bong/chi-tiet/'.$stadium['id']]) ?>"><button class="btn btn-primary">Xem chi tiết</button></a>
                        <a href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/xoa','id'=>$stadium['id']]) ?>"><button class="btn btn-danger">Xóa</button></a>
                    </div>
                </li>
        <?php
            }
            echo '</ul>';
        }
        ?>
    </div>
</div>
