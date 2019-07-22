<?php

namespace sergios\yii2Worksection\src\traits;

use sergios\yii2Worksection\src\validators\WSApiValidator;


trait WSApiTrait
{
    /**
     * Generate Api hash
     * @return string
     */
    protected function generateHash(): String
    {
        return md5($this->page . $this->action . $this->apiKey);
    }

    /**
     * Generate api request url with http request params
     * @return String
     */
    public function generateApiUrl(): String
    {
        $params = (!empty($this->requestParams)) ? '&' . http_build_query($this->requestParams) : '';
        $hash = $this->generateHash();
        $page = (strlen($this->page) > 0) ? "&page={$this->page}" : $this->page;

        return $this->apiDomain . "/api/admin/?action={$this->action}" . $page . $params . "&hash={$hash}";
    }

    /**
     * Validate projectId, taskId parameters and forming page parameter with (ID_PROJECT, ID_TASK)
     * @param array $requiredParams
     * @return bool
     */
    public function validatePageParam(Array $requiredParams)
    {
        if (!empty($requiredParams)):
            foreach ($requiredParams as $param):
                WSApiValidator::validateStringAttribute($param, $this->{$param});
            endforeach;
        endif;

        $this->setPage($requiredParams);

        return true;
    }
}