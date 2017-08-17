<?php
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
use yii\bootstrap\ActiveForm;
use backend\models\City;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\web\JsExpression;
?>
<div class="row">
    <div id="timdoi">
        <div class="filter-fc col-md-3">
            <?php $form = ActiveForm::begin([
                'id' => 'filter-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'validateOnBlur' => true,
                'validationUrl' => \yii\helpers\Url::toRoute(['home/ajax-validate'])
            ]); ?>
            <?= $form->field($model, 'city',['validateOnChange'=>true])->input('text',['list'=>'city','placeholder' => 'Chọn tỉnh/thành phố'])->label('Tỉnh/thành phố:') ?>
            <datalist id="city" data-href="<?= \yii\helpers\Url::toRoute(['tim-doi/get-district'])?>">
                <?php
                $cities = City::find()->all();
                foreach ($cities as $city){
                ?>
                <option value="<?=$city['name']?>">
                    <?php
                    }
                    ?>
            </datalist>
            <?= $form->field($model, 'district')->input('text',['list'=>'district','placeholder' => 'Chọn quận/huyện'])->label('Quận/huyện:') ?>
            <datalist id="district" class="district">

            </datalist>
            <?php
            $type = \common\models\Field::getTableSchema()->getColumn('field_type');
            $checkbox = [];
            foreach ($type->enumValues as $value ) {
                $checkbox[$value] = 'Sân '.$value.' người';
            }
            ?>
            <?= $form->field($model, 'type')->checkboxList($checkbox)->label('Loại sân là:') ?>
            <?= $form->field($model,'rating')->widget(StarRating::Classname(),[
                'name' => 'rating',
                'pluginOptions' => [
                    'showClear'=>true,
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

            ]);?>
            <?= $form->field($model,'res')->hiddenInput(['value'=>$lid])->label(false) ?>
            <div class="text-center">
                <?= Html::SubmitButton('<i class="fa fa-search"></i>Tìm Kiếm',['class'=>'btn btn-success','name'=>'filter-option','value'=>'OK'])?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="list-stadium col-md-9">
            <ul class="list-stadium flex">
                <?php
                if(count($articles) == 0){
                    echo 'Không có kết quả tìm kiếm phù hợp';
                } else {
                foreach($articles as $item) {

                    $d = \common\models\District::findOne($item['district_id']);
                    $c = \common\models\City::findOne($d->getAttribute('city_id'));
                    ?>
                    <li>
                        <div class="row">
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
                                    <?php
                                    if(isset($result)){
                                    ?>
                                    <p><b><i class="fa fa-dot-circle-o"></i> Tình trạng:</b><strong class="text-success"><i>Còn <?= $result[$item['id']] ?> sân trống</i></strong></p>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="text-center">
        <?=
        LinkPager::widget([
            'pagination' => $pagination
        ]);
        ?>
    </div>

</div>
