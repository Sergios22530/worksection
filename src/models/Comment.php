<?php

namespace sergios\worksectionApi\src\models;

use Exception;
use sergios\worksectionApi\src\helpers\ImageHelper;
use sergios\worksectionApi\src\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class Comment
 * @package sergios\worksectionApi\src\models
 *
 * @property string $text
 * @property string $dateAdded
 * @property string $fileUrl
 * @property $user User
 */
class Comment extends WSModel
{
    public $text;
    public $dateAdded; // example  2019-07-24 11:01
    public $fileUrl;

    public $user = null;

    protected $pathToImage = '';
    protected $todo = [];

    public function rules()
    {
        return [
            ['text', 'required'],
            ['user', 'validateUser'],
            [['text', 'fileUrl', 'dateAdded'], 'string'],
        ];
    }

    public function validateUser($attribute)
    {
        if (!$this->{$attribute} instanceof User) {
            $this->addError($attribute, "Attribute {$attribute} must have " . User::class . ' object');
        }
    }

    public function setUser(User $user)
    {
        $this->user = $user;
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

    public function saveImage(UploadedFile $image)
    {
        $imageHelper = new ImageHelper();
        $this->pathToImage = $imageHelper->saveImage($image);
    }

    public function getImage()
    {
        return $this->pathToImage;
    }

    protected function getRelatedModelsNames()
    {
        return ['user'];
    }

    public function getTodoList()
    {
        return $this->todo;
    }

    public function getUser()
    {
        return $this->user;
    }
    
    
}
