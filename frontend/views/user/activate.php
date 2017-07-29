<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 27/07/2017
 * Time: 10:29 SA
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal']); ?>

        <?= $form->field($model, 'otp')->textInput()->label('Mã kích hoạt:') ?>

        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
