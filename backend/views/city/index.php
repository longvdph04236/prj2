<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\Breadcrumbs;
    use yii\widgets\LinkPager;

    $this->title = 'Quản lý khu vực';
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Danh sách khu vực</div>
        </div>
        <div class="panel-body">
            <p class="pull-right">
                <?= Html::a('Thêm mới',['create'],['class'=>'btn btn-sm btn-success'])?>
            </p>
            <table class="table">
                <thead>
                    <th>Mã khu vực</th>
                    <th>Khu Vực</th>
                    <th>Số Quận huyện</th>
                    <th>Hành động</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($model as $key=>$value) {
                                $c = \backend\models\District::find()->where(['city_id'=>$value->id])->count();
                            ?>
                            <tr>
                                <td><?= $value->id ;?></td>
                                <td><?= $value->name ;?></td>
                                <td><?= $c ?></td>
                                <td>
                                    <?= html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$value->id])?>
                                    <?= html::a('<span class="glyphicon glyphicon-pencil"></span>',['update', 'id'=>$value->id])?>
                                    <?= html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$value->id],[
                                        'data'=>[
                                            'confirm'=>'bạn có chắc chắn muốn xóa : ' .$value->name,
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
