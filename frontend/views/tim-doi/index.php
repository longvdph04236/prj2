<?php
    use yii\bootstrap\ActiveForm;
    use backend\models\City;
    use kartik\rating\StarRating;
    use yii\helpers\Html;
    use kartik\file\FileInput;
    use conquer\toastr\ToastrWidget;
    use yii\widgets\LinkPager;

    if(Yii::$app->session->has('success')) {
        ToastrWidget::widget(['message'=>Yii::$app->session->getFlash('success',true)]);
    }

    $this->params['breadcrumbs'][] = ['label'=>$this->params['big-title'],'url'=>'tim-doi/index'];
?>
<div class="row">
    <div id="timdoi">
        <div class="filter-fc col-md-3">
            <?php $form = ActiveForm::begin([
                'id' => 'filter-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'validateOnBlur' => true,
                'validationUrl' => \yii\helpers\Url::toRoute('tim-doi/ajax-validate')
            ]); ?>
                <?= $form->field($model,'name')->textInput(['placeholder'=>'Tên sân bóng...'])?>
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
            <datalist id="district">

            </datalist>
            <?php
                $type = \common\models\Field::getTableSchema()->getColumn('field_type');
                $checkbox = [];
                foreach ($type->enumValues as $value ) {
                    $checkbox[] = 'Sân '.$value.' người';
                }
            ?>
            <?= $form->field($model, 'type')->checkboxList($checkbox)->label('Loại sân là:') ?>
            <?= $form->field($model,'price')->input('range')?>
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
            <div class="text-center">
                <?= Html::SubmitButton('<i class="fa fa-search"></i>Tìm Kiếm',['class'=>'btn btn-success'])?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="list-fc col-md-9">
            <?php
                if(!Yii::$app->user->isGuest) { ?>
                    <?php $form1 = ActiveForm::begin([
                        'id' => 'find-fc-form',
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'validateOnBlur' => true,
                        'validationUrl' => \yii\helpers\Url::toRoute(['tim-doi/ajax-validate-fc'])
                    ]); ?>
                    <h2 class="clearfix"><i class="fa fa-clipboard" aria-hidden="true"></i>Đăng tin tìm đối
                        <?= Html::button('<i class="fa fa-plus"></i> Đăng Tin',['type'=> 'submit', 'class'=> 'btn btn-success  pull-right']) ?>
                    </h2>

                    <div class="row input-line">
                        <?= $form1->field($modelForm,'img')->widget(FileInput::ClassName(),[
                            'options' => ['accept' => 'image/*', 'multiple' => true],
                        ])->label('Ảnh đội bóng:');?>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <?= $form1->field($modelForm,'fc_name')->textInput(['placeholder'=>'Tiêu đề bài viết'])->label('Tiêu đề:')?>
                        </div>

                        <div class="col-md-4">
                            <?= $form1->field($modelForm,'kickoff')->input('datetime-local',['placeholder'=>'chọn ngày 
                            đấu'])->label
                            ('Ngày: ')?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form1->field($modelForm,'phone')->input('phone',['placeholder'=>'Nhập số điện thoại'])->label('Số điện thoại:')?>
                        </div>
                        <div class="col-md-4">
                            <?= $form1->field($modelForm, 'city',['validateOnChange'=>true])->input('text',
                                ['list'=>'city','placeholder' => 'Chọn tỉnh/thành phố'])->label('Tỉnh/thành phố:') ?>
                            <datalist id="city" data-href="<?= \yii\helpers\Url::toRoute(['tim-doi/get-district'])?>">
                                <?php
                                $cities = City::find()->all();
                                foreach ($cities as $city){
                                ?>
                                    <option value="<?=$city['id']?>"><?= $city['name']?></option>
                                    <?php
                                    }
                                    ?>
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <?= $form1->field($modelForm, 'district_id')->input('text',
                                ['list'=>'district_id','placeholder' => 'chọn Quận/Huyện'])->label('Quận/Huyện:') ?>
                            <datalist id="district_id" class="district">

                            </datalist>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form1->field($modelForm,'rented')->inline(true)->radioList(['yes'=>'có','no'=>'không'])->label('Đã có sân:'); ?>
                        </div>

                        <div class="col-md-8">
                            <?= $form1->field($modelForm, 'field_type')->inline(true)->radioList(['5'=>'sân 5 người','7'=>'sân 7 người','11'=>'sân 11 người'])
                                ->label
                            ('Loại sân 
                        là:') ?>
                        </div>
                    </div>

                    


                    <div class="row input-line">
                        <?= $form1->field($modelForm, 'description')->textarea()->label('Mô tả:') ?>
                    </div>
                    <?php ActiveForm::end()?>
           <?php } ?>

            <div class="total-find">
                <ul class="row">
                    <h2 class="clearfix"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Tin tìm đối</h2>
                        <?php

                        foreach ($show as $value){
                            $d = \common\models\District::findOne($value['district_id']);
                            $c = \common\models\City::findOne($d->getAttribute('city_id'));
                        ?>
                            <li class="row">
                                <div class="thumb-container col-md-4">
                                    <img src="<?= Yii::$app->params['appFolder'].'/uploads/images/'.$value['photo'];
                                    ?>" alt="" width="100%" height="200" >
                                </div>
                                <div class="stadium-info col-md-6">
                                    <h3><a href="#"><?= $value['fc_name']?></a></h3>
                                    <p><b><i class="fa fa-map-signs"></i> Quận/huyện:</b> <?= $d->getAttribute('name') ?></p>
                                    <p><b><i class="fa fa-globe"></i> Tỉnh/thành phố:</b> <?= $c->getAttribute('name') ?></p>
                                    <p><b><i class="fa fa-calendar-o"></i> Lịch Đấu:</b> <?= $value['kickoff'] ?></p>
                                    <p><b><i class="fa fa-check-square" ></i> Đã thuê sân:</b> <?= ($value['rented']=='yes') ? 'Đã có sân' : 'Chưa có sân'; ?></p>
                                    <p><b><i class="fa fa-users"></i> Đấu :</b> <?= 'đội '. $value['field_type'] . ' người'; ?></p>
                                    <p><b><i class="fa fa-commenting"></i> Ghi chú:</b> <?= strip_tags($value['description']);?></p>
                                </div>
                                <div class="phone col-md-2">
                                    <button class="btn btn-primary"><i class="fa fa-phone" aria-hidden="true"></i><?= $value['phone']?></button>
                                </div>
                            </li>
                            <?php
                        }
                        echo '</ul>';
                        ?>

                    </ul>
                </div>
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
</div>
