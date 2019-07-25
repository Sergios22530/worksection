<?php

namespace sergios\worksectionApi\src\adapters;

use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\models\User;
use sergios\worksectionApi\src\services\WSRequest;
use Yii;
use yii\helpers\ArrayHelper;

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
            'email_user_from' => $comment->user->email,
            'text' => $comment->text,
        ], $attach, $comment->getTodoList());
    }

    public static function toClient(array $attribute): array
    {
        $user = new User();
        $user->setAttributes([
            'email' => $attribute['user_from']['email'],
            'name' => $attribute['user_from']['name']
        ]);

        $resultAttributes = [
            'text' => $attribute['text'],
            'date_added' => $attribute['date_added']
        ];

        if ($user->validate()) {
            $resultAttributes['user'] = $user;
        }

        if (ArrayHelper::keyExists('files', $attribute) && !empty($attribute['files'])) {
            $resultAttributes['file'] = WSRequest::getInstance()->getApiDomain() . $attribute['files'][0]['link'];
        }

        return $resultAttributes;
    }
}
