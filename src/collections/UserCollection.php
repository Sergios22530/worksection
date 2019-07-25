<?php

namespace sergios\worksectionApi\src\collections;

use sergios\worksectionApi\src\models\User;
use yii\base\Model;

class UserCollection extends Collection
{
    protected $filterAttributes = ['id', 'email', 'firstName', 'lastName', 'name', 'post', 'avatar', 'company', 'department'];

    /**
     * Filter and validate comment models
     * @param array $params
     */
    public function filterByAttributes(array $params)
    {
        $this->validateFilterKeys($params, (new User()));

        if ($this->isEmpty()) {
            return $this;
        }

        $models = array_filter($this->getModels(), function ($model) use ($params) {
            return empty(array_diff($params, $model->getAttributes()));
        });

        $this->entity = $models;

        return $this;
    }


}