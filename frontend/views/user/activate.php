<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 27/07/2017
 * Time: 10:29 SA
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$v = $model->getAttributes(['aT']);
$this->registerJsFile('@web/js/resendcode.js',['depends'=>[\frontend\assets\AppAsset::className()]]);
?>

<div class="row">
    <div class="col-md-6">
        <p>Mã kích hoạt đã được gửi đến điện thoại của bạn. <br>Mã sẽ hết hạn sau 5 phút.<br>Sau 5 phút, vui lòng <b><a id="resend-link"
                    href="<?= \yii\helpers\Url::toRoute('user/resend') ?>">lấy mã mới</a></b>.</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal']); ?>

        <?= $form->field($model, 'otp')->textInput()->label('Mã kích hoạt:') ?>

        <?= $form->field($model, 'aT')->hiddenInput(['name' => 'aT', 'value' => $v['aT']])->label(false) ?>

        <?= Html::submitButton('Kích hoạt', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
