<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;
use backend\models\City;
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Thêm mới'];
?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'id' => 'sign-up-form',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'validateOnBlur' => true,
            'validationUrl' => \yii\helpers\Url::toRoute('quan-ly-san/ajax-validate'),
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Tên sân bóng'])->label('Tên sân bóng:') ?>

        <?= $form->field($model, 'address')->textInput(['placeholder' => 'Địa chỉ'])->label('Địa chỉ:') ?>

        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Số điện thoại'])->label('Số điện thoại:') ?>

        <?= $form->field($model, 'city',['validateOnChange'=>true])->input('text',['list'=>'city','placeholder' => 'Chọn tỉnh/thành phố'])->label('Tỉnh/thành phố:') ?>
        <datalist id="city" data-href="<?= \yii\helpers\Url::toRoute(['quan-ly-san/get-district'])?>">
            <?php
            $cities = City::find()->all();
            foreach ($cities as $city){
            ?>
            <option value="<?=$city['name']?>">
                <?php
                }
                ?>
        </datalist>
        <?= $form->field($model, 'district')->input('text',['list'=>'district','placeholder' => 'Chọn quận/huyện'])->label('Quận/huyện:') ?>
        <datalist id="district" class="district">

        </datalist>

        <?= $form->field($model, 'description')->widget(TinyMce::className(), [
            'options' => ['rows' => 6],
            'language' => 'vi',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ])->label('Mô tả:') ?>

        <?= $form->field($model, 'google')->widget('kolyunya\yii2\widgets\MapInputWidget',
            [

                // Google maps browser key.
                'key' => 'AIzaSyCyyQrlF4nWCZT_x7GC0Syh5jsdcJXzoqw',

                // Initial map center latitude. Used only when the input has no value.
                // Otherwise the input value latitude will be used as map center.
                // Defaults to 0.
                'latitude' => 21.0227003,

                // Initial map center longitude. Used only when the input has no value.
                // Otherwise the input value longitude will be used as map center.
                // Defaults to 0.
                'longitude' => 105.801944,

                // Initial map zoom.
                // Defaults to 0.
                'zoom' => 12,

                // Map container height.
                // Defaults to '300px'.
                'height' => '350px',

                // Coordinates representation pattern. Will be use to construct a value of an actual input.
                // Will also be used to parse an input value to show the initial input value on the map.
                // You can use two macro-variables: '%latitude%' and '%longitude%'.
                // Defaults to '(%latitude%,%longitude%)'.
                'pattern' => '(%latitude%,%longitude%)',

                // Google map type. See official Google maps reference for details.
                // Defaults to 'roadmap'
                'mapType' => 'roadmap',

                // Marker animation behavior defines if a marker should be animated on position change.
                // Defaults to false.
                'animateMarker' => true,

                // Map alignment behavior defines if a map should be centered when a marker is repositioned.
                // Defaults to true.
                'alignMapCenter' => false,

                // A flag which defines if a search bar should be rendered over the map.
                'enableSearchBar' => true,

            ]
            )->label('Map:') ?>

        <?= $form->field($model, 'photos[]')->widget(\dosamigos\fileinput\BootstrapFileInput::className(), [
            'options' => ['accept' => 'image/*', 'multiple' => true],
            'clientOptions' => [
                'previewFileType' => 'text',
                'browseClass' => 'btn btn-success',
                'uploadClass' => 'btn btn-info',
                'removeClass' => 'btn btn-danger',
                'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> '
            ]
        ]);?>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::button('<i class="fa fa-plus"></i> Thêm mới',['type'=> 'submit', 'class'=> 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
