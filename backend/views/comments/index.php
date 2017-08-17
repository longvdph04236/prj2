<?php
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\rating\StarRating;
use yii\web\JsExpression;

$this->title = 'Bình luận';
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
            <th width="5%">ID</th>
            <th width="20%">Người bình luận</th>
            <th width="45%">Nội dung</th>
            <th width="25%">Đánh giá</th>
            </thead>
            <tbody>
            <?php
            foreach($model as $key=>$value) { ?>
                <tr>
                    <td width="5%">
                        <?= $value->id ?>
                    </td>

                    <td width="20%">
                        <?php
                        echo $value->user->fullname;
                        ?>
                    </td>

                    <td width="45%">
                        <?= $value->comment ?>
                    </td>

                    <td width="25%">
                        <?= StarRating::widget([
                            'name' => 'rate',
                            'pluginOptions' => [
                                'showClear'=>false,
                                'theme' => 'krajee-fa',
                                'step' => 0.1,
                                'readonly' => true,
                                'size' => 'xs',
                                'filledStar' => '<i class="fa fa-star" aria-hidden="true"></i>',
                                'emptyStar' => '<i class="fa fa-star-o" aria-hidden="true"></i>',
                                'min' => 0,
                                'max' => 5,
                                'clearCaption' => 'Chưa đánh giá',
                                'starCaptionClasses' => new JsExpression("function(val) {
                                if (val == 0) {
                                   return 'label label-default';
                                }
                                else if (val > 0 && val < 2) {
                                    return 'label label-danger';
                                } 
                                else if (val >= 2 && val < 3) {
                                    return 'label label-info';
                                } 
                                else if(val >= 3 && val < 4) {
                                    return 'label label-primary';
                                } 
                                else if(val >= 4){
                                    return 'label label-success';
                                }
                            }"),
                                'starCaptions' => new JsExpression("function(val){return val == 1 ? '1 điểm' : val + ' điểm';}")
                            ],
                            'value' => $value->rate,
                        ]);?>
                    </td>

                    <td>
                        <?= html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$value->id],[
                            'data'=>[
                                'confirm'=>'bạn có chắc chắn muốn xóa?',
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
