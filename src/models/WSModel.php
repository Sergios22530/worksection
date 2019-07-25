<?php

namespace sergios\worksectionApi\src\models;

use \yii\base\Model;

abstract class WSModel extends Model
{
    abstract static public function getFilteredFields();
}
