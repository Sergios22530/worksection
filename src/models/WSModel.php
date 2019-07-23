<?php

namespace sergios\worksectionApi\src\models;

use \yii\base\Model;

abstract class WSModel extends Model
{
    abstract protected function filter(array $attributes);
}
