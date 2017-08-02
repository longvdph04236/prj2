<?php
$this->title = 'Cập Nhật Khu vực';
$this->params['breadcrumbs'][]= $this->title . ' '. strtoupper($model->name);
echo $this->render('_form',['model'=>$model]);