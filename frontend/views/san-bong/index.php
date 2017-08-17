<?php
/* @var $this yii\web\View */
use kartik\rating\StarRating;
use edofre\sliderpro\models\Slide;
use edofre\sliderpro\models\slides\Image;
use common\models\Schedule;
use yii\web\JsExpression;
use common\models\Comments;
use yii\bootstrap\ActiveForm;
use conquer\toastr\ToastrWidget;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
\frontend\assets\SanBongAsset::register($this);
if(Yii::$app->session->has('s')){
    ToastrWidget::widget(['message'=>Yii::$app->session->getFlash('s')]);
}
if(Yii::$app->session->has('f')){
    ToastrWidget::widget(['type'=>'error','message'=>Yii::$app->session->getFlash('f')]);
}
ini_set('max_execution_time', 300);
if(!Yii::$app->user->isGuest)
{
    $logged_user = \common\models\User::findOne(Yii::$app->user->identity->getId());
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 contact-info">
            <h3><i class="fa fa-info-circle" aria-hidden="true"></i> Thông tin liên hệ</h3>
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
                        'readonly' => true,
                        'size' => 'xs',
                        'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                        'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                        'min' => 0,
                        'max' => 5,
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
                    'value' => ($info['stadium']['count_rate'] != 0)? $info['stadium']['rate']/$info['stadium']['count_rate'] : 0,
                ]);?></p>
        </div>
        <div class="col-md-6 description-section">
            <h3><i class="fa fa-align-left" aria-hidden="true"></i> Mô tả</h3>
            <hr>
            <p><?= $info['stadium']['description']?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3><i class="fa fa-th-large" aria-hidden="true"></i> Số sân bóng: <?= count($info['stadium']['fields'])?> sân</h3>
            <hr>

                <div id="all-fields">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $fields = \common\models\Field::find()->where(['field_id'=>$info['stadium']['id']])->all();
                        foreach($fields as $key => $f) {
                            ?>
                            <li role="presentation" <?= ($key==0)? 'class="active"':'' ?>><a href="#field-<?=$f['id']?>" aria-controls="field-<?=$f['id']?>" role="tab" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$f['name']?></a>
                            </li>
                        <?php
                        }
                        if(isset($logged_user) && $logged_user->type == 'manager') { //////Thêm sân mới tab
                            ?>

                            <li role="presentation" <?= (count($fields)==0)? 'class="active"':'' ?>><a href="#add-new-field"
                                                                      aria-controls="add-new-field" role="tab"
                                                                      data-toggle="tab"><i class="fa fa-plus"></i> Thêm
                                    mới</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
                        date_default_timezone_set('Asia/Bangkok');
                        $today = date('d/m/Y');
                        $today_day = date('l');
                        $thu = [
                            'Monday'=>'Thứ 2',
                            'Tuesday'=>'Thứ 3',
                            'Wednesday'=>'Thứ 4',
                            'Thursday'=>'Thứ 5',
                            'Friday'=>'Thứ 6',
                            'Saturday'=>'Thứ 7',
                            'Sunday'=>'Chủ nhật',
                        ];
                        //var_dump(array_search($thu[$today_day],$thu));die;

                        foreach($fields as $key => $f) {
                        ?>
                        <div role="tabpanel" class="tab-pane fade <?= ($key==0)? 'in active':'' ?>" id="field-<?=$f['id']?>">
                            <h2 class="clearfix">Lịch thi đấu <?= $f['name']?><small><span class="label label-info">Sân <?= $f['field_type']?> người</span></small>
                                <?php
                                if(isset($logged_user) && $logged_user->type == 'manager') {
                                    ?>
                                    <a href="<?= \yii\helpers\Url::toRoute(['san-bong/xoa', 'id' => $f['id'], 's' => $info['stadium']['id']]) ?>">
                                        <button class="pull-right btn btn-danger">Xóa sân</button>
                                    </a>
                                    <?php
                                }
                                ?>
                            </h2>
                            <table data-type="<?=$f['field_type']?>" class="table table-striped table-bordered table-definition mb-5">
                                <thead class="table-warning">
                                <tr>
                                    <th></th>
                                    <th class="bg-primary">

                                        <p><?= str_replace($today_day,$thu[array_search($thu[$today_day],$thu)],$today_day) ?></p>
                                        <span><?= $today;?></span>
                                    </th>
                                    <?php
                                    for($i = 1;$i<=6;$i++){
                                        ?>
                                        <th class="bg-info">
                                            <p><?= str_replace(date('l', strtotime('+'.$i.' day')),$thu[array_search($thu[date('l', strtotime('+'.$i.' day'))],$thu)],date('l', strtotime('+'.$i.' day')));?></p>
                                            <span><?= date('d/m/Y', strtotime('+'.$i.' day'));?></span>
                                        </th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $time_range = $sModel->getTableSchema()->getColumn('time_range')->enumValues;

                                foreach($time_range as $k => $time){

                                    ?>
                                    <tr>
                                        <td>
                                            <?= $time ?>
                                        </td>
                                        <?php
                                        for($i = 0;$i<=6;$i++){
                                            $date = date('Y-m-d',strtotime('+'.$i.' day'));
                                            $sch = Schedule::find()->where(['date'=>$date,'time_range'=>$time,'field_id'=>$f['id']])->andWhere(['not', ['tracking_code' => null]])->one();
                                            ?>
                                        <td align="center" <?= (count($sch) != 0) ? 'class="bg-success"':'' ?> data-date="<?= $date;?>" data-time="<?= $time;?>" <?= (count($sch) != 0) ? 'id="'.$sch['id'].'"':'' ?>>
                                            <?php
                                            if(count($sch) != 0){
                                                $booked_user = $sch['user'];
                                                echo '<p><b>'.$sch['name'].'</b></p>';
                                                echo '<span>Mã: <b class="text-success">'.$sch['tracking_code'].'</b></span>';
                                                if(isset($logged_user) && $logged_user->type == 'manager'){
                                                ?>
                                                <a href="<?= \yii\helpers\Url::toRoute(['san-bong/xoa-lich', 'id' => $sch['id']]) ?>">Xóa</a>
                                            <?php
                                                }
                                            } else {
                                                ?>
                                                <p><small><i>Sân trống</i></small></p>
                                                <?php
                                                if(Yii::$app->user->isGuest){
                                                    ?>
                                                    <a href="" class="login-a-btn" data-toggle="modal" data-target="#loginModal"><span class="text-danger text-uppercase">Đặt sân</span></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a href="" class="book-a-btn" data-toggle="modal" data-target="#bookModal"><span class="text-danger text-uppercase">Đặt sân</span></a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                        }
                        if(isset($logged_user) && $logged_user->type == 'manager') {
                            ?>
                            <div role="tabpanel" class="tab-pane fade <?= (count($fields)==0)? 'in active':'' ?>" id="add-new-field">
                                <?php $form = ActiveForm::begin([
                                    'id' => 'add-field-form',
                                    'layout' => 'horizontal',
                                    'enableClientValidation' => true,
                                    'fieldConfig' => [

                                        'horizontalCssClasses' => [
                                            'label' => 'col-sm-4',
                                            'offset' => 'col-sm-offset-4',
                                            'wrapper' => 'col-sm-8',
                                            'error' => '',
                                            'hint' => '',
                                        ],
                                    ],
                                ]); ?>
                                <div class="row">
                                    <div class="col-md-5">
                                        <?= $form->field($fModel, 'name', ['labelOptions' => ['class' => 'col-md-4']])->textInput(['placeholder' => 'Tên sân nhỏ', 'value' => 'Sân ' . (count($info['stadium']['fields']) + 1)])->label('Tên sân nhỏ:') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $type = $fModel->getTableSchema()->getColumn('field_type');
                                        $radioList = array();
                                        foreach ($type->enumValues as $value) {
                                            $radioList[$value] = 'Sân ' . $value . ' người';
                                        }
                                        ?>
                                        <?= $form->field($fModel, 'field_type')->inline(true)->radioList($radioList)->label('Loại sân:') ?>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <?= \yii\helpers\Html::button('Thêm', ['type' => 'submit', 'name' => 'add-field-submit', 'class' => 'btn btn-success', 'value' => 'OK']) ?>
                                    </div>
                                    <?= $form->field($fModel, 'field_id')->hiddenInput(['value' => $info['stadium']['id']])->label(false) ?>
                                </div>
                                <?php
                                ActiveForm::end()
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3><i class="fa fa-money" aria-hidden="true"></i> Bảng giá thuê sân</h3>
            <hr>
            <?php
            if(count($info['stadium']['fields']) == 0) {
                if(isset($logged_user) && $logged_user->type == 'manager'){
                    echo "Bạn cần thêm một sân nhỏ trước!";
                } else {
                    echo "Hiện sân chưa có báo giá.";
                }
            } else {
                $fields = \common\models\Field::find()->where(['field_id'=>$info['stadium']['id']])->select('field_type')->groupBy('field_type')->all();
                foreach ($fields as $ft){
                    $arr[] = (int)$ft['field_type'];
                }
                ?>
            <div id="all-pricing">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php
                    foreach($arr as $k => $v) {
                        ?>
                        <li role="presentation" <?php if($k == 0){echo 'class="active"';}  ?>><a href="#type-<?=$v?>" aria-controls="field-<?=$v?>" role="tab" data-toggle="tab">Sân <?=$v?> người</a></li>
                        <?php
                    }
                    ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php
                    foreach($arr as $k => $v) {
                        ?>
                        <div role="tabpanel" class="tab-pane fade <?php if($k == 0){echo 'in active';}  ?>" id="type-<?=$v?>">
                            <?php
                            $price = \common\models\Pricing::find()->where(['field_id'=>$info['stadium']['id']])->andWhere(['field_type'=>(string)$v])->all();
                            if(count($price) == 0){
                                if((isset($logged_user) && $logged_user->type == 'member') || Yii::$app->user->isGuest){
                                    echo 'Hiện sân chưa có báo giá cho loại sân này.';
                                } else {
                                    $form1 = ActiveForm::begin([
                                        'id' => 'fp',
                                        'layout' => 'horizontal',
                                        'enableClientValidation' => true,
                                        'fieldConfig' => [
                                            'template' => "{input}",
                                            'options' => [
                                                'tag' => false,
                                            ],
                                            'horizontalCssClasses' => [
                                                'offset' => 'col-sm-offset-0',
                                                'wrapper' => 'col-sm-12',
                                            ]
                                        ],
                                    ]);
                                    ?>

                                    <table class="table table-striped table-bordered table-definition mb-5">
                                        <thead class="table-warning ">
                                        <tr>
                                            <th></th>
                                            <th>Thứ 2</th>
                                            <th>Thứ 3</th>
                                            <th>Thứ 4</th>
                                            <th>Thứ 5</th>
                                            <th>Thứ 6</th>
                                            <th>Thứ 7</th>
                                            <th>Chủ nhật</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $time_range = $pModel->getTableSchema()->getColumn('time_range')->enumValues;
                                        $pModel_array = array();
                                        foreach($time_range as $k => $time){
                                            $pModel_array[$k] = $pModel;

                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $time ?>
                                                </td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']mon')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']tue')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']wed')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']thu')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']fri')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']sat')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <td><?= $form1->field($pModel_array[$k], '['.$k.']sun')->input('number',['min'=>0,'placeholder' => 'Giá'])->label(false) ?></td>
                                                <?= $form1->field($pModel_array[$k], '['.$k.']time_range',[
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value'=>$time])->label(false);?>
                                                <?= $form1->field($pModel_array[$k], '['.$k.']field_type',[
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value'=>$v])->label(false);?>

                                                <?= $form1->field($pModel_array[$k], '['.$k.']field_id',[
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value'=>$info['stadium']['id']])->label(false); ?>
                                            </tr>
                                            <?php

                                        }
                                        ?>
                                        <?= $form1->field($pModel_array[$k], 'field_type',[
                                            'template' => "{input}"
                                        ])->hiddenInput(['value'=>$v])->label(false);?>
                                        <?= $form1->field($pModel_array[$k], 'field_id',[
                                            'template' => "{input}"
                                        ])->hiddenInput(['value'=>$info['stadium']['id']])->label(false); ?>
                                        <tfoot>
                                        <tr>
                                            <td colspan="8" align="center">
                                                <?= \yii\helpers\Html::button('Cập nhật',['type'=>'submit','name'=>'pricing-update','class'=>'btn btn-success', 'value'=>'OK']) ?>

                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                            <?php
                                    ActiveForm::end();
                                }
                            } else {
                                if((isset($logged_user) && $logged_user->type == 'member') || Yii::$app->user->isGuest){
                                    ?>
                                    <table class="table table-striped table-bordered table-definition mb-5">
                                    <thead class="table-warning ">
                                    <tr>
                                        <th></th>
                                        <th>Thứ 2</th>
                                        <th>Thứ 3</th>
                                        <th>Thứ 4</th>
                                        <th>Thứ 5</th>
                                        <th>Thứ 6</th>
                                        <th>Thứ 7</th>
                                        <th>Chủ nhật</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $time_range = $pModel->getTableSchema()->getColumn('time_range')->enumValues;
                                    $pModel_array = array();
                                    foreach($time_range as $k => $time){
                                        $pr = \common\models\Pricing::find()->where(['field_id'=>$info['stadium']['id']])->andWhere(['field_type'=>(string)$v])->andWhere(['time_range'=>$time])->one();
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $time ?>
                                            </td>
                                            <td align="center"><?= ($pr['mon'] != 0)? '<b class="text-success">'.number_format($pr['mon'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['tue'] != 0)? '<b class="text-success">'.number_format($pr['tue'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['wed'] != 0)? '<b class="text-success">'.number_format($pr['wed'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['thu'] != 0)? '<b class="text-success">'.number_format($pr['thu'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['fri'] != 0)? '<b class="text-success">'.number_format($pr['fri'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['sat'] != 0)? '<b class="text-success">'.number_format($pr['sat'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                            <td align="center"><?= ($pr['sat'] != 0)? '<b class="text-success">'.number_format($pr['sun'],0,',','.').' đ</b> ':'<small><i>Chưa có giá</i></small>' ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </table>
                                    <?php
                                } else {

                                    $form2 = ActiveForm::begin([
                                        'id' => 'fp',
                                        'layout' => 'horizontal',
                                        'enableClientValidation' => true,
                                        'fieldConfig' => [
                                            'template' => "{input}",
                                            'options' => [
                                                'tag' => false,
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <table class="table table-striped table-bordered table-definition mb-5">
                                        <thead class="table-warning ">
                                        <tr>
                                            <th></th>
                                            <th>Thứ 2</th>
                                            <th>Thứ 3</th>
                                            <th>Thứ 4</th>
                                            <th>Thứ 5</th>
                                            <th>Thứ 6</th>
                                            <th>Thứ 7</th>
                                            <th>Chủ nhật</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $time_range = $pModel->getTableSchema()->getColumn('time_range')->enumValues;
                                        $pModel_array = array();
                                        foreach ($time_range as $k => $time) {
                                            $pr = \common\models\Pricing::find()->where(['field_id' => $info['stadium']['id']])->andWhere(['field_type' => (string)$v])->andWhere(['time_range' => $time])->one();
                                            if ($pr !== null) {
                                                $m = $pr;
                                            } else {
                                                $m = new \common\models\Pricing();
                                            }

                                            $pModel_array[$k] = $m;

                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $time ?>
                                                </td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']mon', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['mon']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']tue', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['tue']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']wed', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['wed']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']thu', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['thu']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']fri', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['fri']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']sat', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['sat']])->label(false) ?></td>
                                                <td><?= $form2->field($pModel_array[$k], '[' . $k . ']sun', [
                                                        'horizontalCssClasses' => [
                                                            'offset' => 'col-sm-offset-0',
                                                            'wrapper' => 'col-sm-12',
                                                        ]
                                                    ])->input('number', ['min' => 0, 'placeholder' => 'Giá', 'value' => $pModel_array[$k]['sun']])->label(false) ?></td>
                                                <?= $form2->field($pModel_array[$k], '[' . $k . ']time_range', [
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value' => $time])->label(false); ?>
                                                <?= $form2->field($pModel_array[$k], '[' . $k . ']field_type', [
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value' => $v])->label(false); ?>
                                                <?= $form2->field($pModel_array[$k], '[' . $k . ']id', [
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value' => $pr['id']])->label(false); ?>
                                                <?= $form2->field($pModel_array[$k], '[' . $k . ']field_id', [
                                                    'template' => "{input}"
                                                ])->hiddenInput(['value' => $info['stadium']['id']])->label(false); ?>
                                            </tr>
                                            <?php

                                        }
                                        ?>
                                        <?= $form2->field($pModel_array[$k], 'field_type', [
                                            'template' => "{input}"
                                        ])->hiddenInput(['value' => $v])->label(false); ?>
                                        <?= $form2->field($pModel_array[$k], 'field_id', [
                                            'template' => "{input}"
                                        ])->hiddenInput(['value' => $info['stadium']['id']])->label(false); ?>
                                        <tfoot>
                                        <tr>
                                            <td colspan="8" align="center">
                                                <?= \yii\helpers\Html::button('Cập nhật', ['type' => 'submit', 'name' => 'pricing-update', 'class' => 'btn btn-success', 'value' => 'OK']) ?>

                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <?php
                                    ActiveForm::end();
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3><i class="fa fa-map"></i> Bản đồ</h3>
            <hr>
        </div>
    </div>
</div>
<div class="container-fluid" id="google-map-mark">
    <div class="row">
    <?php
    $new_gg_cd = ltrim($info['stadium']['google_map'],'(');
    $new_gg_cd = rtrim($new_gg_cd,')');
    $c = explode(',',$new_gg_cd);
    $lat = floatval($c[0]);
    $lng = floatval($c[1]);
    $coord = new LatLng(['lat' => $lat, 'lng' => $lng]);
    $marker = new Marker([
        'position' => $coord,
        'title' => $info['stadium']['name'],
    ]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 14,
        'width' => '100%'
    ]);
    $map->addOverlay($marker);
    echo $map->display();
    ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 photo-slider">
            <h3><i class="fa fa-picture-o" aria-hidden="true"></i> Ảnh sân bóng</h3>
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
        <div class="col-md-6 comments">
            <h3><i class="fa fa-comments-o" aria-hidden="true"></i> Đánh giá</h3>
            <hr>
            <?php
            $comments = Comments::find()->where(['field_id'=>$info['stadium']['id']])->all();
            if(Yii::$app->user->isGuest){
                echo 'Bạn phải <a href="" id="login-a-btn" data-toggle="modal" data-target="#loginModal">đăng nhập</a> mới có thể đánh giá';
            } else {
                if(isset($logged_user) && $logged_user->type == 'member'){
                    $cmt_form = ActiveForm::begin([
                        'id' => 'add-comment-form',
                        'enableClientValidation' => true,
                    ]); ?>

                    <?= $cmt_form->field($cModel, 'rate')->widget(StarRating::classname(), [
                        'pluginOptions' => [
                            'theme' => 'krajee-fa',
                            'step' => 0.1,
                            'readonly' => false,
                            'size' => 'xs',
                            'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                            'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                            'min' => 0,
                            'max' => 5,
                            'defaultCaption' => '{rating}',
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
                        ]
                    ])->label('Đánh giá');
                    ?>
                    <?= $cmt_form->field($cModel, 'comment')->textarea()->label('Bình luận')?>
                    <div class="text-right"><?= \yii\helpers\Html::submitButton('Gửi',['class'=>'btn btn-success', 'name'=>'add-comment','value'=>'OK'])?></div>
                    <?= $cmt_form->field($cModel, 'user_id')->hiddenInput(['value'=>$logged_user->id])->label(false)?>
                    <?= $cmt_form->field($cModel, 'field_id')->hiddenInput(['value'=>$info['stadium']['id']])->label(false)?>
                    <?php
                    ActiveForm::end();
                }
                ?>
                <p>Có <?= count($info['stadium']['comments']) ?> bình luận</p>
                <div class="comment-list">
                    <ul>
                        <?php
                        foreach ($info['stadium']['comments'] as $comment){
                            $user = $comment['user'];
                            if(substr($user->avatar,0,8) == 'https://'){
                                $link = $user->avatar;
                            } else {
                                $link = Yii::$app->params['appFolder'].'/uploads/images/'.$user->avatar;
                            }
                            ?>
                            <li class="clearfix comment-container">
                                <div class="pull-left avatar">
                                    <img src="<?= $link ?>" alt="">
                                </div>
                                <div class="pull-left comment">
                                    <p><b><?= $user['fullname']?></b> <?= ($comment['rate']!=null)? StarRating::widget([
                                            'name' => 'user-rate',
                                            'pluginOptions' => [
                                                'theme' => 'krajee-fa',
                                                'readonly' => true,
                                                'showClear' => false,
                                                'size' => 'xs',
                                                'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                                                'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                                                'defaultCaption' => '{rating}',
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
                                            'value' => $comment['rate'],
                                        ]): '';?></p>
                                    <p><?= $comment['comment'] ?></p>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div id="bookModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Đặt lịch thi đấu</h4>
            </div>
            <div class="modal-body">
                <div class="book-form-container">
                    <?php
                    $book_form = ActiveForm::begin();
                    ?>
                    <?php
                    if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && $logged_user->type == 'manager')){
                        echo $book_form->field($sModel,'name')->textInput(['placeholder'=>'Tên người đặt lịch'])->label('Họ và tên');
                    } else {
                        echo $book_form->field($sModel,'name')->textInput(['placeholder'=>'Tên người đặt lịch', 'value'=>$logged_user->fullname])->label('Họ và tên');
                    }
                    if(isset($logged_user)){
                        echo $book_form->field($sModel,'user_id')->hiddenInput(['value'=>$logged_user->id])->label(false);
                    } else {
                        echo $book_form->field($sModel,'user_id')->hiddenInput()->label(false);
                    }
                    ?>
                    <?= $book_form->field($sModel,'date')->input('date')->label('Ngày') ?>
                    <?php

                    foreach($sModel->getTableSchema()->getColumn('time_range')->enumValues as $value){
                        $time_range_custom[$value]=$value;
                    }

                    $fields = \common\models\Field::find()->where(['field_id'=>$info['stadium']['id']])->select('field_type')->groupBy('field_type')->all();
                    $arr = array();
                    foreach ($fields as $ft){
                        $arr[] = (int)$ft['field_type'];
                    }
                    $radioList = array();
                    foreach ($arr as $value) {
                        $radioList[$value] = 'Sân ' . $value . ' người';
                    }
                    ?>
                    <?= $book_form->field($sModel,'time_range')->dropDownList($time_range_custom)->label('Khung giờ');?>
                    <?= $book_form->field($sModel, 'field_type')->inline(true)->radioList($radioList)->label('Loại sân:') ?>
                    <?= $book_form->field($sModel,'field_id')->hiddenInput()->label(false) ?>
                    <div class="text-center"><?= \yii\helpers\Html::button('Đặt lịch', ['type' => 'submit', 'name' => 'book-field', 'class' => 'btn btn-success', 'value' => 'OK']) ?></div>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>