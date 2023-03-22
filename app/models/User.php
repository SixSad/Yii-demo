<?php

namespace app\models;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property string $role
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $passwordRepeat;
    public $check;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'fullname'], 'required'],
            [['username', 'email', 'password', 'fullname', 'role'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],
            [['check'], 'compare', 'compareValue' => 1],
            [['role'], 'default', 'value' => 'user']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'fullname' => 'Фио',
            'role' => 'Роль',
            'passwordRepeat' => 'Повторите пароль',
            'check' => 'Подтвердите отправку формы'
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }
}
