<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'nickname',
            'email:email',
            'profile:ntext',
            //'password_hash',
            //'password_reset_token',
            //'auth_key',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}  {update}  {delete}  {resetpwd} {privilege}",
                'buttons' => [
                    'resetpwd' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','重设密码'),
                            'aria-label' => Yii::t('yii','重设密码'),
                            'data-pjax' => 0
                        ];
                        return Html::a("<span class='glyphicon glyphicon-cog'></span>",$url,$options);
                    },
                    'privilege' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','修改权限'),
                            'aria-label' => Yii::t('yii','修改权限'),
                            'data-pjax' => 0
                        ];
                        return Html::a("<span class='glyphicon glyphicon-lock'></span>",$url,$options);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
