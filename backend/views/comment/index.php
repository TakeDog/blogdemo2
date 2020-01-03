<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommentStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['width'=>'20px']
            ],
            [
                'attribute' => 'posttitle',
                'value' => 'posttitle'
            ],
            //'content:ntext',
            [
                "attribute" => 'content',
                'value' => 'begining'
                //     $temStr = strip_tags($model -> content);
                //     $temStrLen = mb_strlen($temStr);
                //     return mb_substr($temStr,0,20,'utf-8').($temStrLen>20 ?'...':'');
                // }
            ],
            [
                'attribute'=>'status',
                'value'=> 'status0.name',
                'filter' => CommentStatus::find() -> select('name,id') -> orderBy('position') -> indexBy('id') -> column(),
                'filterInputOptions' => ['prompt'=>'全部','class'=>'form-control'],
                'contentOptions' => function($model){
                    return $model -> status == 1 ? ['class'=>'bg-danger'] : [];
                }
            ],
            [
                'attribute' => 'create_time',
                'format' => ['date' , "php:Y-m-d H:i:s"]
            ],
            ['attribute'=>'username',
            'value' => 'user.username',
            ],
            //'email:email',
            //'url:url',
            //'post_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}  {update}  {delete}  {approve}",
                'buttons' => [
                    'approve' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','审核'),
                            'aria-label' => Yii::t('yii','审核'),
                            'data-confirm' => Yii::t('yii','您确定通过该评论？'),
                            'data-method' => 'post',
                            'data-pjax' => 0
                        ];
                        return Html::a("<span class='glyphicon glyphicon-check'></span>",$url,$options);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
