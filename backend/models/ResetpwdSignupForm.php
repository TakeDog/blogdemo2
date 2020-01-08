<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\AdminUser;

/**
 * Signup form
 */
class ResetpwdSignupForm extends Model
{   
   
    public $password;
    public $password_reapt;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_reapt','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password_reapt' => '重复密码'
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($id)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $adminuser = AdminUser::findOne($id);

        $adminuser->setPassword($this->password);
        $adminuser->removePasswordResetToken();
        //$user->generateEmailVerificationToken();
        return $adminuser->save();

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
