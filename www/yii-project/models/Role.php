<?php

namespace app\models;

class Role extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }


}