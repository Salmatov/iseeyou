<?php

namespace app\service;

use app\dto\UserCreationDTO;
use app\dto\UserUpdateDTO;
use app\models\User;
use Yii;

class UserService
{


    /**
     * @param UserCreationDTO $userCreateDTO
     * @return array|User
     * @throws \Exception
     */
    public static function createUser(UserCreationDTO $userCreateDTO):array|User
    {
        $userCreateDTO->validateOrException();
        $user = new User();
        if (self::getByEmail($userCreateDTO->email, false)) {
            throw new \Exception("Пользователь с таким email уже существует", 409);
        }
        $user->setAttributes($userCreateDTO->attributes, false);
        $user->password = Yii::$app->security->generatePasswordHash($userCreateDTO->password);
        $user->save();
        return $user;
    }

    /**
     * @param UserUpdateDTO $userUpdateDTO
     * @return User|array
     * @throws \Exception
     */
    public static function updateUser(UserUpdateDTO $userUpdateDTO)//: User|array
    {
        $user = self::getById($userUpdateDTO->id);
        $identityUser = self::getByEmail($userUpdateDTO->email, false);
        if ($identityUser && $identityUser->id!=$user->id){
            throw new \Exception("Пользователь с таким email уже существует", 409);
        }
        $user->username = $userUpdateDTO->username;
        $user->email = $userUpdateDTO->email;
        $user->roles = $userUpdateDTO->roles;
        if (!UserService::validateEnteredPassword($userUpdateDTO->password, $user->password)) {
            $user->password = Yii::$app->security->generatePasswordHash($userUpdateDTO->password);
        }
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public static function deleteUser(User $user): null|array
    {
        if (!$user->delete()) {
            throw new \Exception("Ошибка при удалении",500);
        }
        return null;
    }

    /**
     * @param $enteredPassword
     * @param $userPassword
     * @return bool
     */
    public static function validateEnteredPassword($enteredPassword, $userPassword): bool
    {
        return Yii::$app->getSecurity()->validatePassword($enteredPassword, $userPassword);
    }


    public static function getById(int $id, bool $throwExceptionIfNotFound=true): User|array|null
    {
        $user = User::getById($id);
        if ($user == null && $throwExceptionIfNotFound) {
            throw new \Exception("пользователь стаким id не найден", 404);
        }
        return $user;
    }

    private static function getByEmail(string $email, bool $throwExceptionIfNotFound=true): User|array|null
    {
        $user = User::getByEmail($email);
        if ($user == null && $throwExceptionIfNotFound) {
            throw new \Exception("Пользователь с таким email не найден", 404);
        }
        return $user;
    }

    public static function getAll(): array
    {
        $users = User::getAll();
        if ($users == null) {
            throw new \Exception("Пользователи не найдены", 404);
        }
        return $users;
    }
}
