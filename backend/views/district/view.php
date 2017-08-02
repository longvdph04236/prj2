<?php
use yii\helpers\html;
use yii\widgets\DetailView;
$this->title = 'Thông tin';
$this->params['breadcrumbs'][]= $model->name;

?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->title ?></h3>
    </div>
    <div class="panel-body">
        <p class="pull-right">
            <?= html::a('Update',['update','id'=>$model->id],['class'=>'btn btn-sm btn-success']);?>
            <?= html::a('delete',['delete','id'=>$model->id],
                [
                    'class'=>'btn btn-sm btn-danger',
                    'data'=>[
                        'confirm'=>'bạn có chắc chắn muốn xóa : ' .$model->name,
                        'method'=>'post'
                    ]
                ]
            );?>
        </p>
        <?= DetailView::widget([
            'model'=>$model,
            'attributes'=>[
                'id',
                'name',
                [
                  'attribute'=>'city_id',
                    'value'=>function($model) {
                        $c = \backend\models\City::find()->where(['id'=>$model->city_id])->one();
                        return $c->name;
                    }
                ],
            ]
        ]);?>
    </div>
</div>
