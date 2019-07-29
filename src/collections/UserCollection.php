<?php

namespace sergios\worksectionApi\src\collections;

use sergios\worksectionApi\src\models\User;
use yii\base\Model;
use Exception;

class UserCollection extends Collection
{
    protected $filterAttributes;

    public function __construct()
    {
        $this->filterAttributes = User::getFilterAttributes();
    }

    /**
     * Filter and validate comment models
     * @param array $params
     * @return UserCollection
     * @throws Exception
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
