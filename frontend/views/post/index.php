<?php
use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use frontend\components\TagCloundWidget;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$search = Yii::$app->request->queryParams;

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?=ListView::widget([
                'id'=>'postList',
                'dataProvider' => $dataProvider,
                'itemView' => '_listitem',
                'layout' => '{items} {pager}',
                'pager' => [
                    'maxButtonCount' => 10,
                    'nextPageLabel' => Yii::t('app','下一页'),
                    'prevPageLabel' => Yii::t('app','下一页')
                ]
            ]);
            
            ?>
        </div>
        <div class="col-md-3">
            <div class="searchBox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查找文章
                    </li>
                    <li class="list-group-item">
                        <form class="form-inline" action="index.php?r=post/index" method="GET">
                            <div class="form-group" style="width:172px;">
                                <input type="text" style="width:100%;" value="<?=isset($search['PostSearch']['title']) ? $search['PostSearch']['title']:'';?>" class="form-control" name="PostSearch[title]" id="postTitle" placeholder="请输入标题">
                            </div>
                            <button type="submit" class="btn btn-default">查询</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="tagBox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> 标签云
                    </li>
                    <li class="list-group-item">
                       <?=TagCloundWidget::widget(['tags'=>$tags]);?>
                    </li>
                </ul>
            </div>
            
            <div class="commentBox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 最新回复
                    </li>
                    <li class="list-group-item">最新回复</li>
                </ul>
            </div>

        </div>

    </div>

</div>
