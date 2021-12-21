<?php

namespace frontend\models;

use common\models\UserInfo;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $primeiro_nome;
    public $ultimo_nome;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este nome de utilizador já foi registado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já foi registado.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['primeiro_nome', 'required'],
            ['primeiro_nome', 'string', 'max' => 30],

            ['ultimo_nome', 'required'],
            ['ultimo_nome', 'string', 'max' => 30],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            // Coloca o user com a role de User
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());


            $userInfo = new UserInfo();
            $userInfo->primeiro_nome = $this->primeiro_nome;
            $userInfo->ultimo_nome = $this->ultimo_nome;
            $userInfo->user_id = $user->getId();
            $userInfo->save(true);

            return $user;
        }

        return null;
    }
}
