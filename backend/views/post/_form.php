<?php

use yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use common\models\Adminuser;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php 
        //$statusObjs = Yii::$app -> db -> createCommand('select * from poststatus') -> queryAll();
        //$statusObjs = PostStatus::find() -> all();
        $statusObjs = (new yii\db\Query()) -> select(['name','id']) -> from('poststatus') -> indexBy('id') -> column();
        //$statusArr = ArrayHelper::map($statusObjs,'id','name');   //把数组对象按照map映射关系转换成一维数组。
    ?>

    <?= $form -> field($model,'status') -> dropDownList(Poststatus::find() -> select('name,id') -> indexBy('id') -> column(),['prompt'=>'请选择状态']) ?>

    <?= $form->field($model, 'author_id') -> dropDownList(Adminuser::find() -> select('nickname,id') -> indexBy('id') -> column(),['prompt'=>'请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
