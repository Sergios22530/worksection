<?php

namespace sergios\worksectionApi\src\helpers;

use sergios\worksectionApi\src\services\WSRequest;
use Yii;
use yii\helpers\FileHelper;
use Exception;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class ImageHelper
{
    private $directory = '';
    private $path = '';

    const EXPECTED_TYPES = ['jpeg', 'png', 'jpeg'];

    public function __construct()
    {
        $imagePath = @Yii::$app->params['worksection-api']['uploadPath'];
        if (!isset($imagePath)) {
            throw new Exception("Set global params for api! ('worksection-api' => ['uploadPath' => uploadPath])");
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
            $extension = $image->getExtension();
            if (!ArrayHelper::isIn($extension, self::EXPECTED_TYPES)) {
                throw new Exception('Exempted uploaded mine types are ' . implode(',', self::EXPECTED_TYPES));
            }

            $imageName = $this->getFilesCount() . '.' . $extension;
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
     * @return string unique name for image
     */
    private function getFilesCount(): string
    {
        $files = glob($this->directory . "/*");

        if ($files) {
            return count($files) + 1;
        }

        return 0;
    }
}
