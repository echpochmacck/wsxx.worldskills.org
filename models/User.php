<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $passphrase
 * @property string $authKey
 * @property string $email
 * @property int $role_id
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['passphrase', 'email', 'role_id'], 'required'],
            [['role_id'], 'integer'],
            [['passphrase', 'authKey', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'passphrase' => 'Passphrase',
            'authKey' => 'Auth Key',
            'email' => 'Email',
            'role_id' => 'Role ID',
        ];
    }

    public function setAuth($save = false)
    {
        $this->authKey = Yii::$app->security->generateRandomString();
        $save && $this->save(false);
    }

    public static function findByUsername($username)
    {

        return self::findOne(['email' => $username]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->passphrase === $password;
    }

    public function GetisAdmin()
    {
        return $this->role_id = Role::getRoleId('admin');
    }
}
