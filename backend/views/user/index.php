<?php

     use yii\widgets\LinkPager;
     use yii\widgets\Breadcrumbs;
     use yii\helpers\Html;
     use yii\helpers\Url;

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
                        <th>ID</th>
                        <th>Avatar</th>
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
                                        <?= $value->id ?>
                                    </td>

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
                                        <?= $value->username ?>
                                    </td>

                                    <td>
                                        <?= ($value->email == null) ?  'null' : $value->email; ?>
                                    </td>

                                    <td>
                                        <?= $value->phone ?>
                                    </td>

                                    <td>
                                        <form id="f<?=$value->id;?>" action="<?= Url::toRoute('user/update')?>" method="post">
                                            <select name="status" class="status">
                                                <?php
                                                    if($value->status == 'activated')  { ?>
                                                        <option selected value="<?= $value->status ;?>"> <?=
                                                            $value->status?></option>
                                                        <option value="inactive"> inactive</option>
                                                    <?php } else { ?>
                                                        <option selected value="<?= $value->status ;?>"> <?= $value->status?></option>
                                                        <option value="activated">activated</option>
                                                   <?php } ?>
                                                ?>

                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <?= html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$value->id])?>
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
        <?=
            LinkPager::widget([
               'pagination' => $pagination
            ]);
        ?>
    </div>




