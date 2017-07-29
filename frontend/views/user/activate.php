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
    <div class="col-md-6">
        <p>Mã kích hoạt đã được gửi đến điện thoại của bạn. Mã sẽ hết hạn sau 5 phút. Sau 5 phút, vui lòng <a id="resend-link"
                    href="<?= \yii\helpers\Url::to('user/resend') ?>">lấy mã mới</a>.</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal']); ?>

        <?= $form->field($model, 'otp')->textInput()->label('Mã kích hoạt:') ?>

        <?= $form->field($model, 'aT')->hiddenInput(['name' => 'aT', 'value' => $model->getAttribute('aT')]) ?>

        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#resend-link').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function(data){
                    if(data) {
                        alert('Mã đã được gửi lại');
                    } else {
                        console.log(data);
                    }
                }
            });
        })
    })
</script>
