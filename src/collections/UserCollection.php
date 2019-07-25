<?php

namespace sergios\worksectionApi\src\collections;

use sergios\worksectionApi\src\models\User;
use yii\base\Model;

class UserCollection extends Collection
{
    protected $filterAttributes = ['id', 'email', 'firstName', 'lastName', 'name', 'post', 'avatar', 'company', 'department'];

    /**
     * Filter and validate comment models
     * @param array $params
     */
    public function filterByAttributes(array $params)
    {
        $this->validateFilterKeys($params, (new User()));

        $data = $this->getModels();
        if ($data) {
            foreach ($data as $key => $model) {
                /** @var $model Model */
                $modelAttributes = $model->getAttributes();
                $filterResult = array_diff($params, $modelAttributes);
                if (!empty($filterResult)) {
                    $this->removeModel($key);
                }
            }
        }

        return $this->getModels();
    }


}