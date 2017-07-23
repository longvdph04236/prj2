<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Tên đăng nhập'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mật khẩu'])->label(false) ?>

<div class="flex-form-item">
    <?= $form->field($model, 'rememberMe')->checkbox()->label('Lưu đăng nhập') ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<div style="color:#999;margin:1em 0">
    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
</div>

<?php ActiveForm::end(); ?>