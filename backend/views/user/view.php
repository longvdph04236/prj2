<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
    use yii\widgets\ActiveForm;

    $this->title = 'User ID Manager';
    $this->params['breadcrumbs'][] = ['label'=> 'User', 'url'=> ['index']];
    $this->params['breadcrumbs'][] = $model->username;

?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Detail User ID</h4>
        </div>

        <div class="panel-body">
            <p class="pull-right">
                <?= Html::a('Xóa',['delete','id'=>$model->id],
                    [
                        'class'=>'btn btn-sm btn-danger',
                        'data'=>[
                            'confirm'=>'bạn có chắc chắn muốn xóa  ' .$model->username,
                            'method'=>'post'
                        ]

                    ]);
                ?>
            </p>

            <?= DetailView::widget([
                'model'=>$model,
                'attributes'=> [
                    'id',
                    [
                        'attribute'=>'avatar',
                        'value'=> yii::$app->params['appFolder'].'/uploads/images/user.png',
                        'format'=>[
                            'image',
                            [
                                'width'=>'60px',
                                'height'=>'60px',
                                'border-radius'=>'50%'
                            ]
                        ]
                    ],
                    'fullname',
                    'username',
                    [
                        'attribute'=>'email',
                        'value'=>function($model){
                            if($model->email == null) {
                                return 'Email chưa thiết lập';
                            }else {
                                return $model->email;
                            }
                        }
                    ],
                    'phone',
                    [
                        'attribute'=>'type',
                        'value'=>function($model){
                            switch($model->type){
                                case  'admin' :
                                    return 'Quản trị viên';
                                    break;
                                case 'member' :
                                    return 'Thành viên';
                                    break;
                                case 'manager' :
                                    return 'Chủ Sân';
                                    break;
                                default :
                                    return 'Thành viên';
                                    break;

                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>function($model) {
                                if($model->status === 'inactive') {
                                    return "chưa kích hoạt";
                                }else {
                                    return 'chưa kích hoạt';
                                }

                        },

                    ]
                ]

            ]);






            ?>
        </div>
    </div>
