<?php

namespace app\models;

use yii\db\ActiveRecord;

class ResidentialComplex extends ActiveRecord
{
    public static function tableName()
    {
        return 'residentialComplex';
    }

    public function getApartments()
    {
        return $this->hasMany(Apartment::className(), ['residenceId' => 'id']);
    }

    public static function getById($id): ResidentialComplex|null
    {
        return self::findOne($id);
    }

    public static function getAll(): array|null
    {
        return self::find()->all();
    }

    public static function getByName($name): array|null
    {
        return self::find()->where(['name' => $name])->all();
    }
}