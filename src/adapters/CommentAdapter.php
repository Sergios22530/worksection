<?php

namespace sergios\worksectionApi\src\adapters;

use sergios\worksectionApi\src\mappers\CommentMapper;
use sergios\worksectionApi\src\mappers\Mapper;
use sergios\worksectionApi\src\models\Comment;
use yii\helpers\VarDumper;

class CommentAdapter extends Adapter
{


    public static function toApi(Comment $comment): array
    {
        $attach = [];
        $image = $comment->getImage();
        if ($image) {
            $attach['attach[]'] = $image;
        }

        return array_merge([
            'email_user_from' => $comment->email,
            'text' => $comment->text,
        ], $attach, $comment->getTodoList());
    }

    public static function toClient(array $attributes): array
    {
        return $attributes;
    }
}
