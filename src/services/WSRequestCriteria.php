<?php


namespace sergios\worksectionApi\src\services;


use sergios\worksectionApi\src\models\Comment;
use Yii;

class WSRequestCriteria
{
    private $action;
    private $page = '';
    private $params = [];
    private $filePath = null;


    public function __construct(String $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param $filePath
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @param mixed $page
     * @return WSRequestCriteria
     */
    public function setPage($page)
    {
        $this->page = (!empty($page)) ? $page : '';
        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return String
     */
    public function getAction(): String
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return (!empty($this->params)) ? $this->params : [];
    }


    /**
     * @return string|null
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
