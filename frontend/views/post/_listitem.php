<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post">
    <div class="title">
        <h2>
            <a href="<?=$model->url;?>"><?=Html::encode($model -> title);//$model为自动接收的model对象?></a> 
        </h2>
        <div class="author">
            <span class="glyphicon glyphicon-time"></span><?=date('Y-m-d H:i:s',$model -> create_time);?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            <span class="glyphicon glyphicon-user"></span><?=Html::encode($model -> author -> nickname);?>
        </div>
    </div>
    <br/>
    <div class="content">
        <?=$model -> begining;?>
    </div>
    <div class="nav">
        <span class="glyphicon glyphicon-tag"></span>
        <?=implode(', ',$model -> tagLinks);?>
        </br>
        <?=Html::a('评论'.$model -> commentCount,$model -> url."#comment");?> | 最后修改：<?=date('Y-m-d H:i:s',$model -> update_time);?>
    </div>
</div> 