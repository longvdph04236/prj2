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
            $type = \common\models\Schedule::getTableSchema()->getColumn('time_range');
            $time_range = [];
            foreach ($type->enumValues as $value ) {
                $time_range[$value] = $value;
            }
            ?>
            <?= $form->field($model, 'time')->dropDownList($time_range,['prompt'=>'Chọn khung giờ'])->label('Khung giờ:') ?>
            <?= $form->field($model, 'date')->input('date')->label('Ngày:') ?>
            <?php
                $type = \common\models\Field::getTableSchema()->getColumn('field_type');
                $checkbox = [];
                foreach ($type->enumValues as $value ) {
                    $checkbox[$value] = 'Sân '.$value.' người';
                }
            ?>
            <?= $form->field($model, 'type')->checkboxList($checkbox)->label('Loại sân là:') ?>

            <div class="text-center">
                <?= Html::SubmitButton('<i class="fa fa-search"></i> Tìm Kiếm',['class'=>'btn btn-success','name'=>'filter-option', 'value'=>'OK'])?>
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
                    <h2 class="clearfix"><i class="fa fa-clipboard" aria-hidden="true"></i>Đăng tin tìm đối tác
                        <?= Html::button('<i class="fa fa-plus"></i> Đăng Tin',['type'=> 'submit','name' =>'post-tin', 'class'=> 'btn btn-success  pull-right']) ?>
                    </h2>

                    <div class="row input-line">
                        <?= $form1->field($modelForm,'img')->widget(FileInput::ClassName(),[
                            'options' => ['accept' => 'image/*'],
                        ])->label('Ảnh đội bóng:');?>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <?= $form1->field($modelForm,'fc_name')->textInput(['placeholder'=>'Tên đội bóng'])->label('Tên đội bóng:')?>
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
                <ul>
                    <h2 class="clearfix"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Tin tìm đối tác</h2>
                        <?php

                        if(empty($show)){
                            echo 'Không có tin bắt kèo nào phù hợp với tìm kiếm';
                        } else {

                            foreach ($show as $value) {
                                $d = \common\models\District::findOne($value['district_id']);
                                $c = \common\models\City::findOne($d->getAttribute('city_id'));
                                ?>
                                <li>
                                    <div class="row">
                                        <div class="thumb-container col-md-4">
                                            <img src="<?= Yii::$app->params['appFolder'] . '/uploads/images/' . $value['photo'];
                                            ?>" alt="" width="100%" height="200">
                                        </div>
                                        <div class="stadium-info col-md-6">
                                            <h3><a href="#"><?= $value['fc_name'] ?></a></h3>
                                            <p><b><i class="fa fa-map-signs"></i>
                                                    Quận/huyện:</b> <?= $d->getAttribute('name') ?></p>
                                            <p><b><i class="fa fa-globe"></i> Tỉnh/thành
                                                    phố:</b> <?= $c->getAttribute('name') ?></p>
                                            <p><b><i class="fa fa-calendar-o"></i> Lịch
                                                    Đấu:</b> <?= date('H:i:s d-m-Y', strtotime($value['kickoff'])) ?>
                                            </p>
                                            <p><b><i class="fa fa-check-square"></i> Đã thuê
                                                    sân:</b> <?= ($value['rented'] == 'yes') ? 'Đã có sân' : 'Chưa có sân'; ?>
                                            </p>
                                            <p><b><i class="fa fa-users"></i> Đấu
                                                    :</b> <?= 'đội ' . $value['field_type'] . ' người'; ?></p>
                                            <p><b><i class="fa fa-commenting"></i> Ghi
                                                    chú:</b> <?= strip_tags($value['description']); ?></p>
                                        </div>
                                        <div class="phone col-md-2">
                                            <?php
                                            $now = date('Y-m-d H:i:s');
                                            if($now > $value['kickoff']){
                                                ?>
                                                <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Hết hạn</button>
                                                <?php
                                            } else {
                                                ?>
                                                <button class="btn btn-success"><i class="fa fa-phone"
                                                                                   aria-hidden="true"></i><?= $value['phone'] ?>
                                                </button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        }
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
