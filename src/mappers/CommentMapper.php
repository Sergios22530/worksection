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
        $criteria = (new WSRequestCriteria('get_comments'))->setPage($this->page);

        $response = WSRequest::getInstance()->get($criteria);
        if (!$response) {
            throw new Exception('Не удалось получить ответ от worksection api');
        }

        return $this->createCollection($response['data']);
    }

    public function findByAttributes(array $params)
    {
        if (empty($params)) {
            throw new Exception("Params cannot be empty");
        }

        $criteria = (new WSRequestCriteria('get_comments'))
            ->setPage($this->page)
            ->setParams($params);

        $response = WSRequest::getInstance()->get($criteria);
        if (!$response) {
            throw new Exception('Не удалось получить ответ от worksection api');
        }

        $collection = $this->createCollection($response['data']);
        $collection->includeUsers();

        return $collection->filterByAttributes($params);
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

        if (!WSRequest::getInstance()->post($criteria)) {
            throw new Exception('Не удалось получить ответ от worksection api');
        }

        if ($filePath) {
            $model->deleteImage();
        }

        return $model;
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
            $collection->setModel($this->createModel($attributes));
        }

        return $collection;
    }
}
