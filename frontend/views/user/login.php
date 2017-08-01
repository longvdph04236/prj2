<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mật khẩu'])->label(false) ?>

<div class="flex-form-item">
    <?= $form->field($model, 'rememberMe')->checkbox()->label('Lưu đăng nhập') ?>

    <div class="form-group">
        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<div class="flex-form-item">
    <?= Html::a('Quên mật khẩu?', ['site/request-password-reset']) ?>
    <?= Html::a('Chưa có tài khoản?', ['user/dang-ky']) ?>
</div>

<?php ActiveForm::end(); ?>