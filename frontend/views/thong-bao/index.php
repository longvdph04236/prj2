<?php
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
use yii\widgets\LinkPager;
$user = \common\models\User::findOne(Yii::$app->user->identity->getId());
?>
<?php

if (count($model) == 0){
    echo 'Bạn không có thông báo';
} else {
    ?>
    <table id="noti-table" class="table table-striped table-bordered table-definition mb-5">
        <thead>
        <tr>
            <th class="bg-primary">Sân bóng</th>
            <th class="bg-primary">Sân</th>
            <th class="bg-primary">Họ tên người đặt</th>
            <th class="bg-primary">Ngày</th>
            <th class="bg-primary">Khung giờ</th>
            <th class="bg-primary">Đặt lúc</th>
            <th class="bg-primary">Trạng thái</th>
            <th class="bg-primary">Mã đặt sân</th>
            <?php
            if($user->type == 'manager'){
                ?>
            <th class="bg-primary">Hành động</th>
                <?php

            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($model as $n) {
            if($n['name'] == ''){
                $u = \common\models\User::findOne(['id'=>$n['user_id']]);
                $n['name'] = $u->fullname;
            }
            $f = \common\models\Field::findOne($n['field_id']);
            $s = \common\models\Stadiums::findOne($f['field_id']);
            switch ($n['status']) {
                case 'new':
                    $stt = 'Mới';
                    $class = 'label-primary';
                    break;
                case 'failed':
                    $stt = 'Hủy';
                    $class = 'label-danger';
                    break;
                case 'success':
                    $stt = 'Thành công';
                    $class = 'label-success';
                    break;
            }
            ?>
            <tr>
                <td valign="center" ><?= $s['name'] ?></td>
                <td ><?= $f['name'] ?></td>
                <td ><?= $n['name'] ?></td>
                <td ><?= $n['date'] ?></td>
                <td ><?= $n['time_range'] ?></td>
                <td><?= $n['create_at'] ?></td>
                <td ><span class="label <?= $class ?>"><?= $stt ?></span></td>
                <td class="code"><?= (isset($n['tracking_code']))? $n['tracking_code']:'Chưa khởi tạo' ?></td>
                <?php
                if($user->type == 'manager'){
                ?>
                <td ><?php if ($stt == 'Mới') { ?>
                        <button data-url="<?= \yii\helpers\Url::toRoute(['thong-bao/accept'])?>" data-id="<?= $n['id'] ?>" class="btn btn-success accept-book">Chấp nhận</button><?php } ?></td>
                    <?php

                }
                ?>
            </tr>
            <?php

        }
        ?>
        </tbody>
    </table>
    <?php
    echo LinkPager::widget([

        'pagination' => $pagi

    ]);
}

