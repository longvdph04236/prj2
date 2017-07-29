<?php

     use app\models\Users;
     use yii\widgets\LinkPager;
     use yii\widgets\Breadcrumbs;
     use yii\helpers\Html;

     $this->title = 'User';
     $this->params['breadcrumbs'][] = $this->title;
     Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
     ]);
?>
     <div class="panel panel-primary">
           <div class="panel-heading">
            <h4><?= Html::encode($this->title) ?></h4>
           </div>
           <div class="panel-body">
               <table class="table">
                   <thead>
                        <th>Avatar</th>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                   </thead>
                   <tbody>
                        <?php
                            foreach($model as $key=>$value) { ?>
                                <tr>
                                    <td>
                                        <?php
                                            if($value->avatar == '') {
                                                echo Html::img(Yii::$app->params['appFolder'].'/uploads/images/img_avatar3.png',
                                                    [  'style' => [
                                                            'width'=>'60px',
                                                            'height'=>'60px',
                                                            'border-radius'=>'50%'
                                                        ]
                                                    ]
                                                );
                                            }else {
                                                echo Html::img(Yii::$app->params['appFolder'].'/uploads/images/img_avatar3.png',
                                                    [
                                                        'style' => [
                                                            'width'=>'60px',
                                                            'height'=>'60px',
                                                            'border-radius'=>'50%'
                                                        ]
                                                    ]
                                                    );
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <?= $value->id ?>
                                    </td>

                                    <td>
                                        <?= $value->username ?>
                                    </td>

                                    <td>
                                        <?= ($value->email == null) ?  'null' : $value->email; ?>
                                    </td>

                                    <td>
                                        <?= $value->phone ?>
                                    </td>

                                    <td>
                                        <?= $value->status ?>
                                    </td>
                                    <td>
                                        <?= html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$value->id])?>
                                        <?= html::a('<span class="glyphicon glyphicon-pencil"></span>',['update','id'=>$value->id])?>
                                        <?= html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$value->id],[
                                            'data'=>[
                                                'confirm'=>'bạn có chắc chắn muốn xóa : ' .$value->username,
                                                'method'=>'post'
                                            ]
                                        ])?>
                                    </td>
                                </tr>
                        <?php } ?>
                   </tbody>
               </table>
           </div>
     </div>
    <div class="text-center">
        <?php
            LinkPager::widget([
               'pagination' => $pagination
            ]);
        ?>
    </div>




