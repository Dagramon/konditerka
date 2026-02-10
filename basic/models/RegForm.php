<?php

namespace app\models;

use Yii;

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
class RegForm extends User
{

    public $passwordConfirm;
    public $agree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_role'], 'default', 'value' => 0],
            [['fio_user', 'login_user', 'email_user', 'password_user', 'passwordConfirm', 'agree'], 'required', 'message' => 'Поле обязательно для заполнения'],
            ['fio_user', 'match', 'pattern' => '/^[А-Яа-я\s\-]{5,}$/u', 'message' => 'Только кириллица, пробелы и дефис'],
            ['login_user', 'match', 'pattern' => '/^[a-zA-Z0-9]{1,}$/u', 'message' => 'Только латинские буквы и цифры'],
            ['email_user', 'email', 'message' => 'Некорректный email-адрес'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password_user', 'message' => 'Пароли должны совпадать'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true, 'message' => 'Необходимо согласиться'],
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
            'login_user' => 'Логин',
            'email_user' => 'Email',
            'password_user' => 'Пароль',
            'user_role' => 'Роль',
            'passwordConfirm' => 'Подтверждение пароля',
            'agree' => 'Даю согласие на отработку антона'
        ];
    }
}