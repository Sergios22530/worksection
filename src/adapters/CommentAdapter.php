<?php

namespace sergios\yii2Worksection\src\adapters;

use sergios\yii2Worksection\src\mappers\CommentMapper;
use sergios\yii2Worksection\src\mappers\Mapper;
use sergios\yii2Worksection\src\models\Comment;
use yii\helpers\VarDumper;

class CommentAdapter extends Adapter
{


    public static function toApi(Comment $comment):array
    {
        return [];
    }

    public static function toClient():array
    {
        // TODO: Implement toClient() method.
        return [];
    }
}