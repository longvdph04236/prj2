<?php
    use kartik\rating\StarRating;
    use yii\web\JsExpression;

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
                            <div class="flex-box">
                                <p><b><i class="fa fa-map-signs"></i> Quận/huyện:</b><?= $d->getAttribute('name') ?></p>
                                <p><b><i class="fa fa-globe"></i> Tỉnh/thành phố:</b><?= $c->getAttribute('name') ?></p>
                                <p><b><i class="fa fa-mobile"></i> Số điện thoại:</b><?= $item['phone'] ?></p>
                                <p><b><i class="fa fa-star-half-o"></i> Đánh Giá:</b><?= StarRating::widget([
                                        'name' => 'rate',
                                        'pluginOptions' => [
                                            'showClear'=>false,
                                            'theme' => 'krajee-fa',
                                            'step' => 0.1,
                                            'readonly' => true,
                                            'size' => 'xs',
                                            'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                                            'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                                            'min' => 0,
                                            'max' => 5,
                                            'showCaption' => false,
                                            'clearCaption' => 'Chưa đánh giá',
                                            'starCaptionClasses' => new JsExpression("function(val) {
                                if (val == 0) {
                                   return 'label label-default';
                                }
                                else if (val > 0 && val < 2) {
                                    return 'label label-danger';
                                } 
                                else if (val >= 2 && val < 3) {
                                    return 'label label-info';
                                } 
                                else if(val >= 3 && val < 4) {
                                    return 'label label-primary';
                                } 
                                else if(val >= 4){
                                    return 'label label-success';
                                }
                            }"),
                                            'starCaptions' => new JsExpression("function(val){return val == 1 ? '1 điểm' : val + ' điểm';}")
                                        ],
                                        'value' => ($item['count_rate'] != 0)? $item['rate']/$item['count_rate'] : 0,
                                    ]);?></p>
                        </div>
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>
