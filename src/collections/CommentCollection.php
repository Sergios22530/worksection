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

            if (count($user)) {
                $entity->setUser(array_pop($user));
            }

            return $entity;
        }, $this->entity);

        return $this;
    }
}
