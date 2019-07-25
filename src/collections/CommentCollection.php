<?php

namespace sergios\worksectionApi\src\collections;


use Exception;
use sergios\worksectionApi\src\models\Comment;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class CommentCollection
 * @package sergios\worksectionApi\src\collections
 *
 * @property array $filterAttributes
 * @property array $filterUserAttributes
 */
class CommentCollection extends Collection
{
    protected $filterAttributes = ['text', 'date_added', 'user'];
    protected $filterUserAttributes = ['email', 'name'];

    /**
     * Filter and validate comment models
     * @param array $params
     */
    public function filterByAttributes(array $params)
    {
        $this->validateFilterKeys($params, (new Comment()));
        $this->filterByUser($params);

        $data = $this->getModels();
        if ($data) {
            foreach ($data as $key => $model) {
                /** @var $model Model */
                $modelAttributes = $model->getAttributes();
                unset($modelAttributes['user']);
                unset($params['user']);
                $filterResult = array_diff($params, $modelAttributes);
                if (!empty($filterResult)) {
                    $this->removeModel($key);
                }
            }
        }
    }

    /**
     * Filter and validate user models
     * @param array $params
     * @throws InvalidConfigException
     */
    protected function filterByUser(array $params)
    {
        if (ArrayHelper::keyExists('user', $params)) {
            $userAttributes = $params['user'];
            if (!is_array($userAttributes)) {
                throw new InvalidConfigException('user attribute must be array');
            }
            if (empty($userAttributes)) {
                throw new InvalidConfigException('user attribute must be not empty');
            }

            foreach ($this->filterUserAttributes as $filterAttribute) {
                if (!ArrayHelper::keyExists($filterAttribute, $userAttributes)) {
                    throw new InvalidConfigException('Exempted filter properties for model User are ' . implode(', ', $this->filterUserAttributes));
                }
            }

            $data = $this->getModels();
            if ($data) {
                foreach ($data as $key => $model) {
                    $user = $model['user'];
                    if ($user) {
                        $filterResult = array_diff($params['user'], $user->getAttributes());
                        if (!empty($filterResult)) {
                            $this->removeModel($key);
                        }
                    }
                }
            }
        }
    }

}
