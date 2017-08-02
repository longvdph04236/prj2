<?php


$this->title= 'Thêm Mới';
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('_form',['model'=>$model]); ?>