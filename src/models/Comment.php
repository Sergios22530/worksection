<?php

namespace sergios\worksectionApi\src\models;

use Exception;
use sergios\worksectionApi\src\helpers\ImageHelper;
use Yii;
use yii\web\UploadedFile;
use sergios\worksectionApi\src\models\User;

/**
 * Class Comment
 * @package sergios\worksectionApi\src\models
 *
 * @property string $text
 * @property string $date_added
 * @property string $fileUrl
 * @property $user User
 */
class Comment extends WSModel
{
    public $text;
    public $date_added;
    public $fileUrl;

    private $user = null;

    protected $pathToImage = '';
    protected $todo = [];

    public function rules()
    {
        return [
            ['text', 'required'],
            ['user', 'validateUser'],
            [['text', 'date_added', 'fileUrl'], 'string'],
        ];
    }

    public function validateUser($attribute)
    {
        if (!$this->{$attribute} instanceof User) {
            $this->addError($attribute, "Attribute {$attribute} must have " . User::class . ' object');
        }
    }


    public function setTodo(int $index, string $text)
    {
        $key = "todo[{$index}]";
        $value = $text ? trim($text) : '-';
        $number = $index + 1;

        $this->todo[$key] = "{$number}. {$value}";
    }

    public function setTodoList($todoList)
    {
        foreach ($todoList as $todo) {
            $this->setTodo($todo['index'], $todo['value']);
        }
    }

    public function deleteImage()
    {
        if (file_exists($this->pathToImage)) {
            return unlink($this->pathToImage);
        }

        throw new Exception('File is not defined');
    }

    public function setImageFromUploadedInstance(UploadedFile $image)
    {
        $imageHelper = new ImageHelper();
        $this->pathToImage = $imageHelper->saveImage($image);
    }

    public function getImage()
    {
        return $this->pathToImage;
    }

    public function getTodoList()
    {
        return $this->todo;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function issetUser()
    {
        return !is_null($this->user);
    }

    protected function filter(array $attributes)
    {
        //TO DO: FILTERING BY PARAMS FOR COMMENT
        return true;
    }
}
