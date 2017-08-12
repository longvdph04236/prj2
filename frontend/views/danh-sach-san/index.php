<?php
    Use frontend\assets\DanhSachSanAsset;
    DanhSachSanAsset::register($this);

    $this->params['breadcrumbs'][] = ['label'=>$this->params['big-title'],'url'=>'index'];
?>
<div class="row">
    <div class="col-md-12">
        <ul class="list-stadium flex">
            <?php
                foreach($model as $item) {
                    $d = \common\models\District::findOne($item['district_id']);
                    $c = \common\models\City::findOne($d->getAttribute('city_id'));
                ?>
                    <li class="row">
                        <div class="thumb-content col-md-3">
                            <img src="<?= Yii::getAlias('@web') ?>/img/002.png" alt="">
                        </div>
                        <div class="stadium-info col-md-9">
                            <h3><a href="<?= \yii\helpers\Url::toRoute(['san-bong/chi-tiet/'.$item['id']]) ?>"><?= $item['name']?></a></h3>
                            <p><b><i class="fa fa-map-marker"></i> Địa chỉ:</b> <?= $item['address'] ?></p>
                            <p><b><i class="fa fa-mobile"></i> Số điện thoại:</b> <?= $item['phone'] ?></p>
                            <p><b><i class="fa fa-map-signs"></i> Quận/huyện:</b> <?= $d->getAttribute('name') ?></p>
                            <p><b><i class="fa fa-globe"></i> Tỉnh/thành phố:</b> <?= $c->getAttribute('name') ?></p>
                            <p><b><i class="fa fa-star-half-o"></i> Đánh Giá:</b> <?= $d->getAttribute('name') ?></p>
                        </div>
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>
