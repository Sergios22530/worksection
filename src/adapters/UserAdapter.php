<?php

namespace sergios\worksectionApi\src\adapters;

use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\models\User;

class UserAdapter extends Adapter
{

    public static function toApi(Comment $comment): array
    {
        return [];
    }

    public static function toClient(array $attributes): array
    {
        return [
            'id' => (integer)$attributes['id'],
            'email' => $attributes['email'],
            'firstName' => $attributes['first_name'],
            'lastName' => $attributes['last_name'],
            'name' => $attributes['name'],
            'post' => $attributes['title'],
            'avatar' => $attributes['avatar'],
            'company' => $attributes['company'],
            'department' => $attributes['department'],
        ];
    }
}