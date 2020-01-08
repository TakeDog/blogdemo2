<?php
namespace frontend\components;

use Yii;
use yii\Base\Widget;
use yii\helpers\Html;

class TagCloundWidget extends Widget{

    public $tags;
    public function init(){
        parent::init();
    }

    public function run(){
        $tagStrings = '';
        $fontStyle = [
            "2" => 'success',
            '3' => 'primary',
            '4' => 'warning',
            '5' => 'info',
            '6' => 'danger'
        ];
        foreach($this -> tags as $tag => $weight){
            $tagStrings .= "&nbsp;&nbsp;<a href='".Yii::$app -> homeUrl."?r=post/index&PostSearch[tags]=".$tag."'><h".$weight." style='display:inline-block;'><span class='label label-".$fontStyle[$weight]."'>".$tag."</span></h".$weight."></a>";
        }

        return $tagStrings;
    }
}