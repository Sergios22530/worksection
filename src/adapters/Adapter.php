<?php

namespace sergios\yii2Worksection\src\adapters;

use sergios\yii2Worksection\src\mappers\Mapper;
use sergios\yii2Worksection\src\models\Comment;
use sergios\yii2Worksection\src\WSApi;

abstract class Adapter
{
    abstract public static function toApi(Comment $comment):array;

    abstract public static function toClient():array;
}