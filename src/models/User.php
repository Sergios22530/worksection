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

    public function setAttributes($values, $safeOnly = true)
    {
        if (!empty($this->filter($values))) {
            parent::setAttributes($values, $safeOnly);
        }
    }

    /**
     * Filter data by user params
     * @param array $attributes
     * @return array
     */
    protected function filter(array $attributes)
    {
        if (ArrayHelper::keyExists('filterParams', Yii::$app->params)) {
            array_diff_ukey($attributes, Yii::$app->params['filterParams'], function ($modelKey, $filterKey) use (&$attributes) {
                if ($modelKey == $filterKey) {
                    if ($attributes[$modelKey] != Yii::$app->params['filterParams'][$modelKey]) {
                        $attributes = [];
                    }
                }
            });
        }

        return $attributes;
    }

    public static function getFilterAttributes()
    {
        return ['id', 'email', 'firstName', 'lastName', 'name', 'post', 'avatar', 'company', 'department'];
    }

}