<?php

namespace sergios\worksectionApi\src\mappers;

use sergios\worksectionApi\src\adapters\Adapter;
use sergios\worksectionApi\src\collections\Collection;
use sergios\worksectionApi\src\models\interfaces\ModelInterface;
use sergios\worksectionApi\src\models\Model;
use sergios\worksectionApi\src\WSApi;

/**
 * Class Mapper
 * @package frontend\components\worksectionApi\src\mappers
 *
 */
abstract class Mapper //extends Model
{
    abstract public function findAll();  
    
    abstract public function findByAttributes(array $params);

    abstract public function delete();

    abstract public function deleteByAttributes();

    abstract public function update();

    abstract public function create($model);

    abstract protected function createModel(array $attributes);

    abstract protected function createCollection(array $data);
}
