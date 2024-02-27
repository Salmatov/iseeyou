<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{

    public static function tableName()
    {
        return 'user';
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


}