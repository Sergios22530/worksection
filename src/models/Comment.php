<?php

namespace sergios\worksectionApi\src\models;

use Exception;
use sergios\worksectionApi\src\helpers\ImageHelper;
use yii\web\UploadedFile;

class Comment extends WSModel
{
    public $id;
    public $email;
    public $text;
    protected $pathToImage = '';
    protected $todo = [];

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
        return $this->pathToImage;
    }
}
