<?php
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
$c = false;
$sessions = Yii::$app->session;

if($sessions->has('uid')){
    $model->id = $sessions->getFlash('uid');
    $model->ava = $sessions->getFlash('ava');
    $model->fullName = $sessions->getFlash('fn');
    $model->email = $sessions->getFlash('em');
    $model->username = $sessions->getFlash('uid');
}
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12">

<?php $form = ActiveForm::begin(['id' => 'sign-up-form','layout' => 'horizontal']); ?>

<?= $form->field($model, 'type')->inline(true)->radioList(['manager' => 'Quản lý sân bóng', 'member' => 'Người thuê sân'])->label('Bạn là:') ?>

<?= $form->field($model, 'fullName')->textInput(['placeholder' => 'Họ tên đầy đủ'])->label('Họ và tên:') ?>

<?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label('Tên đăng nhập:') ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mật khẩu'])->label('Mật khẩu:') ?>

<?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Xác nhận mật khẩu'])->label('Xác nhận mật khẩu:') ?>

<?= $form->field($model, 'email')->input('email',['placeholder' => 'Email'])->label('Email:') ?>

<?= $form->field($model, 'phone')->textInput(['placeholder' => 'Số điện thoại'])->label('Số điện thoại:') ?>

<?php
if(isset($model->id)) {
    ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'ava')->hiddenInput()->label(false) ?>
    <?php
}
?>

<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

    </div>
</div>
