<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;
use backend\models\City;
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
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

        <?php
            $model['google'] = ltrim($model['google'],'(');
            $model['google'] = rtrim($model['google'],')');

        ?>
        <?= $form->field($model, 'google')->widget('kolyunya\yii2\widgets\MapInputWidget',
            [

                // Google maps browser key.
                'key' => 'AIzaSyCyyQrlF4nWCZT_x7GC0Syh5jsdcJXzoqw',

                // Initial map center latitude. Used only when the input has no value.
                // Otherwise the input value latitude will be used as map center.
                // Defaults to 0.
                //'latitude' => 21.0227003,

                // Initial map center longitude. Used only when the input has no value.
                // Otherwise the input value longitude will be used as map center.
                // Defaults to 0.
                //'longitude' => 105.801944,

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

        <div class="form-group newstadiumform-photos">
            <label class="control-label col-sm-3" for="newstadiumform-photos">Ảnh:</label>
            <div class="col-sm-9 product-img-list">
                <?php
                $photos = explode(',',$stadium['photos']);
                foreach ($photos as $p){
                    ?>
                    <div class="img-holder has-img">
                        <?= $form->field($model, 'photos[]')->fileInput(['accept' => 'image/*','class'=>'img-input'])->label(false)?>
                        <div class="overlay-grp-btn">
                            <button type="button" class="add-img"><i class="fa fa-plus"></i></button>
                            <div class="edit-grp-btn">
                                <button type="button" class="edit-img"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="del-img"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <img src="<?=Yii::$app->params['appFolder'].'/uploads/images/'.$p?>" class="img-display" alt="">
                        <input type="hidden" class="old-img" name="oldImg[]" value="<?=$p?>">
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::button('<i class="fa fa-floppy-o"></i> Cập nhật',['type'=> 'submit', 'class'=> 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
