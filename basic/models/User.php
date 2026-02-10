<?php

namespace app\models;

use yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id_user
 * @property string $fio_user
 * @property string $login_user
 * @property string $email_user
 * @property string $password_user
 * @property int $user_role
 *
 * @property Problem[] $problems
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        
    }

    public static function findByUsername($username)
    {
        return self::find()->where(['login_user' => $username])->one();
    }

    public function getId()
    {
        return $this->id_user;
    }

    public function getAuthKey()
    {

    }

    public function validatePassword($password)
    {
        return $this->password_user === $password;
    }
    public function validateAuthKey($authKey)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_role'], 'default', 'value' => 0],
            [['fio_user', 'login_user', 'email_user', 'password_user'], 'required'],
            [['user_role'], 'integer'],
            [['fio_user', 'login_user', 'email_user', 'password_user'], 'string', 'max' => 255],
            [['login_user'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id Пользователя',
            'fio_user' => 'ФИО',
            'login_user' => 'Логин пользователя',
            'email_user' => 'Email',
            'password_user' => 'Пароль',
            'user_role' => 'Роль',
        ];
    }

    /**
     * Gets query for [[Problems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblems()
    {
        return $this->hasMany(Problem::class, ['id_user' => 'id_user']);
    }

}