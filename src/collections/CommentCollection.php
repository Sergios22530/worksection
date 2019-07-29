<?php

namespace sergios\worksectionApi\src\collections;

use Exception;
use sergios\worksectionApi\src\mappers\UserMapper;
use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\models\WSModel;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Class CommentCollection
 * @package sergios\worksectionApi\src\collections
 *
 * @property array $filterAttributes
 * @property array $filterUserAttributes
 */
class CommentCollection extends Collection
{
//    protected $filterAttributes;
//    protected $filterUserAttributes;
//
//    public function __construct()
//    {
//        $this->filterAttributes = Comment::getFilterAttributes();
//        $this->filterUserAttributes = Comment::getRelatedFilterAttributes();
//    }

    public function includeUsers()
    {

        if ($this->isEmpty()) {
            return $this;
        }

        $userMapper = new UserMapper();
        $userCollection = $userMapper->findAll();

        if ($userCollection->isEmpty()) {
            return $this;
        }

        array_map(function ($entity) use ($userCollection) {
            $user = $userCollection->findByAttributes(['email' => $entity->user->email]);

            if ($user) {
                $entity->setUser($user);
            }

            return $entity;
        }, $this->entity);

        return $this;
    }


    //TODO:: крайне спорный метод... а потом будет метод findByIssue? Или findByProject? Плохо расширяемый метод.

//    protected function filterByUser(array $params)
//    {
//        if (!ArrayHelper::keyExists('user', $params)) {
//            return null;
//        }
//
//        $userAttributes = $params['user'];
//        if (!is_array($userAttributes)) {
//            throw new InvalidConfigException('user attribute must be array');
//        }
//        if (empty($userAttributes)) {
//            throw new InvalidConfigException('user attribute must be not empty');
//        }
//
//        foreach ($this->filterUserAttributes as $filterAttribute) {
//            if (!ArrayHelper::keyExists($filterAttribute, $userAttributes)) {
//                throw new InvalidConfigException('Exempted filter properties for model User are ' . implode(', ', $this->filterUserAttributes));
//            }
//        }
//
//        if ($this->isEmpty()) {
//            return $this;
//        }
//
//        $models = array_filter($this->getModels(), function ($model) use ($params) {
//            $user = $model['user'];
//            return empty(array_diff($params['user'], $user->getAttributes()));
//        });
//
//        $this->entity = $models;
//    }
}
