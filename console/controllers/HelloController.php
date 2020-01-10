<?php
namespace console\controllers;
use yii\console\Controller;
use common\models\Post;

class HelloController extends Controller{

    // public $rev;

    // public function options(){
    //     //Parent::options();
    //     return ['rev'];
    // }

    // public function optionAliases(){
    //     return ['r'=>'rev'];
    // }
    public function actionIndex(){
        echo "Hello world!";
    }

    public function actionList(){
        $list = Post::find() -> all();
        foreach($list as $item){
            echo $item['title']."\n";
        }
    }

    public function actionUserMsg($name){
        echo "He name is  he age is $name\n";
    }

    

}
