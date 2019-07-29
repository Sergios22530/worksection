<?php

namespace sergios\worksectionApi\src\collections;

use Exception;
use yii\helpers\ArrayHelper;

abstract class Collection
{
    protected $entity = [];

    public function setModel($model = null)
    {
        if (!$model) {
            return;
        }

        //TODO check for identity
        $this->entity[] = $model;
    }

    public function getModels()
    {
        return $this->entity;
    }

    public function removeModel($key)
    {
        if (ArrayHelper::keyExists($key, $this->entity)) {
            unset($this->entity[$key]);
        }
    }

    public function isEmpty()
    {
        return empty($this->entity);
    }

    /**
     * Filter and validate comment models
     * @param array $params
     * @return CommentCollection
     * @throws Exception
     */
    public function filterByAttributes(array $params)
    {
        if ($this->isEmpty()) {
            return $this;
        }

        $models = array_filter($this->getModels(), function ($model) use ($params) {
            return $model->isRelevant($params);
        });

        $this->entity = $models;

        return $this;
    }

    public function findByAttributes(array $params)
    {
        if ($this->isEmpty()) {
            return $this;
        }

        $models = array_filter($this->getModels(), function ($model) use ($params) {
            return $model->isRelevant($params);
        });


        return $models;
    }


//    public function validateFilterKeys(array $filterParams, $model)
//    {
//        $exemptedAttributes = get_object_vars($model);
//        foreach ($filterParams as $key => $value) {
//            if (!ArrayHelper::keyExists($key, $exemptedAttributes)) {
//                throw new Exception('Exempted filter properties for model ' . (new \ReflectionClass($model))->getShortName() . ' are ' . implode(', ', $this->filterAttributes));
//            }
//        }
//    }
}
