<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use common\models\City;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Welcome</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 three">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#by-time" aria-controls="home" role="tab" data-toggle="tab">Tìm kiếm theo giờ</a></li>
                    <li role="presentation"><a href="#by-name" aria-controls="home" role="tab" data-toggle="tab">Tìm kiếm theo tên</a></li>
                    <li role="presentation"><a href="#by-id" aria-controls="home" role="tab" data-toggle="tab">Tra mã đặt sân</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="by-time">
                        <?php $btForm = ActiveForm::begin([
                            'id' => 'by-time-form',
                            'layout' => 'horizontal',
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => true,
                            'validateOnBlur' => true,
                            'validationUrl' => \yii\helpers\Url::toRoute('home/ajax-validate-bt'),
                            'fieldConfig' => [
                                'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'offset' => 'col-sm-offset-0',
                                    'wrapper' => 'col-sm-12',
                                    'error' => '',
                                    'hint' => '',
                                ],
                            ],
                        ]); ?>
                        <div class="row">
                            <div class="col-md-2">
                                <?= $btForm->field($TimeModel,'date')->input('date')->label(false) ?>
                            </div>
                            <div class="col-md-2">
                                <?php
                                foreach(\common\models\Pricing::getTableSchema()->getColumn('time_range')->enumValues as $value){
                                    $time_range_custom[$value]=$value;
                                }
                                ?>

                                <?= $btForm->field($TimeModel,'time')->dropDownList($time_range_custom)->label(false);?>
                            </div>
                            <div class="col-md-3">
                                <?= $btForm->field($TimeModel, 'city',['validateOnChange'=>true])->input('text',['list'=>'city','placeholder' => 'Chọn tỉnh/thành phố'])->label(false) ?>
                                <datalist id="city" data-href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/get-district'])?>">
                                    <?php
                                    $cities = City::find()->all();
                                    foreach ($cities as $city){
                                    ?>
                                    <option value="<?=$city['name']?>">
                                        <?php
                                        }
                                        ?>
                                </datalist>
                            </div>
                            <div class="col-md-3">
                                <?= $btForm->field($TimeModel, 'district')->input('text',['list'=>'district','placeholder' => 'Chọn quận/huyện'])->label(false) ?>
                                <datalist id="district" class="district">

                                </datalist>
                            </div>
                            <div class="col-md-2">
                                <?= \yii\helpers\Html::button('Tìm kiếm', ['type' => 'submit', 'name' => 'find-time', 'class' => 'btn btn-primary', 'value' => 'OK']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end()?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="by-name">
                        <?php $bnForm = ActiveForm::begin([
                            'id' => 'by-name-form',
                            'layout' => 'horizontal',
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => true,
                            'validateOnBlur' => true,
                            'validationUrl' => \yii\helpers\Url::toRoute('home/ajax-validate-bn'),
                            'fieldConfig' => [
                                'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'offset' => 'col-sm-offset-0',
                                    'wrapper' => 'col-sm-12',
                                    'error' => '',
                                    'hint' => '',
                                ],
                            ],
                        ]); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $bnForm->field($NameModel, 'name')->textInput(['placeholder' => 'Tên sân bóng'])->label(false) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $bnForm->field($NameModel, 'city',['validateOnChange'=>true])->input('text',['list'=>'city','placeholder' => 'Chọn tỉnh/thành phố'])->label(false) ?>
                                <datalist id="city" data-href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/get-district'])?>">
                                    <?php
                                    $cities = City::find()->all();
                                    foreach ($cities as $city){
                                    ?>
                                    <option value="<?=$city['name']?>">
                                        <?php
                                        }
                                        ?>
                                </datalist>
                            </div>
                            <div class="col-md-2">
                                <?= $bnForm->field($NameModel, 'district')->input('text',['list'=>'district1','placeholder' => 'Chọn quận/huyện'])->label(false) ?>
                                <datalist id="district1" class="district">

                                </datalist>
                            </div>
                            <div class="col-md-2">
                                <?= \yii\helpers\Html::button('Tìm kiếm', ['type' => 'submit', 'name' => 'find-name', 'class' => 'btn btn-primary', 'value' => 'OK']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end()?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="by-id">
                        <?php $findCodeForm = ActiveForm::begin([
                            'id' => 'find-code-form',
                            'layout' => 'horizontal',
                            'enableClientValidation' => true,
                            'validateOnBlur' => true,
                            'fieldConfig' => [
                                'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                'horizontalCssClasses' => [
                                    'offset' => 'col-sm-offset-0',
                                    'wrapper' => 'col-sm-12',
                                    'error' => '',
                                    'hint' => '',
                                ],
                            ],
                        ]); ?>
                        <div class="row">
                            <div class="col-md-10">
                                <?= $findCodeForm->field($FindCode, 'code')->textInput(['placeholder' => 'Mã đặt sân'])->label(false) ?>
                            </div>
                            <div class="col-md-2">
                                <?= \yii\helpers\Html::button('Tìm kiếm', ['type' => 'submit', 'name' => 'find-code', 'class' => 'btn btn-primary', 'value' => 'OK']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>