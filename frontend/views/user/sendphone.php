<?php
    $this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];

    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

?>

<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Vui lòng nhập số điện thoại:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
            <?= $form->field($model, 'phone')->textInput([
                    'placeholder' => 'Số điện thoại',
                    'autofocus'=>true
                ]
            )->label('Số điện thoại:') ?>

            <div class="form-group">
                <?= Html::submitButton('Khôi Phục', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
