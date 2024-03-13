<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    const ADMIN_ROLE = 'admin';
    const MODERATOR_ROLE = 'moderator';
    const USER_ROLE = 'user';

    public static function tableName()
    {
        return 'user';
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['user_id' => 'id']);

    }

    public static function getById($id) : User|null
    {
        return self::findOne($id);
    }

    public static function getByEmail(string $email): User|null
    {
        return User::findOne(['email'=>$email,]);
    }

    public static function getByUsername($username): array|null
    {
        return self::find()->where(['username' => $username])->all();
    }

    public static function getByRoles($roles): array|null
    {
        return self::find()->where(['roles' => $roles])->all();
    }

    public static function getAll(): array
    {
        return self::find()->all();
    }
/*
    public static function getRoles(): array{
        return [
            self::ADMIN_ROLE,
            self::MODERATOR_ROLE,
            self::USER_ROLE
        ];
    }
*/

    public static function getByAuthKey(string $authKey):User|null
    {
        $user = User::findOne(['authKey'=>$authKey,]);
        return $user;
    }

    public static function findIdentity($id)
    {
        return self::getById($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken'=>$token,]);
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
}