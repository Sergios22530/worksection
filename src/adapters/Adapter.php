<?php

namespace sergios\worksectionApi\src\adapters;

use sergios\worksectionApi\src\mappers\Mapper;
use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\WSApi;

abstract class Adapter
{
    abstract public static function toApi(Comment $comment):array;

    abstract public static function toClient(array $attributes):array;
}
