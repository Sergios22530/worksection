<?php

namespace sergios\worksectionApi\src\models;

use Exception;
use \ReflectionClass;
use \yii\base\Model;

abstract class WSModel extends Model
{
    private $validationErrors = [];
    private $modelName;

    public function __construct()
    {
        $this->modelName = (new ReflectionClass($this))->getShortName();
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function validateKeys(array $filterParams)
    {
        $modelFieldsKeys = get_object_vars($this);

        foreach ($filterParams as $key => $value) {
            if (ArrayHelper::keyExists($key, $modelFieldsKeys)) {
                array_push($this->validationErrors, "Key {$key} is not defined in model {$this->modelName}!");
            }
        }

        return !!count($this->validationErrors);
    }

    public function isRelevant(array $filterParams)
    {
        if (!$this->validateKeys($filterParams)) {
            $validationErrors = implode("\\n", $this->getValidationErrors());
            throw new Exception("Errors list: {$validationErrors}");
        }

        $relatedAttributes = $this->getRelatedModelsNames();
        foreach ($filterParams as $fieldKey => $fieldValue) {
            //for related entities
            if (in_array($fieldKey, $relatedAttributes)) {
                if ($this->$$fieldKey && !$this->$$fieldKey->isRelevant($fieldValue)) {
                    return false;
                }

                continue;
            }

            //for simple attributes
            if ($this->$$fieldKey !== $fieldValue) {
                return false;
            }
        }

        return true;
    }
}
