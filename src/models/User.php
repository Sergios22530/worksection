<?php


namespace sergios\worksectionApi\src\models;

use Yii;
use yii\helpers\ArrayHelper;

class User extends WSModel
{
    public $email;
    public $name;

    public $id = null;
    public $firstName = null;
    public $lastName = null;
    public $post = null;
    public $avatar = null;
    public $company = null;
    public $department = null;

    public function rules()
    {
        return [
            [['email'], 'required'],//, 'name'
            [['email', 'name', 'firstName', 'lastName', 'post', 'avatar', 'company', 'department'], 'string'],
            ['email', 'email'],
            ['id', 'integer'],
            [['firstName', 'lastName', 'post', 'avatar', 'company', 'department', 'id'], 'default', 'value' => null]
        ];
    }

    public static function getFilterAttributes()
    {
        return ['id', 'email', 'firstName', 'lastName', 'name', 'post', 'avatar', 'company', 'department'];
    }

    protected function getRelatedModelsNames()
    {
        return [];
    }
}