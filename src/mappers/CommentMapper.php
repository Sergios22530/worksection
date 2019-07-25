<?php

namespace sergios\worksectionApi\src\mappers;

use Exception;
use sergios\worksectionApi\src\collections\CommentCollection;
use sergios\worksectionApi\src\adapters\CommentAdapter;
use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\services\WSRequestCriteria;
use sergios\worksectionApi\src\services\WSRequest;
use Yii;

class CommentMapper extends Mapper
{
    private $page;

    public function __construct(string $page)
    {
        $this->page = $page;
    }

    public function findAll()
    {
        $criteria = (new WSRequestCriteria('get_comments'))
            ->setPage($this->page);

        $data = WSRequest::getInstance()->get($criteria);

        if ($data) {
            return $this->createCollection($data['data']); //TODO: FILTERING DATA
        }
        //TODO: create error request
        return $data;
    }

    public function findByAttributes(array $params)
    {
        if (empty($params)) {
            throw new Exception("Params cannot be empty");
        }

        $criteria = (new WSRequestCriteria('get_comments'))
            ->setPage($this->page)
            ->setParams($params);

        $data = WSRequest::getInstance()->get($criteria);

        if ($data) {
            $collection = $this->createCollection($data['data']);

            return $collection->filterByAttributes($params);
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

        $criteria = (new WSRequestCriteria('post_comment'))
            ->setPage($this->page)
            ->setParams(CommentAdapter::toApi($model));

        $filePath = $model->getImage();
        if ($filePath) {
            $criteria->setFilePath($filePath);
        }

        $data = WSRequest::getInstance()->post($criteria);

        if ($data) {
            if ($filePath) {
                $model->deleteImage();
            }
            return $model;
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
