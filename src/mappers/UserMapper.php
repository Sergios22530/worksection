<?php

namespace sergios\worksectionApi\src\mappers;

use Exception;
use sergios\worksectionApi\src\adapters\CommentAdapter;
use sergios\worksectionApi\src\collections\CommentCollection;
use sergios\worksectionApi\src\collections\UserCollection;
use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\models\User;
use sergios\worksectionApi\src\services\WSRequest;
use sergios\worksectionApi\src\services\WSRequestCriteria;
use Yii;
use sergios\worksectionApi\src\adapters\UserAdapter;

class UserMapper extends Mapper
{
    private $page;

    public function __construct(string $page)
    {
        $this->page = $page;
    }

    public function findAll()
    {
        $criteria = (new WSRequestCriteria('get_users'))
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

        Yii::$app->params['filterParams'] = $params;

        $criteria = (new WSRequestCriteria('get_users'))
            ->setPage($this->page)
            ->setParams($params);

        $data = WSRequest::getInstance()->get($criteria);

        if ($data) {
            return $this->createCollection($data['data']);
        }
        //TODO: create error request
        return $data;
    }

    public function delete()
    {

    }

    public function deleteByAttributes()
    {

    }

    public function update()
    {

    }

    public function create($model)
    {

    }

    protected function createModel(array $attributes)
    {
        $model = new User();
        $model->setAttributes(UserAdapter::toClient($attributes));

        if ($model->validate()) {
            return $model;
        }

        //TODO logger need here
        return null;
    }

    protected function createCollection(array $data)
    {
        $collection = new UserCollection();

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