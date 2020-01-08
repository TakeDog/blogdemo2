<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use common\models\Tag;
use common\models\Comment;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $tags
 * @property int $status
 * @property int|null $create_time
 * @property int|null $update_time
 * @property int $author_id
 *
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $status0
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $_oldTag;
    

    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Poststatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id' => '作者',
            'authorName' => '作者'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::className(), ['id' => 'status']);
    }

    public function beforeSave($insert){
        if(Parent::beforeSave($insert)){

            if($insert){
                $this -> create_time = time();
                $this -> update_time = time();
            }else{
                $this -> update_time = time();
            }
            return true;

        }else{
            return false;
        }
    }

    public function afterFind(){
        parent::afterFind();
        return $this -> _oldTag = $this -> tags;
    }

    public function afterSave($insert,$changeAttributes){
        parent::afterSave($insert,$changeAttributes);
        Tag::updateFrequency($this -> _oldTag,$this -> tags);
    }
    public function afterDelete(){
        parent::afterDelete();
        Tag::updateFrequency($this -> tags,'');
    }
    

    public function getUrl(){
        return Yii::$app -> urlManager -> createUrl([
            'detail',
            'id' => $this -> id,
            'title' => $this -> title
        ]);
    }


    public function getBegining($len=288){
        $temStr = strip_tags($this -> content);
        $temStrLen = mb_strlen($temStr);
        return mb_substr($temStr,0,$len,'utf-8').($temStrLen>$len ?'...':'');
    }

    public function getTagLinks(){
        $links = array();
        foreach(Tag::string2array($this -> tags) as $tag){
            $links[] = Html::a(Html::encode($tag),array('index','PostSearch[tags]' => $tag));
        }
        return $links;
    }

    public function getCommentCount(){
        return Comment::find() -> where(['post_id'=>$this -> id,'status'=>2]) -> count();
    }

    

}
