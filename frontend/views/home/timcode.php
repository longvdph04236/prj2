<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 14/08/2017
 * Time: 10:49 SA
 */
$this->params['breadcrumbs'][] = ['label' => $this->params['big-title'], 'url' => ['index']];
?>
<?php
if($code){
?>
<table id="noti-table" class="table table-striped table-definition mb-5">
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
        <th class="bg-primary">Hành động</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if(!Yii::$app->user->isGuest){
            $user = \common\models\User::findOne(Yii::$app->user->identity->getId());
        }
        if($code['name'] == ''){
            $u = \common\models\User::findOne(['id'=>$code['user_id']]);
            //var_dump($code);die;
            $code['name'] = $u->fullname;
        }
        $f = \common\models\Field::findOne($code['field_id']);
        $s = \common\models\Stadiums::findOne($f['field_id']);
        switch ($code['status']) {
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
            <td ><?= $code['name'] ?></td>
            <td ><?= date('d/m/Y',strtotime(str_replace('-','/',$code['date']))) ?></td>
            <td ><?= $code['time_range'] ?></td>
            <td><?= date('H:i:s d/m/Y',strtotime(str_replace('-','/', $code['create_at']))) ?></td>
            <td ><span class="label <?= $class ?>"><?= $stt ?></span></td>
            <td class="code"><?php if($code['status'] == 'success'){ echo $code['tracking_code'];} else if($code['status'] == 'new'){ echo 'Chưa khởi tạo';} else echo 'Hủy' ?></td>
            <?php
            if($user->type == 'manager'){
                ?>
                <td ><?php if ($stt == 'Mới') { ?>
                    <button data-url="<?= \yii\helpers\Url::toRoute(['thong-bao/accept'])?>" data-id="<?= $code['id'] ?>" class="btn btn-success accept-book">Chấp nhận</button><?php } ?></td>
                <?php

            } else if ($user->type == 'member'){
                ?>
                <td ><?php if ($stt == 'Mới') { ?>
                    <a href="<?= \yii\helpers\Url::toRoute(['san-bong/xoa-lich','id'=>$code['id']])?>"><button class="btn btn-danger">Hủy đặt</button><?php } ?></td></a>
                <?php
            } else {
                echo '<td></td>';
            }
            ?>
        </tr>
    </tbody>
</table>
<?php
} else {
    echo 'Không tìm thấy mã đặt sân!';
}