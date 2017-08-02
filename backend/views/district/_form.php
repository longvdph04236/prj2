<?php

    use yii\bootstrap\ActiveForm;
    use backend\models\City;
    use yii\helpers\Html;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->title?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id'=>'form_city',
            'options'=>['class'=>'form-group'],
        ]); ?>

        <?= $form->field($model,'name')->textInput();?>
        <?php
            $city = new City();

             echo $form->field($model, 'city_id')->dropDownList(
                $city->getParent(),
                [
                    'prompt'=>'Trực thuộc thành phố'
                ]
             );
        ?>
        <?= html::submitButton($model->isNewRecord ? 'Tạo Mới' : 'Cập Nhật',['class'=>$model->isNewRecord ? 'btn btn-success' :'btn btn-primary'])
        // activeRecord đại diện cho bảng trong database
        // isNewRecord để xác định thức thể trong bảng có phải là mới hay không trả vể true or false
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
