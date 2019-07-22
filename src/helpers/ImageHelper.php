<?php

namespace sergios\yii2Worksection\src\helpers;

use Yii;
use yii\helpers\FileHelper;
use Exception;
use yii\web\UploadedFile;

class ImageHelper
{
    private $directory = '';
    private $path = '';

    public function __construct()
    {
        $imagePath = '/uploads/tests';
        if (isset(Yii::$app->params['bugReport']['imagePath'])) {
            $imagePath = Yii::$app->params['bugReport']['imagePath'];
        }

        $this->directory = Yii::getAlias('@webroot') . $imagePath;
        $this->path = Yii::getAlias('@web') . $imagePath;
    }

    /**
     * @param UploadedFile $image
     * @return string - path to file
     * @throws Exception
     */
    public function saveImage(UploadedFile $image): string
    {
        try {
            $imageName = $this->getImageName('png');
            $file = $this->directory . '/' . $imageName;

            FileHelper::createDirectory(FileHelper::normalizePath($this->directory), 775);

            $image->saveAs($file);

            return $file;
        } catch (Exception $e) {
            throw new Exception("Can't save image");
        }
    }

    /**
     * Generate name for image based on files count in directory
     * @param string $type file type (like png, jpg)
     * @return string unique name for image
     */
    private function getImageName(string $type): string
    {
        $filecount = 0;
        $files = glob($this->directory . "/*");
        if ($files) {
            $filecount = count($files) + 1;
        }

        return $filecount . '.' . $type;
    }
}
