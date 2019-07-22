<?php

namespace sergios\yii2Worksection\src\mappers;

use sergios\yii2Worksection\src\adapters\Adapter;
use sergios\yii2Worksection\src\models\interfaces\ModelInterface;
use sergios\yii2Worksection\src\models\Model;
use sergios\yii2Worksection\src\WSApi;

/**
 * Class Mapper
 * @package frontend\components\yii2Worksection\src\mappers
 *
 * @property WSApi $wsApi
 */
abstract class Mapper //extends Model
{

    protected $adapter;


    abstract public function findByUserName($userName);

    abstract public function findByUserEmail();

    abstract public function findByAttributes($model);

    abstract public function delete();

    abstract public function deleteByAttributes();

    abstract public function update();

    abstract public function create();

    abstract protected function createModel();

    abstract protected function createCollection();



}