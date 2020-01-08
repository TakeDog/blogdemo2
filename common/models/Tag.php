<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int|null $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tag){
        return explode(',',$tag);
    }

    public static function array2string($tagArr){
        return implode(',',$tagArr);
    }

    public static function addTags($tags){
        if(empty($tags)) return;
        foreach($tags as $name){
            $count = Tag::find() -> where(['name'=>$name]) -> count();

            if($count){
                $once = Tag::find() -> where(['name'=>$name]) -> one();
                $once -> frequency += 1;
                $once -> save();
            }else{
                $tag = new Tag;
                $tag -> name = $name;
                $tag -> frequency = 1;
                $tag -> save();
            }
        }
    }

    public static function removeTags($tags){
        if(empty($tags)) return;
        foreach($tags as $name){
            $count = Tag::find() -> where(['name'=>$name]) -> count();
            if($count){
                $tag = Tag::find() -> where(['name'=>$name]) -> one();
                if($tag -> frequency <= 1){
                   $tag -> delete(); 
                }else{
                    $tag -> freency -= 1;
                    $tag -> save();
                }
            }
        }
    }

    public static function updateFrequency($oldTags,$newTags){
        if(!empty($oldTags) || !empty($newTags)){
            $oldTagArr = self::string2array($oldTags);
            $newTagArr = self::string2Array($newTags);
            self::addTags(array_values(array_diff($newTagArr,$oldTagArr)));
            self::removeTags(array_values(array_diff($oldTagArr,$newTagArr)));
        }
    }

    public static function findTagWeights($limit=20){
        $tag_size_level = 5;
        $models = Tag::find() -> orderBy("frequency desc") -> limit($limit) -> all();
        $total = Tag::find() -> limit($limit) -> count();

        $stepper = ceil($total/$tag_size_level);
        $tags = array();
        $counter = 1;

        if($total>0){
            foreach($models as $model){
                $weight = ceil($counter/$stepper) + 1;
                $tags[$model -> name] = $weight;
                $counter++;
            }
            ksort($tags);
        }

        return $tags;
    }
    
}
