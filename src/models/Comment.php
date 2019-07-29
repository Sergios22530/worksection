<?php

namespace sergios\worksectionApi\src\models;

use Exception;
use sergios\worksectionApi\src\helpers\ImageHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
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
    public $date_added; // example  2019-07-24 11:01
    public $fileUrl;

    public $user = null;

    protected $pathToImage = '';
    protected $todo = [];

    public function rules()
    {
        return [
            ['text', 'required'],
            ['user', 'validateUser'],
            [['text', 'fileUrl', 'date_added'], 'string'],
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

    public function saveImage(UploadedFile $image, array $exeptedMineTypes = ['jpeg', 'png', 'jpeg'])
    {
        if (!ArrayHelper::isIn($image->getExtension(), $exeptedMineTypes)) {
            throw new Exception('Exempted uploaded mine types are ' . implode(',', $exeptedMineTypes));
        }
        $imageHelper = new ImageHelper();
        $this->pathToImage = $imageHelper->saveImage($image);
    }

    public function getImage()
    {
        return $this->pathToImage;
    }

    public static function getFilterAttributes()
    {
        return ['text', 'date_added', 'user'];
    }

    public static function getRelatedFilterAttributes()
    {
        return ['email', 'name'];
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

}
