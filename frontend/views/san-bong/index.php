<?php
/* @var $this yii\web\View */
use kartik\rating\StarRating;
use edofre\sliderpro\models\Slide;
use edofre\sliderpro\models\slides\Caption;
use edofre\sliderpro\models\slides\Image;
use edofre\sliderpro\models\slides\Layer;

?>
<div class="container">
    <div class="row">
        <div class="col-md-6 contact-info">
            <h3>Thông tin liên hệ</h3>
            <hr>
            <p><b><i class="fa fa-globe"></i> Tỉnh/thành phố:</b> <?= $info['city']?></p>
            <p><b><i class="fa fa-map-signs"></i> Quận/huyện:</b> <?= $info['district']?></p>
            <p><b><i class="fa fa-phone"></i> Số điện thoại:</b> <?= $info['stadium']['phone']?></p>
            <p><b><i class="fa fa-star-half-o"></i> Đánh giá:</b> <?= StarRating::widget([
                    'name' => 'rate',
                    'pluginOptions' => [
                        'showClear'=>false,
                        'theme' => 'krajee-fa',
                        'step' => 0.1,
                        'readonly' => false,
                        'size' => 'xs',
                        'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                        'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                        'min' => 0,
                        'max' => 5,
                        'showCaption' => false
                    ],
                    'value' => $info['stadium']['rate'],
                ]);?></p>
            <p><b><i class="fa fa-certificate"></i> Mô tả:</b></p>
            <p><?= $info['stadium']['description']?></p>
        </div>
        <div class="col-md-6 photo-slider">
            <h3>Ảnh sân bóng</h3>
            <hr>
            <?php
            $photo_list = explode(',',$info['stadium']['photos']);
            $items = array();
            $thumbnails = array();
            foreach ($photo_list as $photo){
                $i = new Slide([
                    'items' => [
                        new Image(['src' => Yii::$app->params['appFolder'].'/uploads/images/'.$photo]),
                    ],
                ]);

                $thumbnails[] =
                    new \edofre\sliderpro\models\Thumbnail([
                        'tag' => 'img',
                        'htmlOptions' => ['src' => Yii::$app->params['appFolder'].'/uploads/images/'.$photo, 'data-src' => Yii::$app->params['appFolder'].'/uploads/images/'.$photo]]);
                $items[] = $i;
            }
            echo \edofre\sliderpro\SliderPro::widget([
                'id'            => 'my-slider',
                'slides'        => $items,
                'thumbnails'    => $thumbnails,
                'sliderOptions' => [
                    'width'  => 960,
                    'height' => 500,
                    'arrows' => true,
                    'fade' => true,
                    'init'   => new \yii\web\JsExpression("
                        function() {
                            console.log('slider is initialized');
                        }
                    "),
                ],
            ]);

            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Số sân bóng: <?= count($info['stadium']['fields'])?> sân</h3>
        </div>
    </div>
</div>
