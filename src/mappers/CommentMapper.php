<?php

namespace sergios\yii2Worksection\src\mappers;

use Exception;
use sergios\worksectionApi\src\collections\CommentCollection;
use sergios\yii2Worksection\src\adapters\CommentAdapter;
use sergios\yii2Worksection\src\models\Comment;
use sergios\yii2Worksection\src\WSApiCriteria;
use sergios\yii2Worksection\src\WSRequest;

class CommentMapper extends Mapper
{

    private $page;

    public function __construct(string $page)
    {
        $this->page = $page;
    }

    public function findByAttributes(array $params)
    {
        if (empty($params)) {
            throw new Exception("Params cannot be empty");
        }

        $criteria = (new WSApiCriteria('get_comments'))
            ->setPage($this->page)
            ->setParams($params);

        $data = WSRequest::getInstance()->get($criteria);
        if ($data) {
            return $this->createCollection($data);
        }

        //TODO: create error request
        return $data;
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function deleteByAttributes()
    {
        // TODO: Implement deleteByAttributes() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function create($model)
    {
        if (empty($model)) {
            throw new Exception("Model cannot be empty");
        }

        if (!$model->validate()) {
            throw new Exception("Model has errors: " . implode('\n', $model->getErrors()));
        }

        $criteria = (new WSApiCriteria('get_comments'))
            ->setPage($this->page)
            ->setParams(CommentAdapter::toApi($model));

        $data = WSRequest::getInstance()->post($criteria);

        if ($data) {
            return $this->createCollection($data);
        }

        //TODO: create error request
        return $data;
    }

    protected function createModel(array $attributes)
    {
        $model = new Comment();
        $model->setAttributes(CommentAdapter::toClient($attributes));

        if ($model->validate()) {
            return $model;
        }

        //TODO logger need here
        return null;
    }

    protected function createCollection(array $data)
    {
        $collection = new CommentCollection();

        foreach ($data as $attributes) {

            $model = $this->createModel($attributes);
            if ($model) {
                $collection->setModel($model);
                continue;
            }

            //todo set logger here
        }

        return $collection;
    }
}
