<?php
/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = ['label' => 'Hồ sơ người dùng', 'url' => ['index']];
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use conquer\toastr\ToastrWidget;

if(Yii::$app->session->has('s')){
    ToastrWidget::widget(['message'=>Yii::$app->session->getFlash('s')]);
}
if(Yii::$app->session->has('f')){
    ToastrWidget::widget(['type'=>'error','message'=>Yii::$app->session->getFlash('f')]);
}

if(substr($model->avatar,0,8) == 'https://'){
    $link = $model->avatar;
} else {
    $link = Yii::$app->params['appFolder'].'/uploads/images/'.$model->avatar;
}
?>

<div class="row" id="base-info">
    <?php $form = ActiveForm::begin(['id' => 'profile-form','layout' => 'horizontal']); ?>
    <div class="col-md-2">
        <fieldset>
            <legend>Ảnh đại diện</legend>
        <div class="profile-pic-container">
            <img src="<?= $link ?>" alt="">
            <div class="overlay"></div>
            <button class="change-profile-pic"><i class="fa fa-2x fa-pencil"></i></button>
            <?= $form->field($model, 'newPhoto')->fileInput(['accept' => 'image/*','class'=>'img-input'])->label(false) ?>
        </div>
        </fieldset>
    </div>
    <div class="col-md-10">
        <fieldset>
            <legend>Thông tin cơ bản</legend>
        <?= $form->field($model, 'fullname')->textInput(['placeholder' => 'Họ tên đầy đủ'])->label('Họ và tên:',['style'=>'text-align:left']) ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label('Tên đăng nhập:',['style'=>'text-align:left']) ?>

        <?= $form->field($model, 'email')->input('email',['placeholder' => 'Email'])->label('Email:',['style'=>'text-align:left']) ?>

        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Số điện thoại'])->label('Số điện thoại:',['style'=>'text-align:left']) ?>
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <div class="action-group">
        <?= Html::button('<i class="fa fa-times"></i> Hủy', ['class' => 'btn btn-danger', 'name' => 'cancel-button']) ?>
        <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Cập nhật', ['class' => 'btn btn-success', 'name' => 'profile-update-button','value'=>'ok']) ?>
        </div>
        </fieldset>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <?php $form1 = ActiveForm::begin(['id' => 'password-form','layout' => 'horizontal']); ?>
        <fieldset>
            <legend>Đổi mật khẩu</legend>
            <?= $form1->field($upForm, 'password')->passwordInput()->label('Mật khẩu hiện tại:',['style'=>'text-align:left']) ?>

            <?= $form1->field($upForm, 'newPass')->passwordInput()->label('Mật khẩu mới:',['style'=>'text-align:left']) ?>

            <?= $form1->field($upForm, 'confirmPassword')->passwordInput()->label('Xác nhận mật khẩu mới:',['style'=>'text-align:left']) ?>

            <div class="action-group">
                <?= Html::button('<i class="fa fa-times"></i> Hủy', ['class' => 'btn btn-danger', 'name' => 'cancel-button']) ?>
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Cập nhật', ['class' => 'btn btn-success', 'name' => 'password-update-button','value'=>'ok']) ?>
            </div>
        </fieldset>
        <?php ActiveForm::end(); ?>
    </div>
</div>