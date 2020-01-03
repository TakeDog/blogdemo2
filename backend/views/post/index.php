<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            ['attribute'=>'authorName','value'=>'author.nickname'],
            //'content:ntext',
            'tags:ntext',
            ['attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>Poststatus::find()->select('name,id') -> orderBy('position') -> indexBy('id') -> column(),
            'filterInputOptions' => ['prompt'=>'请选择状态','class'=>'form-control']
            ],
            ['attribute'=>'update_time',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            //'create_time:datetime',
            //'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
