<?php

namespace sergios\worksectionApi\src\collections;

class Collection
{
    protected $entity = [];

    public function setModel($model)
    {
        //TODO check for identity
        $this->entity[] = $model;
    }

    public function getModels()
    {
        return $this->entity;
    }
}
