<?php

namespace sergios\yii2Worksection\src\mappers;

use sergios\yii2Worksection\src\adapters\Adapter;
use sergios\yii2Worksection\src\collections\Collection;
use sergios\yii2Worksection\src\models\interfaces\ModelInterface;
use sergios\yii2Worksection\src\models\Model;
use sergios\yii2Worksection\src\WSApi;

/**
 * Class Mapper
 * @package frontend\components\yii2Worksection\src\mappers
 *
 */
abstract class Mapper //extends Model
{

    abstract public function findByAttributes(array $params);

    abstract public function delete();

    abstract public function deleteByAttributes();

    abstract public function update();

    abstract public function create($model);

    abstract protected function createModel(array $attributes);

    abstract protected function createCollection(array $data);
}
